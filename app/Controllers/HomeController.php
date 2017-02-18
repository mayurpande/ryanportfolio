<?php

namespace App\Controllers;

//import model name
use App\Models\Home_Page;
use App\Models\Portrait;
use App\Models\Landscape;
use App\Models\Miscellaneous;

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
        
        $portPage = Portrait::all();
        foreach($portPage as $ids){
            $portItem = $ids->ids;
        }
        
        $landPage = Landscape::all();
        foreach($landPage as $idss){
            $landItem = $idss->idss;
        }
    
        $miscPage = Miscellaneous::all();
        foreach($miscPage as $idsss){
            $miscItem = $idsss->idsss;
        }

        return $this->view->render($response, 'home.twig', [
            'homePage' => $homePage,
            'homeItem' => $homeItem,
            'portPage' => $portPage,
            'portItem' => $portItem,
            'landPage' => $landPage,
            'landItem' => $landItem,
            'miscPage' => $miscPage,
            'miscItem' => $miscItem
            
        ]);
	}
}

