<?php

namespace SoftHouse\AuthTracker\Models;

use App\Features\Team\TeamScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
use SoftHouse\AuthTracker\Events\PersonalAccessTokenCreated;
use SoftHouse\MonitoringService\RequestContext;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'token',
        'abilities',
        'ip',
        'ip_info',
        'device',
        'expires_at',
        'last_used_at',
        'tokenable_type',
        'tokenable_id'
    ];

    protected $casts = [
        'abilities' => 'json',
        'ip_info' => 'json',
        'device' => 'json',
        'expires_at' => 'datetime',
        'last_used_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($personalAccessToken) {


            $personalAccessToken->forceFill([
                'ip' => RequestContext::getIP(),
                'ip_info' => RequestContext::getInfoIP(),
                'device' => RequestContext::getDevice(),
            ]);

            if ($minutes = config('sanctum.expiration')) {
                $personalAccessToken->expiresAt(Carbon::now()->addMinutes($minutes));
            }

        });

        static::created(function ($personalAccessToken){
            event(new PersonalAccessTokenCreated($personalAccessToken));
        });
    }

    public function tokenable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo('tokenable')->withoutGlobalScope(new TeamScope());
    }
}
