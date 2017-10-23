<?php

namespace App\Controllers;


use App\Models\Home_Page;
use App\Models\Contact_Page;
use App\Models\About_Page;
use App\Models\Landing_Page;




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
								'ul_update_no' => $ulCount,
								'font_logo' => $request->getParam('font_logo'),
								'orientation' => 'landscape'
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

				// $nextUlObj = Home_Page::selectRaw('next_ul')->where('ul_update_no','=',$id)
				// 																			->where('ul_id','=',$ul_id)
				//   			    													->get();
				// $nextUl = '';
				// foreach($nextUlObj as $i){
				// 		$nextUl = $i['next_ul'];
				// }

				$home_page = Home_Page::where("ul_update_no",$id)
															->where("ul_id",$ul_id)
															->first();

				$new_home_data = array(
					'home_img' => $request->getParam('home_img'),
					'next_ul' => $request->getParam('next_ul'),
					'font_logo' => $request->getParam('font_logo'),

					'ul_id' => $ul_id,
					'orientation' => 'landscape'
				);

				if ($home_page->fill($new_home_data) && $home_page->save()) {

					//$delNextUl = Home_Page::where("ul_id",$nextUl)->delete();
					//unlink('img/' . $checkedCheckbox);

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

			$ulCount = $obj['count'];

			$gallery = Home_Page::create([
						'home_img' => $request->getParam('home_img'),
						'ul_id' => $ul_id,
						'high_res_img' => $request->getParam('high_res_img'),
						'ul_update_no' => $ulCount,
						'lightbox_text' => $request->getParam('lightbox_text'),
						'orientation' => $request->getParam('orientation')

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
			'lightbox_text' => $request->getParam('lightbox_text'),
			'gallery_text' => $request->getParam('gallery_text'),
			'orientation' => $request->getParam('orientation')
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

				$ul_update_no_text = 0;
				$ul_update_no_first = 1;

				$newGalleryText = Home_Page::create([
              'gallery_text' => $request->getParam('gallery_text'),
							'ul_id' => $request->getParam('ul_id'),
							'ul_update_no' => $ul_update_no_text,
							'orientation' => 'landscape'

        ]);

				$newGalleryItem = Home_Page::create([
							'home_img' => $request->getParam('home_img'),
							'ul_id' => $request->getParam('ul_id'),
							'high_res_img' => $request->getParam('high_res_img'),
							'ul_update_no' => $ul_update_no_first,
							'lightbox_text' => $request->getParam('lightbox_text'),
							'orientation' => $request->getParam('orientation')
					]);



        if ($newGalleryText && $newGalleryItem) {
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

			$newContactItem = Contact_Page::where("id",1)->first();

			$contactData = array(
				'about_text' => $request->getParam('about_text')

			);


			if ($newContactItem->fill($contactData) && $newContactItem->save()) {
							$this->flash->addMessage('success','You have created new contact section');
							return $response->withRedirect($this->router->pathFor('admin.update'));
			} else {
							$this->flash->addMessage('error','You have not created new contact section');
							return $response->withRedirect($this->router->pathFor('admin.update'));
			}

	 }

	 //create contact page Info
	 public function getNewAboutCreate($request,$response){
		 return $this->view->render($response,'admin-about.twig');
	 }

	 public function postNewAboutCreate($request,$response){

			 $newAboutItem = About_Page::where("id",1)->first();

			 $aboutData = array(
				 'about_text' => $request->getParam('about_text')

			 );


			 if ($newAboutItem->fill($aboutData) && $newAboutItem->save()) {
							 $this->flash->addMessage('success','You have created new about section');
							 return $response->withRedirect($this->router->pathFor('admin.update'));
			 } else {
							 $this->flash->addMessage('error','You have not created new about section');
							 return $response->withRedirect($this->router->pathFor('admin.update'));
			 }

		}

		//create landing page img
		public function getNewLandingCreate($request,$response){
			return $this->view->render($response,'admin-landing.twig');
		}

		public function postNewLandingCreate($request,$response){

			$landing = Landing_Page::create([
						'landing_img' => $request->getParam('landing_img')
			]);

			if ($landing) {
							$this->flash->addMessage('success','You have added image ' . $landing->landing_img . ' to landing page gallery');
							return $response->withRedirect($this->router->pathFor('admin.update'));
			} else {
							$this->flash->addMessage('error','You have not added image ' . $landing->landing_image . ' to landing page gallery');
							return $response->withRedirect($this->router->pathFor('admin.update'));
			}



		 }

		 public function getLandingDelete($request,$response){
			 $landPage = Landing_Page::all();
			 foreach($landPage as $id){
				 $landItem = $id->id;
			 }
			 return $this->view->render($response, 'admin-landing-delete.twig', [
						'landPage' => $landPage,
						'landItem' => $landItem

				]);
		 }

		 public function postLandingDelete($request,$response){
			 $checkedCheckboxes = $request->getParam('land_img');

			 $delNumber = [];
			 foreach($checkedCheckboxes as $checkedCheckbox){
				  $deleteLandImg = Landing_Page::where("landing_img",$checkedCheckbox)->delete();
					unlink('img/' . $checkedCheckbox);
					array_push($delNumber,$deleteLandImg);
			 }
			 if(count($checkedCheckboxes) === count($delNumber)){
				 $this->flash->addMessage('success','You have deleted images from landing page gallery');
				 return $response->withRedirect($this->router->pathFor('admin.update'));
			 }else{
				 $this->flash->addMessage('error','You have not added deleted imgage from landing page gallery');
				 return $response->withRedirect($this->router->pathFor('admin.update'));

			 }
		 }

		 public function getGalleryDelete($request,$response){
			 $homePage = Home_Page::all();
			 foreach($homePage as $id){
				 $homeItem = $id->id;
			 }
			 return $this->view->render($response, 'admin-gallery-delete.twig', [
						'homePage' => $homePage,
						'homeItem' => $homeItem

				]);
		 }

		 public function postGalleryDelete($request,$response){
			 $checkedCheckboxes = $request->getParam('home_img');



			 $ulIds = [];
			 $delNumber = [];
			 foreach($checkedCheckboxes as $checkedCheckbox){
				  $ulId = Home_Page::selectRaw('ul_id')->where("id","=",$checkedCheckbox)->get();
					foreach($ulId as $id){
						array_push($ulIds,$id['ul_id']);
					}

					$deleteLandImg = Home_Page::where("id",$checkedCheckbox)->delete();
					unlink('img/' . $checkedCheckbox);
					array_push($delNumber,$deleteLandImg);
			 }
			 if(count($checkedCheckboxes) === count($delNumber)){
				 foreach($ulIds as $ulId){
					 $updateUlIdInfo = Home_Page::where('ul_id','=',$ulId)->where('ul_update_no','!=',0)->get();
					 $intUlIds = [];
					 foreach($updateUlIdInfo as $update){
					 	 array_push($intUlIds,$update['ul_update_no']);
					 }

					 $count = 1;
					 foreach($intUlIds as $intUlId){
						 $currentUlIdContent = Home_Page::where("ul_id",'=',$ulId)
												 ->where("ul_update_no",'=',$intUlId)
												 ->first();
						 $newData = array(
							 'ul_update_no' => $count

						 );

						 $currentUlIdContent->fill($newData);
						 $currentUlIdContent->save();
						 $count++;
					 }


				 }

				 $this->flash->addMessage('success','You have deleted images from gallery');
				 return $response->withRedirect($this->router->pathFor('admin.update'));
			 }else{
				 $this->flash->addMessage('error','You have not deleted images from gallery');
				 return $response->withRedirect($this->router->pathFor('admin.update'));

			 }


		 }


}
