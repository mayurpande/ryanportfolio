<?php

namespace App\Controllers;

class Controller{

	protected $container;

	//need to accept container from bootstrap app file
	public function __construct($container){
		$this->container = $container;
	}

	/*in our home controller when try and access view it will be passed into our method below. We then check if view exists in our container using the conditional. Which it does and then we return that item on the container and then we have access to it. note this is not good practise */


	public function __get($property){
		if($this->container->{$property}){
			return $this->container->{$property};
		}
	}
}
