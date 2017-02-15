<?php

namespace App\Controllers;

use App\Models\About_Us;
use App\Models\Home_Page;
use App\Models\What_We_Do_Info;
use App\Models\Port_Page;
use App\Controllers\Controller;
use App\Models\What_We_Do;
//import validator
use Respect\Validation\Validator as v;

class AdminController extends Controller{

	public function getUpdateSite($request,$response){
		return $this->view->render($response,'admin.twig');
	}



	public function getHomeCreate($request,$response){
		return $this->view->render($response,'admin-home.twig');
	}

	public function postHomeCreate($request,$response){


        $home_page = Home_Page::create([
              'home_img' => $request->getParam('home_img'),
          ]);
				if ($home_page) {
					$this->flash->addMessage('success','You have added item to home page');
        	return $response->withRedirect($this->router->pathFor('admin.update'));
				} else {
					$this->flash->addMessage('error','You have not added item to home page');
        	return $response->withRedirect($this->router->pathFor('admin.update'));
				}

	}



	public function getHomeUpdate($request,$response){
		return $this->view->render($response,'admin-home-update.twig');
	}

	public function postHomeUpdate($request,$response){

        $id = $request->getParam('id');
				$home_page = Home_Page::where("id",$id)->first();
				$new_home_data = array(
					'home_img' => $request->getParam('home_img')
				);

        if ($home_page->fill($new_home_data) && $home_page->save()) {

            $this->flash->addMessage('success','You have updated Home page');

		    		return $response->withRedirect($this->router->pathFor('admin.update'));

        } else {

            $this->flash->addMessage('error','You have not updated home');

            return $response->withRedirect($this->router->pathFor('admin.update'));
        }


	}

}
