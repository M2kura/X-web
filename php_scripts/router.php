<?php 
/**
 * Router class is responsible for the routing
 * across the whole app
 *
 * @var array $routes The list of all available routes
 */
class Router {
    private $routes = [
        "/~teterheo/" => __DIR__ . "/../views/login.php",
        "/~teterheo/home" => __DIR__ . "/../views/home_page.php",
        "/~teterheo/profile" => __DIR__ . "/../views/profile_page.php"
    ];
    /**
     * Translates the given uri into a valid route from the list
     * and redirects to it
     *
     * @param string $uri Uri needed to be translated
     */
    public function transfer($uri) {
        if (array_key_exists($uri, $this->routes)) {
            require $this->routes[$uri];  
        } else {
            http_response_code(404);
            require __DIR__ . "/../views/404.php";
        }
    }
}

$router = new Router();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->transfer($uri);
