<?php

namespace Core;
/**
 * Router
 */

class Router
{
	protected $routers = [];

	protected $params = [];


	/**
	 * Add a route to routing table
	 */
	public function add($route, $params = [])
	{
		// escape forward slashes
		$route = preg_replace('/\//','\\/',$route);
		// covert variables {**}
		$route = preg_replace('/\{([a-z]+)\}/','(?P<\1>[a-z-]+)', $route); 
		// convert variables with custom regular expressions e.g. {id:d+}
		$route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
		// add start and end delimiters and case insensitive
		$route = '/^' . $route . '$/i';

		$this->routers[$route] = $params;

	}

	/**
	 * Match the route in the routing table
	 */

	public function match($url)
	{
		$url = $this->removeQueryStringVariables($url);
		foreach ($this->routers as $route => $params) {
			if(preg_match($route,$url,$matches)){

				foreach ($matches as $key => $match) {
					if(is_string($key)){
						$params[$key] = $match;
					}
				}

				$this->params = $params;
				return true;
			}
		}

		return false;
	}

	/**
	 * Dispatch the route, creating & call the controller object and action method.
	 */

	public function dispatch($url)
	{
		if($this->match($url)){
			$controller = $this->params['controller'];
			$controller = $this->toStudlyCaps($controller);
			//$controller = "App\Controllers\\$controller";
			$controller = $this->getNamespace().$controller;

			if(class_exists($controller)){
				$controller_object = new $controller($this->params);

				$action = $this->params['action'];
				$action = $this->toCamelCase($action);

				if(is_callable([$controller_object,$action])){
					$controller_object->$action();
				}else{
					//echo "Method $action in controller $controller not found";
					throw new \Exception("Method $action in controller $controller not found");
					
				}
			}else{
				//echo "controller $controller not found";
				throw new \Exception("controller $controller not found");
				
			}
		}else{
			//echo "No route matched";
			throw new \Exception("No route matched",404);
			
		}
	}

	/**
	 * Convert the string with hyphens '-' to StudlyCaps
	 */
	protected function toStudlyCaps($string)
	{
		return str_replace(' ','', ucwords(str_replace('-',' ',$string)));
	}

	/**
	 * Convert the string with hyphens '-' to camelCase
	 */

	protected function toCamelCase($string)
	{
		return lcfirst($this->toStudlyCaps($string));
	}

	protected function removeQueryStringVariables($url)
	{
		if($url != '')
		{
			$parts = explode('&',$url,2);

			if(strpos($parts[0],'=') === false){
				$url = $parts[0];
			}else{
				$url = '';
			}
		}

		return $url;
	}


	public function getRoutes()
	{
		return $this->routers; 
	}

	public function getParams()
	{
		return $this->params;
	}

	protected function getNamespace()
	{
		$namespace = 'App\Controllers\\';

		if (array_key_exists('namespace',$this->params)) {
			$namespace .= $this->params['namespace'] . '\\';

		}

		return $namespace;
	}


}



