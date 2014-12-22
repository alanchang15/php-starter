<?php

class Executor extends Pux\Executor
{
    public static function execute($route = '')
    {
        if (!isset($_SERVER['PATH_INFO'])) 
            $_SERVER['PATH_INFO'] = '/';
            
        $path_info = $_SERVER['PATH_INFO'];
        
        $part = explode('/', $path_info);

        if (file_exists(APP_DIR . 'routes.php')) {
            $route = Route::dispatch($path_info);
        }
        else {
            if (empty($part[1]) AND empty($part[2])) {
                $controller = 'HomeController';
                $action = 'indexAction';
                $route = array(
                    '',
                    $path_info,
                    array($controller, $action),
                    array('method', 1)
                );
            }
            else {
                $controller = ucfirst($part[1]) . 'Controller';
                $action = (!empty($part[2]))
                    ? $part[2] . 'Action'
                    : 'indexAction';
                    
                $route = array(
                    '',
                    $path_info,
                    array($controller, $action),
                    array('method', 1)
                );            
            }
        }

        list($pcre,$pattern,$cb,$options) = $route;

        if (!is_array($cb)) {
            if (is_callable($cb)) {
                $reflection = new ReflectionFunction($cb);
                $rps = $reflection->getParameters();

                $vars = isset($options['vars'])
                        ? $options['vars']
                        : array()
                        ;

                $arguments = array();
                foreach( $rps as $param ) {
                    $n = $param->getName();
                    if( isset( $vars[ $n ] ) )
                    {
                        $arguments[] = $vars[ $n ];
                    }
                    else if( isset($route[3]['default'][ $n ] )
                                    && $default = $route[3]['default'][ $n ] )
                    {
                        $arguments[] = $default;
                    }
                    else if( ! $param->isOptional() && ! $param->allowsNull() ) {
                        throw new Exception('parameter is not defined.');
                    }
                }                
                // print_r($arguments); die;
                return call_user_func_array($cb, $arguments);
            }
        }
        return parent::execute($route);
    }    
}