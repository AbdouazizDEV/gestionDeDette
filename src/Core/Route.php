<?php
namespace Core;

class Route {
    private static $routes = [];
    private static $autoRouting = true;

    public static function disableAutoRouting() {
        self::$autoRouting = false;
    }

    public static function get($pattern, $callback) {
        self::$routes['GET'][$pattern] = $callback;
    }

    public static function post($pattern, $callback) {
        self::$routes['POST'][$pattern] = $callback;
    }

    public static function run() {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $method = $_SERVER['REQUEST_METHOD'];

        foreach (self::$routes[$method] as $pattern => $callback) {
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $pattern);
            if (preg_match('#^' . $pattern . '$#', $uri, $matches)) {
                array_shift($matches); // Remove full match
                if (is_array($callback)) {
                    $controller = new $callback[0]();
                    call_user_func_array([$controller, $callback[1]], $matches);
                } else {
                    list($controller, $method) = explode('@', $callback);
                    call_user_func_array([new $controller, $method], $matches);
                }
                return;
            }
        }

        // Si aucune route ne correspond, afficher une erreur 404
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
    }
}
