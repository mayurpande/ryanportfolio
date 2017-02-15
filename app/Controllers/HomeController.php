<?php

namespace App\Controllers;

//import model name
use App\Models\Home_Page;

//necessary because we are passing slim views instance
use Slim\Views\Twig as View;

class HomeController extends Controller{
	

	public function index($request, $response){
	 //now we can use this view object and render the views
	//we now have access to our whole container because we have the container in our base controller 
		$homePage = Home_Page::all();
		foreach($homePage as $id){
			$homeItem = $id->id;
		}

        return $this->view->render($response, 'home.twig', ['homePage' => $homePage,'homeItem' => $homeItem]);
	}
}

