<?php

namespace App\Controllers;

//import model name
use App\Models\Landing_Page;


//necessary because we are passing slim views instance
use Slim\Views\Twig as View;

class LandingController extends Controller{


	public function index($request, $response){
	 //now we can use this view object and render the views
	//we now have access to our whole container because we have the container in our base controller

		$landingPage = Landing_Page::all();

    var_dump($landingPage);
    die();



	}
}
