<?php

use Respect\Validation\Validator as v;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require __DIR__ . '/../app/config/auth.php';
require __DIR__ . '/../vendor/autoload.php';
date_default_timezone_set ( "Europe/London" );

//instansite slim - pass in configuration option to slim
//while developing set errrors to be displayed

$app = new \Slim\App([
	'settings' => [

		'displayErrorDetails' => true,
		//first look at the settings because we need to know where we are connecting to
		//we will put setting in here, we won't use an external package to manage our configuration
		//This can be done later, we will just add them to our slim configuration, it makes more sense
		//to get quickly going with this
		'db' => $config

	],


]);

// Get container
$container = $app->getContainer();

//Now that we have our settings, we need to actually set eloquent up, we are going to set this up
//here. We could of course extract this of to another file, first lets see how we pull eloquent in
//and then we can start to get testing it

//first we are going to create a variable called capsule
//Capsule is just the way that laravel lets us use its components outside of laravel

$capsule = new \Illuminate\Database\Capsule\Manager;



//from this what we can do is invoke addconnection method and this data is coming from of course
//from our settings

//to access our settings, they can be accessed from our container because the settings that we have
//inserted here can be accessed under settings, within our container, and then use multidimensional
//using keyword db.
$capsule->addConnection($container['settings']['db']);

//now what we want to do is set the capule variable as global, we will see why later on
$capsule->setAsGlobal();

//the above will allow us to use our vasards
//and then we just want to boot eloquent
$capsule->bootEloquent();

//add eloqeunt to container
//we pull in our container
//we want to use capsule because we have defined it above and then we return capsule
//so now not only have booted eqloeunt(the above) so we can use it globally so we can use models
//we have also done below so we can access it via our container from within our controllers
$container['db'] = function($container) use ($capsule){
	return $capsule;
};

$container['auth'] = function($container){
	return new \App\Auth\Auth;
};


//add slim flash to container
$container['flash'] = function ($container) {

    return new \Slim\Flash\Messages;

};




// Register component on container
$container['view'] = function ($container) {
	$view = new \Slim\Views\Twig(__DIR__ . '/../templates', [
		'cache' => false,
    ]);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
	));

	$view->getEnvironment()->addGlobal('auth', [

        'check' => $container->auth->check(),
        'user' => $container->auth->user(),
    ]);

    $view->getEnvironment()->addGlobal('flash',$container->flash);



    return $view;
};

//bind validator to container
$container['validator'] = function($container){

	return new App\Validation\Validator;

};

//now what we want to do is set up a binding on our container to return this controller then we can
//attach this to a root
//on our container the home controller is going to return a new app controllers homecontroller instanc
$container['HomeController'] = function($container){
/* This approach is not best practice but it works well
 * The idea here is if we did want to pull in a dependency
 * What we want to do is simply pass the container view object through to our controller.
 * In our case we know we have $container['view'] which handles views we can pass this into
 * our home controller see HomeController.php
 */
	return new \App\Controllers\HomeController($container);
};

$container['PortfolioController'] = function($container){
	return new \App\Controllers\PortfolioController($container);
};

$container['ContactUsController'] = function($container){
	return new \App\Controllers\ContactUsController($container);
};


$container['AboutController'] = function($container){
	return new \App\Controllers\AboutController($container);
};

$container['LandingController'] = function($container){
	return new \App\Controllers\LandingController($container);
};
$container['AuthController'] = function($container){
	return new \App\Controllers\Auth\AuthController($container);
};

$container['PasswordController'] = function($container){
	return new \App\Controllers\Auth\PasswordController($container);
};

$container['csrf'] = function($container){
	return new \Slim\Csrf\Guard;
};

$container['AdminController'] = function($container){
	return new \App\Controllers\AdminController($container);
};

$container['ImageController'] = function($container){
	return new \App\Controllers\ImageController($container);
};

/*$container['SiriusController'] = function($container){
	return new \App\Controllers\SiriusController($container);
};
*/
//to get the middleware we need to add it into here in our bootstrap/app.php file
//we choose the middleware. remember as we are extending our base middleware we need to pass our container
//in
$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));

$app->add(new \App\Middleware\OldInputMiddleware($container));

v::with('App\\Validation\\Rules');


$app->add(new \App\Middleware\CsrfViewMiddleware($container));
//csrf turned on
$app->add($container->csrf);

//v::with('App\\Validation\\Rules\\');

require __DIR__ . '/../app/routes.php';
