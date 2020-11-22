<?php 

class Router {

    private $requestMethods = [
        "GET"
    ];
    private $defaultHandler = null;


    //initialize every supported method listed on $requestMethods property
    public function __construct() {
        foreach($this->requestMethods as $method) {
            $this->{strtolower($method)} = array();
        }
    }

    /* 
     This methods filters available http verbs, duplicated routes and
     registers the method on specified route.
     */
    public function __call($httpMethod, $arguments) {
        list($route, $handler) = $arguments;

        if(in_array(strtoupper($httpMethod), $this->requestMethods)) {
            if(!in_array($route, $this->{strtolower($httpMethod)})) {
                $this->{strtolower($httpMethod)}[$route] = $handler;
                return true;
            }

            throw new Exception("$httpMethod $route already implemented");
        }

        throw new Exception("$httpMethod method not allowed");
    }

    public function registerDefaultHandler(callable $handler) {
        $this->defaultHandler = $handler;
    }

    private function defaultRequestHandler() {
        if(!is_null($this->defaultHandler)) {
            call_user_func($this->defaultHandler);
        } else {
            http_response_code(404);
            echo "Page not found";
        }      
    }

    /**
     * Resolves a route
     */
    private function resolve()
    {
        $methods = $this->{strtolower($_SERVER['REQUEST_METHOD'])};
        $route = $_SERVER['REQUEST_URI'];

        if(!array_key_exists($route, $methods))
        {
            $this->defaultRequestHandler();
            return;
        }

        echo json_encode(call_user_func($methods[$route]));
    }

    public function __destruct()
    {
        $this->resolve();
    }
}