<?php

namespace Modules;

use App;
use Module;
use Route;
use View;

class Dashboard extends Module
{
    public function boot()
    {
        parent::boot('dashboard');
    }

    public function register()
    {
        $this->registerRoutes();
        $this->registerAdminMenu();
        // View::addExtension(new \Twig_Extension_Debug);
    }

    public function registerRoutes()
    {
        $namespace = $this->getModuleNamespace() . '\\Controllers\\';
        Route::add('/admin', $namespace . 'IndexController:indexAction');        
    }

    public function registerAdminMenu()
    {

    }
}