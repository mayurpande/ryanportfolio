<?php

namespace App\Middleware;

session_start();

//inherits base middleware
class ValidationErrorsMiddleware extends Middleware{

	//for slim middleware we have an invoke magic method
	//we pass into here our $request and $response object. And we also have the $next callable middleware
	//it is important that we call the next middleware because it needs to cycle through from the outside
	//of our application much like an onion into the core.

	public function __invoke($request,$response,$next){	
		//before state has changed
		/* over here we take errors from session validator
		 * and then place errors into our views
		 *
		 * addGlobal takes two parameter, the first is the name the second is the actual global var in 
		 * this case its the $_SESSION['errors']
		 */
		$this->container->view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);
			
		//we unset the session as we no longer need it
		unset($_SESSION['errors']);
		
		//after state has changed
		$response = $next($request,$response);
	
		return $response;
	

	}
}	


