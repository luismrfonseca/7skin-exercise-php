<?php
require 'vendor/autoload.php';

// Looing for .env at the root directory
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    
  $r->addRoute('GET', '/', 'Welcome/hello');

  $r->addRoute('GET', '/persons/', 'PersonController/getAllPersons');

  $r->addRoute('POST', '/persons/', 'PersonController/insertPerson');
  
  $r->addRoute('GET', '/persons/{id:\d+}', 'PersonController/getPerson');
  
  $r->addRoute('DELETE', '/persons/{id:\d+}', 'PersonController/deletePerson');

});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
  $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
  case FastRoute\Dispatcher::NOT_FOUND:
    die('NOT_FOUND');
    // ... 404 Not Found
    break;
  case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
    $allowedMethods = $routeInfo[1];
    // ... 405 Method Not Allowed
    die('Not Allowed');
    break;
  case FastRoute\Dispatcher::FOUND:
    $handler = $routeInfo[1];
    $vars = [];
    if($httpMethod == 'POST'){
      $vars = json_decode(file_get_contents("php://input"));
    } else {
      $vars = $routeInfo[2];
    }
    list($class, $method) = explode("/", $handler, 2);
    try {
      $reuslt = call_user_func_array(array(new $class, $method), array(&$vars));
      echo json_encode(array('status' => 'sucess', 'data' => $reuslt));
      exit;
    } catch (\Exception $e) {
      echo json_encode(array('status' => 'error', 'data' => $e->getMessage()));
      exit;
    }
    break;
}