<?php

namespace App\Init\Routes;

/**
* Class Router
* @package App\Init\Routes
*/
class Router {

  /**
   * @var string htaccess $_GET
   */
  private $url;

  /**
   * @var array Liste des routes
   */
  private $routes = [];

  /**
   * @var array Routes nommées
   */
  private $namedRoutes = [];

  public function __construct($url) {
    $_GET[$url] = isset($_GET[$url]) ? $_GET[$url] : '/';
    $this->url = $_GET[$url];
  }

  public function get($path, $callable, $name = null) {
    return $this->add($path, $callable, $name, 'GET');
  }

  public function post($path, $callable, $name = null) {
    return $this->add($path, $callable, $name, 'POST');
  }

  public function add($path, $callable, $name, $method) {
    $route = new Route($path, $callable);
    $this->routes[$method][] = $route;
    if(is_string($callable) && $name === null) {
      $this->namedRoutes[$callable] = $route;
    }
    if($name) {
      $this->namedRoutes[$name] = $route;
    }
    return $route;
  }

  public function run() {
    if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
      throw new RouterExceptions('REQUEST_METHOD does not exist.');
    }

    foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
      if($route->match($this->url)) {
        $route->call();
      } else {
        //throw new RouterExceptions('No matching routes.');
      }
    }

  }

  public function getUrl($name, $params = []) {
    if(!isset($this->namedRoutes[$name])) {
      throw new RouterExceptions('No route found with this name.');
    }
    return $this->namedRoutes[$name]->getUrl($params);
  }
}
