<?php

namespace SoftHouse\AuthTracker\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use SoftHouse\AuthTracker\Models\PersonalAccessToken;

class PersonalAccessTokenLogout
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public PersonalAccessToken $personalAccessToken;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PersonalAccessToken $personalAccessToken)
    {
        $this->personalAccessToken = $personalAccessToken;
    }
}
