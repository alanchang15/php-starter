<?php

use Illuminate\Support\ServiceProvider;

abstract class Module extends ServiceProvider
{
    private $module;

    public function boot()
    {
        if ($module = $this->getModule(func_get_args()))
        {
            $this->module = $module;
            App::twig_loader()->addPath(APP_DIR . 'modules/' . 
                $this->getModuleAccesor() . '/Views/'
            );
        }        

        $this->register();
    }

    public function getModule($args)
    {
        $module = (isset($args[0]) and is_string($args[0])) ? $args[0] : null;
 
        return ucfirst($module);
    }

    public function getModuleNamespace()
    {
        $reflection = new ReflectionClass($this);
        return $reflection->getName();
    }

    public function getModuleAccesor()
    {
        return $this->module;
    }

}