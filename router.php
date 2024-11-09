<?php 

class Router {
    private $routes = [
        "/" => "views/signup.php"
    ];
    
    public function transfer($url) {
       if (array_key_exists($url, $this->routes)) {
            require $this->routes[$url]; 
       } else {
            http_response_code(404);
            require "views/404.php";
       } 
    }
}