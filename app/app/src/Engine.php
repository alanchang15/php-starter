<?php

use flight\Engine as FlightEngine,
    Illuminate\Database\Capsule\Manager as DatabaseManager;

class Engine extends FlightEngine implements ArrayAccess
{
    public $twig_loader, $twig;

    public function __construct()
    {
        parent::__construct();
        $this->_initialize();
    }
    
    public function offsetExists($name)
    {
        return $this->loader->load($name);
    }

    public function offsetGet($name)
    {
        return $this->loader->load($name) ? $this->loader->load($name) : null;
    }

    public function offsetSet($name, $value)
    {
        $this->loader->register($name, $value);
    }

    public function offsetUnset($name)
    {
        $this->loader->unregister($name);
    }
    
    private function _initialize()
    {
        $app = $this;
        
        $app['route'] = 'Pux\Mux';
        $app['twig_loader'] = 'Twig_Loader_Filesystem';

        $app->set('base_url', function()
        {
            return 'http://' . $_SERVER['HTTP_HOST'] . '/';
        });
        $app->set('flight.views.path', VIEW_DIR);        
        $app->_config();        
        
        $app->map('render', function($template, $data = array()) use($app)
        {
            $twig_loader = $app['twig_loader'];
            $twig = new Twig_Environment($twig_loader, array(
                'cache' => STORAGE_DIR . 'cache/view',
                'debug' => true,
            ));
            
            $twig_loader->addPath($app->get('flight.views.path'));       
        
            return $twig
                ->loadTemplate($template)
                ->render($data); 
        });               
    }

    private function _config()
    {
        $config = array();
        $files = glob(APP_DIR . 'config/*.php');
        foreach ($files as $file) {
            $config = include($file);
            $this->set(basename($file, '.php'), $config);
        }
    }

    public function bootModules()
    {
        $modules = glob(APP_DIR . 'modules/*/*.php');
        foreach ($modules as $module) {
            $class = '\\Modules\\' . basename($module, '.php');
            $module = new $class($this);
            $module->boot();
        }        
    }        

    public function bootEloquent($config)
    {
        $this->register('db',function() {
            return new DatabaseManager;
        });

        $this->register('pdo', function() {
            $pdo = $this->db()->connection()->getPdo();
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            return $pdo;
        });            

        $this->db()->addConnection($config['connections'][$config['default']]);
        $this->db()->setAsGlobal();
        $this->db()->bootEloquent();
    }
    
	public function registerEvent($name, $callback)
	{
		$this->dispatcher->set($name, $callback);		
	}

	public function triggerEvent($name, $data = array())
	{
		if ($this->dispatcher->has($name))
			return call_user_func_array($this->dispatcher->get($name), array($data));
		else
		    return $data;
	}    

    public function _start()    
    {
        try {
            if (ob_get_length() > 0) {
                $this->response()->write(ob_get_clean());
            }        

            ob_start();

            $this->handleErrors($this->get('flight.handle_errors'));

            if ($this->request()->ajax) {
                $this->response()->cache(false);
            }        

            $self = $this;
            $this->after('start', function() use($self) 
            {
                $self->stop();
            });                 
            
            $this->response()->write(Executor::execute());
        }
        catch (Exception $e) {
            $this->notFound();
            // throw $e;
        }        
    }
}