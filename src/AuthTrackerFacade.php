<?php

namespace SoftHouse\AuthTracker;

use Illuminate\Support\Facades\Facade;


class AuthTrackerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'authtracker';
    }
}
