<?php

namespace Facades;

use Facade;
use Twig_Loader_Filesystem;
use Twig_Environment;

class ViewFacade extends Facade
{
    public static function __callStatic($name, $args)
    {
        if (method_exists(self::$app['twig'], $name))
            return call_user_func_array(self::$app['twig'], $name, $args);
    }

    public static function display($template, $data = array())
    {      
        echo self::$app->render($template, $data);
    }
}