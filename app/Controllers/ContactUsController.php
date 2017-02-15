<?php

namespace App\Controllers;

//necessary because we are passing slim views instance
use Slim\Views\Twig as View;

class ContactUsController extends Controller{
	

	public function index($request, $response){
	 //now we can use this view object and render the views
	//we now have access to our whole container because we have the container in our base controller 
		return $this->view->render($response, 'contact-us.twig');
	}
}
