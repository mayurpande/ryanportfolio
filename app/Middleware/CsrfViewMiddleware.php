<?php

namespace App\Middleware;

//inherits base middleware
class CsrfViewMiddleware extends Middleware{

	//for slim middleware we have an invoke magic method
	//we pass into here our $request and $response object. And we also have the $next callable middleware
	//it is important that we call the next middleware because it needs to cycle through from the outside
	//of our application much like an onion into the core.

	public function __invoke($request,$response,$next){	
		
		$this->container->view->getEnvironment()->addGlobal('csrf', [
			'field' => '
				
			<input type="hidden" name="' . $this->container->csrf->getTokenNameKey() . '" value="' . $this->container->csrf->getTokenName() .'">
						
			<input type="hidden" name="' . $this->container->csrf->getTokenValueKey() . '" value="' . $this->container->csrf->getTokenValue() .'">
				
			
			',
		]);		
		//after state has changed
		$response = $next($request,$response);
	
		return $response;
	

	}
}
