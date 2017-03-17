<?php

namespace App\Controllers;


use App\Models\Home_Page;

use App\Controllers\Controller;
use Illuminate\Database\Capsule\Manager as DB;
//import validator
use Respect\Validation\Validator as v;

class AdminController extends Controller{

	public function getUpdateSite($request,$response){

		return $this->view->render($response,'admin.twig');
	}


    //Home Create
	public function getHomeCreate($request,$response){


		return $this->view->render($response,'admin-home.twig');
	}

	public function postHomeCreate($request,$response){


				$ul_id = 'home-ul';

				$c = Home_Page::selectRaw('count(*) as count')->where('ul_id','=',$ul_id)->orderBy('count', 'desc')->groupBy('ul_id')->get();

				foreach($c as $obj){
					$ulCount = $obj['count'] + 1;
    			$home_page = Home_Page::create([
	              'home_img' => $request->getParam('home_img'),
								'next_ul' => $request->getParam('next_ul'),

								'ul_id' => $ul_id,
								'ul_update_no' => $ulCount
	        ]);
					if ($home_page) {
						$this->flash->addMessage('success','You have added ' . $home_page->home_img . ' to home page at id no ' . $home_page->ul_update_no . '.');
	        	return $response->withRedirect($this->router->pathFor('admin.update'));
					} else {
						$this->flash->addMessage('error','You have not added ' . $home_page->home_img . ' to home page at id no ' . $home_page->ul_update_no . '.');
	        	return $response->withRedirect($this->router->pathFor('admin.update'));
					}
				}

	}


    //Home Update
	public function getHomeUpdate($request,$response){
		return $this->view->render($response,'admin-home-update.twig');
	}

	public function postHomeUpdate($request,$response){

				$ul_id = "home-ul";
        $id = $request->getParam('ul_update_no');
				$home_page = Home_Page::where("ul_update_no",$id)
															->where("ul_id",$ul_id)
															->first();
				$new_home_data = array(
					'home_img' => $request->getParam('home_img'),
					'next_ul' => $request->getParam('next_ul'),
					'ul_id' => $ul_id
				);

        if ($home_page->fill($new_home_data) && $home_page->save()) {

            $this->flash->addMessage('success','You have updated Home page no ' . $home_page->ul_update_no . '.');

		    		return $response->withRedirect($this->router->pathFor('admin.update'));

        } else {

            $this->flash->addMessage('error','You have not updated home page no ' . $home_page->ul_update_no . '.');

            return $response->withRedirect($this->router->pathFor('admin.update'));
        }


	}

  //Portrait Create
  public function getGalleryCreate($request,$response){
		return $this->view->render($response,'admin-gallery.twig');
	}

	public function postGalleryCreate($request,$response){

		$ul_id = $request->getParam('ul_id');

		$c = Home_Page::selectRaw('count(*) as count')->where('ul_id','=',$ul_id)->orderBy('count', 'desc')->groupBy('ul_id')->get();

		foreach($c as $obj){

			$ulCount = $obj['count'] + 1;

			$gallery = Home_Page::create([
						'home_img' => $request->getParam('home_img'),
						'ul_id' => $ul_id,
						'high_res_img' => $request->getParam('high_res_img'),
						'ul_update_no' => $ulCount
			]);

			if ($gallery) {
							$this->flash->addMessage('success','You have added item to existing ' . $gallery->ul_id .  ' gallery at id no ' . $gallery->ul_update_no . '.');
							return $response->withRedirect($this->router->pathFor('admin.update'));
			} else {
							$this->flash->addMessage('error','You have not added item to existing ' . $gallery->ul_id .  ' gallery at id no ' . $gallery->ul_update_no . '.');
							return $response->withRedirect($this->router->pathFor('admin.update'));
			}

		}
	}

	//Portrait Update
	public function getGalleryUpdate($request,$response){
		return $this->view->render($response,'admin-gallery-update.twig');
	}

