<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Upload\Storage\FileSystem;
use Upload\File;
use Upload\Validation\MimeType;
use Upload\Validation\Size;

//import validator
use Respect\Validation\Validator as v;

class ImageController extends Controller
{


	public function getImageUpload($request,$response){
		return $this->view->render($response,'admin-upload.twig');
	}

    public function postImageUpload($request,$response){
        $dir = USER_ROOT;
        $storage = new \Upload\Storage\FileSystem($_SERVER['DOCUMENT_ROOT'] . "/img");
        $file = new \Upload\File('upload',$storage);

      //  $new_filename = uniqid();
       // $file->setName($new_filename);


        $file->addValidations(array(
            new \Upload\Validation\Mimetype(array('image/png','image/gif','image/jpg','image/jpeg')),

            new \Upload\Validation\Size('20M')
        ));


        // Access data about the file that has been uploaded
        $data = array(
            'name'       => $file->getNameWithExtension(),
            'extension'  => $file->getExtension(),
            'mime'       => $file->getMimetype(),
            'size'       => $file->getSize(),
            'md5'        => $file->getMd5(),
            'dimensions' => $file->getDimensions()
        );
        // Try to upload file
        try {

            if ($file->upload()) {
                $this->flash->addMessage('success','Image uploaded');
                $this->flash->addMessage('info','Make sure to add the same name i.e. image.jpg as a string in other form submission');
                return $response->withRedirect($this->router->pathFor('admin.update'));
            }

        } catch (\Exception $e) {
            // Fail!

            $errors = $file->getErrors();
            $this->flash->addMessage('error',$errors);
            return $response->withRedirect($this->router->pathFor('admin.update'));
        }
    }
}
