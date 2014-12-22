<?php

namespace Facades;

use Facade;

class RouteFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'route';
    }
}