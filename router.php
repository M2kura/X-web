<?php 

class Router {
    private $routes = [
        "/~teterheo/" => __DIR__ . "/views/login.php",
    ];
    
    public function transfer($uri) {
        echo $uri;
        if (array_key_exists($uri, $this->routes)) {
            require $this->routes[$uri];  
        } else {
            http_response_code(404);
            require __DIR__ . "/views/404.php";
        } 
    }
}

$router = new Router();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->transfer($uri);