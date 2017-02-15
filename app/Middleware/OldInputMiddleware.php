<?php

namespace App\Middleware;

//inherits base middleware
class OldInputMiddleware extends Middleware{

	//for slim middleware we have an invoke magic method
	//we pass into here our $request and $response object. And we also have the $next callable middleware
	//it is important that we call the next middleware because it needs to cycle through from the outside
	//of our application much like an onion into the core.

	public function __invoke($request,$response,$next){	
		
		$this->container->view->getEnvironment()->addGlobal('old',$_SESSION['old']);

		$_SESSION['old'] = $request->getParams();

		
		//after state has changed
		$response = $next($request,$response);
	
		return $response;
	

	}
}	
