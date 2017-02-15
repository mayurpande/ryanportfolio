<?php

namespace App\Controllers;

use Sirius\Upload\Handler as UploadHandler;
use Sirius\Validation\ErrorMessage;

//import validator
use Respect\Validation\Validator as v;

class SiriusController extends Controller
{


	public function getImageUpload($request,$response){
		return $this->view->render($response,'admin-upload.twig');
	}

    public function postImageUpload($request,$response){
      $uploadHandler = new UploadHandler($_SERVER['DOCUMENT_ROOT'] . "/img");
      $errorMessagePrototype = new ErrorMessage;

      // set up the validation rules
      $uploadHandler->addRule('extension', ['allowed' => '.jpg', '.jpeg', '.png'], '{label} should be a valid image (jpg, jpeg, png)');
      $uploadHandler->addRule('size', ['max' => '20M'], '{label} should have less than {max}');
      //$uploadHandler->addRule('imageratio', ['ratio' => 1], '{label} should be a sqare image');


      $result = $uploadHandler->process($_FILES['upload']); // ex: subdirectory/my_headshot.png

      if ($result->isValid()) {
          try {

              // do something with the image like attaching it to a model etc
              $profile->picture = $result->name;
              $profile->save();
              $result->confirm(); // this will remove the .lock file
              $this->flash->addMessage('success','Image uploaded');
              $this->flash->addMessage('info','Make sure to add the same name i.e. image.jpg as a string in other form submission');
              return $response->withRedirect($this->router->pathFor('admin.update'));

          } catch (\Exception $e) {

              // something wrong happened, we don't need the uploaded files anymore
              $result->clear();
              throw $e;

          }
      } else {

          // image was not moved to the container, where are error messages
          $messages = $result->getMessages();
          foreach ($messages as $message){
            echo '<pre>' . print_r($message) . '</pre>';
            //$this->flash->addMessage('error',$message);
          }
          //return $response->withRedirect($this->router->pathFor('admin.update'));

      }
    }
}
