<?php

namespace App\Validation;

use Respect\Validation\Validator as Respect;

//used for error checking see try catch block below
use Respect\Validation\Exceptions\NestedValidationException;


if(isset($_SESSION['errors'])){
	session_start();
}
class Validator{

	protected $errors;

	//create validate method
	public function validate($request, array $rules){
		/* We have an array of rules that we can iterate through
		 * so each one of these attributes will check that each
		 * one of these are in fact valid. Or rather they don't fail
		 *
		 * So to do this of course all we need to do is go and loop through 
		 * them. We want to pick up the index of these as well and that's 
		 * just the field name
		 *
		 * Now what we can do is assert that this does not fail (assert that
		 * its true) and we can pass in the actual field because we have this in the 
		 * request object 
		 */

		foreach($rules as $field => $rule){

			try{

				//helps pulling back error messages
				$rule->setName(ucfirst($field))->assert($request->getParam($field));

			}catch(NestedValidationException $e){

				//append to error list see property. we pass in field var here to keep track
				//getMessages because there could be more than one assertion fail
				$this->errors[$field] = $e->getMessages();
				


			}

		}
		

		/* we want to attach our errors that we got from this validation, to all of our views,
		 * we want to add them as globals. A simple way to do this would be, when we do validate
		 * we set them into a session here, then inside our middleware we take our session and we set it
		 * into our views. All we are doing is persisting that data. 
		 */

		$_SESSION['errors'] = $this->errors;

		return $this;
	}
	

	public function failed(){
		//return/check if the errors are not empty
		return !empty($this->errors);
	
	}

}
