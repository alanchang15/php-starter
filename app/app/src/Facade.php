<?php

class Facade extends Illuminate\Support\Facades\Facade
{
    public static function registerAliases($aliases = null)
    {
        if (!$aliases) {
            $aliases = array(
                'App' => 'Facades\AppFacade',
                'Route' => 'Facades\RouteFacade',     
                'View' => 'Facades\ViewFacade',
                'Event' => 'Facades\EventFacade',
                'Model' => 'Illuminate\Database\Eloquent\Model',
                // 'Session' => 'Facade\SessionFacade',
                // 'Request' => 'Facade\RequestFacade',
                // 'Response' => 'Facade\ResponseFacade',
                // 'Input' => 'Facade\InputFacade',
                // 'Event' => 'Facade\EventFacade',
                // 'Acl' => 'Facade\AclFacade',
                // 'Lang' => 'Facade\LangFacade',
                // 'Menu' => 'Facade\MenuFacade',
            );
        }

        foreach ($aliases as $alias => $class) {
            class_alias($class, $alias);
        }
    }

    public static function setFacadeApplication($app)
    {
        if (is_string($app) AND !static::$app)
            static::$app = new $app;
        else
            static::$app = $app;
    }    
}