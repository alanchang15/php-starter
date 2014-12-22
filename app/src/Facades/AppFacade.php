<?php

namespace Facades;

use Facade;

class AppFacade extends Facade
{
    protected static function getFacadeAccessor() 
    { 
        return self::$app; 
    }
}