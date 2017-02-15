<?php

namespace App\Controllers\Auth;

use App\Validation\Rules;
use App\Models\Admin;
use App\Controllers\Controller;

//import validator
use Respect\Validation\Validator as v;

class PasswordController extends Controller
{
	public function getChangePassword($request,$response)
	{
		return $this->view->render($response,'auth/password/change.twig');

	}


	public function postChangePassword($request,$response)
    {

        $validation = $this->validator->validate($request, [

            'password_old' => v::noWhitespace()->notEmpty()->matchesPassword($this->auth->user()->password),
            'password' => v::noWhitespace()->notEmpty(),

        ]);

        if ($validation->failed()) {
            
            //flash a message
            $this->flash->addMessage('error','These passwords are not the same.');

            return $response->withRedirect($this->router->pathFor('auth.password.change'));
        
        }

        $this->auth->user()->setPassword($request->getParam('password'));

        //flash a message
        $this->flash->addMessage('info','Your password has been reset.');
        

        //redirect the user
        return $response->withRedirect($this->router->pathFor('admin.update'));
		
	}
}	
	

