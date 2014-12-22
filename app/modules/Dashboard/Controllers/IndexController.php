<?php

namespace Modules\Dashboard\Controllers;

use App;
use View;

class IndexController extends ControllerBasse
{
    public function indexAction()
    {
        // echo App::get('base_url');
        // echo App::get('flight.views.path');
        View::display('dashboard.twig');
        // print_r($GLOBALS['app']['twig']);
    }
}