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

  //Add new item to existing gallery
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
						'ul_update_no' => $ulCount,
						'lightbox_text' => $request->getParam('lightbox_text')
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

	//Update existing gallery
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
			'ul_id' => $ul_id,
			'lightbox_text' => $request->getParam('lightbox_text')
		);


    if ($galleryUpdate->fill($galleryUpdateData) && $galleryUpdate->save()) {

        $this->flash->addMessage('success','You have updated ' . $galleryUpdate->ul_id . ' gallery at id no ' . $galleryUpdate->ul_update_no . '.');

        return $response->withRedirect($this->router->pathFor('admin.update'));

    } else {

        $this->flash->addMessage('error','You have not updated ' . $galleryUpdate->ul_id . ' gallery at id no ' . $galleryUpdate->ul_update_no . '.');

        return $response->withRedirect($this->router->pathFor('admin.update'));
    }


	}

  //create new gallery item
  public function getNewGalleryCreate($request,$response){
		return $this->view->render($response,'admin-new-gallery.twig');
	}

	public function postNewGalleryCreate($request,$response){

				$ul_update_no = 1;
        $newGalleryItem = Home_Page::create([
              'home_img' => $request->getParam('home_img'),
              'ul_id' => $request->getParam('ul_id'),
							'high_res_img' => $request->getParam('high_res_img'),
							'ul_update_no' => $ul_update_no,
							'lightbox_text' => $request->getParam('lightbox_text'),
							'gallery_text' => $request->getParam('gallery_text')
          ]);
        if ($newGalleryItem) {
                $this->flash->addMessage('success','You have created new gallery ' . $newGalleryItem->ul_id . '.');
                return $response->withRedirect($this->router->pathFor('admin.update'));
        } else {
                $this->flash->addMessage('error','You have not created new gallery ' . $newGalleryItem->ul_id . '.');
                return $response->withRedirect($this->router->pathFor('admin.update'));
        }

	}

	//create contact page Info
	public function getNewContactCreate($request,$response){
		return $this->view->render($response,'admin-contact.twig');
	}

	public function postNewContactCreate($request,$response){

				$newContactItem = Contact_Page::create([
							'about_us' => $request->getParam('about_us')

					]);
				if ($newContactItem) {
								$this->flash->addMessage('success','You have created new about us section');
								return $response->withRedirect($this->router->pathFor('admin.update'));
				} else {
								$this->flash->addMessage('error','You have not created new about us section');
								return $response->withRedirect($this->router->pathFor('admin.update'));
				}

	}



}
