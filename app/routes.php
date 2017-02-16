<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

//calls homecontroller index fn
$app->get('/','HomeController:index')->setName('home');

$app->get('/contact-us','ContactUsController:index')->setName('contact');

$app->group('', function () {
    //comment out these two lines - for sigining up another user
    //$this->get('/admin/siginup','AuthController:getSignUp')->setName('auth.signup');

    //$this->post('/admin/signup','AuthController:postSignUp');

    $this->get('/admin','AuthController:getSignIn')->setName('auth.signin');

    $this->post('/admin','AuthController:postSignIn');

})->add(new GuestMiddleware($container));





//create route group, then will place these routes in the route group


//this is for admin page
$app->group('', function () {

    $this->get('/signout','AuthController:getSignOut')->setName('auth.signout');
    
    $this->get('/admin-update-site','AdminController:getUpdateSite')->setName('admin.update');
    
    //for home page
    $this->get('/admin-create-home','AdminController:getHomeCreate')->setName('adminHome.create');

    $this->post('/admin-create-home','AdminController:postHomeCreate');

    $this->get('/admin-update-home','AdminController:getHomeUpdate')->setName('adminHome.update');

    $this->post('/admin-update-home','AdminController:postHomeUpdate');
    
    //for portrait page
    
    $this->get('/admin-create-portrait','AdminController:getPortraitCreate')->setName('adminPortrait.create');

    $this->post('/admin-create-portrait','AdminController:postPortraitCreate');

    $this->get('/admin-update-portrait','AdminController:getPortraitUpdate')->setName('adminPortrait.update');

    $this->post('/admin-update-portrait','AdminController:postPortraitUpdate');
    
    
    //for landscape page
    
    $this->get('/admin-create-landscape','AdminController:getLandscapeCreate')->setName('adminLandscape.create');

    $this->post('/admin-create-landscape','AdminController:postLandscapeCreate');

    $this->get('/admin-update-landscape','AdminController:getLandscapeUpdate')->setName('adminLandscape.update');

    $this->post('/admin-update-landscape','AdminController:postLandscapeUpdate');
    
    
    

    //auth controller routes
    $this->get('/admin-password-change','PasswordController:getChangePassword')->setName('auth.password.change');

    $this->post('/admin-password-change','PasswordController:postChangePassword');

   ////
    $this->get('/admin-upload-image','ImageController:getImageUpload')->setName('adminUpload.update');

    $this->post('/admin-upload-image','ImageController:postImageUpload');

/*    $this->get('/admin-upload-image','SiriusController:getImageUpload')->setName('adminUpload.update');

    $this->post('/admin-upload-image','SiriusController:postImageUpload');
*/
})->add(new AuthMiddleware($container));
