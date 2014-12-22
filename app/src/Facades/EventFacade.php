<?php

namespace Facades;

use Facade;

class EventFacade extends Facade
{
    public static function register($name, $callback)
    {
        return self::$app->registerEvent($name, $callback);
    }
    
    public static function trigger($name, $data = array())
    {
        return self::$app->triggerEvent($name, $data);
    }
}