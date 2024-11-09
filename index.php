<?php

require "router.php";

$router = new Router();

$uri = parse_str($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->transfer($uri);