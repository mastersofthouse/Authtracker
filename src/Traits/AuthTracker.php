<?php

namespace SoftHouse\AuthTracker\Traits;

use SoftHouse\AuthTracker\Events\PersonalAccessTokenLogout;

trait AuthTracker
{
    public function logout($personalAccessTokenId = null): bool
    {
        if($personalAccessTokenId != null){
            $personalAccessTokenId = $this->tokens()->find($personalAccessTokenId);
        }else{
            $personalAccessTokenId = $this->currentAccessToken();
        }
        event(new PersonalAccessTokenLogout($personalAccessTokenId));
        return $personalAccessTokenId->delete();
    }

    public function logoutOthers(): bool
    {
        $personalAccessTokensId = $this->tokens()->where('id', '<>', $this->currentAccessToken()->id)->get();

        foreach ($personalAccessTokensId as $item) {
            event(new PersonalAccessTokenLogout($item));
            $item->delete();
        }
        return true;
    }

    public function logoutAll(): bool
    {
        $personalAccessTokensId = $this->tokens()->get();

        foreach ($personalAccessTokensId as $item) {
            event(new PersonalAccessTokenLogout($item));
            $item->delete();
        }
        return true;
    }
}