	public function postGalleryUpdate($request,$response){

		$id = $request->getParam('ul_update_no');
		$ul_id = $request->getParam('ul_id');
		$galleryUpdate = Home_Page::where("ul_update_no",$id)
								->where("ul_id",$ul_id)
								->first();
		$galleryUpdateData = array(
			'home_img' => $request->getParam('home_img'),
			'next_ul' => $request->getParam('next_ul'),
			'high_res_img' => $request->getParam('high_res_img'),
			'ul_id' => $ul_id
		);


    if ($galleryUpdate->fill($galleryUpdateData) && $galleryUpdate->save()) {

        $this->flash->addMessage('success','You have updated ' . $galleryUpdate->ul_id . ' gallery at id no ' . $galleryUpdate->ul_update_no . '.');

        return $response->withRedirect($this->router->pathFor('admin.update'));

    } else {

        $this->flash->addMessage('error','You have not updated ' . $galleryUpdate->ul_id . ' gallery at id no ' . $galleryUpdate->ul_update_no . '.');

        return $response->withRedirect($this->router->pathFor('admin.update'));
    }


	}

    //Landscape Create
  public function getNewGalleryCreate($request,$response){
		return $this->view->render($response,'admin-new-gallery.twig');
	}

	public function postNewGalleryCreate($request,$response){

				$ul_update_no = 1;
        $newGalleryItem = Home_Page::create([
              'home_img' => $request->getParam('home_img'),
              'ul_id' => $request->getParam('ul_id'),
							'high_res_img' => $request->getParam('high_res_img'),
							'ul_update_no' => $ul_update_no
          ]);
        if ($newGalleryItem) {
                $this->flash->addMessage('success','You have created new gallery ' . $newGalleryItem->ul_id . '.');
                return $response->withRedirect($this->router->pathFor('admin.update'));
        } else {
                $this->flash->addMessage('error','You have not created new gallery ' . $newGalleryItem->ul_id . '.');
                return $response->withRedirect($this->router->pathFor('admin.update'));
        }

	}


    //Landscape Update
	public function getLandscapeUpdate($request,$response){
		return $this->view->render($response,'admin-landscape-update.twig');
	}

	public function postLandscapeUpdate($request,$response){

        $id = $request->getParam('land_id');
        $land_page = Landscape::where("id",$id)->first();
        $new_landscape_data = array(
            'land_img' => $request->getParam('land_img'),
            'land_light_text' => $request->getParam('land_light_text')
        );

        if ($land_page->fill($new_landscape_data) && $land_page->save()) {

            $this->flash->addMessage('success','You have updated landscape page');

            return $response->withRedirect($this->router->pathFor('admin.update'));

        } else {

            $this->flash->addMessage('error','You have not updated landscape page');

            return $response->withRedirect($this->router->pathFor('admin.update'));
        }


	}


    //Miscellaneous Create
    public function getMiscellaneousCreate($request,$response){
		return $this->view->render($response,'admin-miscellaneous.twig');
	}

	public function postMiscellaneousCreate($request,$response){


        $misc_page = Miscellaneous::create([
              'misc_img' => $request->getParam('misc_img'),
              'misc_light_text' => $request->getParam('misc_light_text')
          ]);
        if ($misc_page) {
                $this->flash->addMessage('success','You have added item to Miscellaneous page');
                return $response->withRedirect($this->router->pathFor('admin.update'));
        } else {
                $this->flash->addMessage('error','You have not added item to Miscellaneous page');
                return $response->withRedirect($this->router->pathFor('admin.update'));
        }

	}


    //Miscellanous Update
	public function getMiscellaneousUpdate($request,$response){
		return $this->view->render($response,'admin-miscellaneous-update.twig');
	}

	public function postMiscellaneousUpdate($request,$response){

        $id = $request->getParam('misc_id');
        $misc_page = Miscellaneous::where("id",$id)->first();
        $new_misc_data = array(
            'misc_img' => $request->getParam('misc_img'),
            'misc_light_text' => $request->getParam('misc_light_text')
        );

        if ($misc_page->fill($new_misc_data) && $misc_page->save()) {

            $this->flash->addMessage('success','You have updated Miscellaneous page');

            return $response->withRedirect($this->router->pathFor('admin.update'));

        } else {

            $this->flash->addMessage('error','You have not updated Miscellaneous page');

            return $response->withRedirect($this->router->pathFor('admin.update'));
        }


	}


}
