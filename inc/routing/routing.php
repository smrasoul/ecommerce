<?php

// Global array to store the routes
$routes = [];

// Function to define a route
function add_route($method, $route, $callback)
{
    global $routes;
    $routes[] = ['method' => $method, 'route' => $route, 'callback' => $callback];
}

// Function to handle the request
function handle_request()
{
    global $routes;

    // Get the HTTP request method and URI
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // Iterate over the routes and find a match
    foreach ($routes as $route) {
        // If the method and the route match
        if ($route['method'] === $requestMethod && preg_match("#^{$route['route']}$#", $requestUri, $matches)) {
            // Call the route handler with any matched parameters
            array_shift($matches); // Remove the full match (first element)
            call_user_func_array($route['callback'], $matches);
            return;
        }
    }

    // If no route is matched, return a 404 error
    http_response_code(404);
    echo "404 Not Found";
}
