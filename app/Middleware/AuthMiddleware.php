<?php

namespace App\Middleware;

//inherits base middleware
class AuthMiddleware extends Middleware{

	//for slim middleware we have an invoke magic method
	//we pass into here our $request and $response object. And we also have the $next callable middleware
	//it is important that we call the next middleware because it needs to cycle through from the outside
	//of our application much like an onion into the core.

	public function __invoke($request,$response,$next){	
		
	
        //check if the user is signed in
        if (!$this->container->auth->check()) {
            
            //flash a message
            $this->container->flash->addMessage('error','Please sign in before doing that');
            
            //if they are not logged in we want to redirect them
            return $response->withRedirect($this->container->router->pathFor('auth.signin'));
        }

        
        
        //after state has changed
		$response = $next($request,$response);
	
		return $response;
	

	}
}
