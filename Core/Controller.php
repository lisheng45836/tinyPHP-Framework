<?php

namespace Core;

/**
 * Base Controller
 */

abstract class Controller
{
	protected $route_params = [];

	public function __construct($route_params)
	{
		$this->route_params = $route_params;
	}

	public function __call($name, $arguments)
	{
		$method = $name . 'Action';

		if(method_exists($this,$method)){
			if($this->before() !== false){
				call_user_func_array([$this,$method],$arguments);
				$this->after();
			}
		}else{
			//echo "Method $method not found in controller " .get_class($this);
			throw new \Exception("Error $method not found in controller".get_class($this));
			
		}
	}

	protected function before(){

	}

	protected function after(){
		
	}
  }