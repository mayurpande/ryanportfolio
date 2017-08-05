<?php

use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;

//calls homecontroller index fn
$app->get('/','HomeController:index')->setName('home');

$app->get('/portfolio','PortfolioController:index')->setName('portfolio');

$app->get('/contact','ContactUsController:index')->setName('contact');

$app->get('/about','AboutController:index')->setName('about');

$app->get('/land-images','LandingController:index')->setName('land');

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

    //for create and update existing gallery item

    $this->get('/admin-create-gallery','AdminController:getGalleryCreate')->setName('adminGallery.create');

    $this->post('/admin-create-gallery','AdminController:postGalleryCreate');

    $this->get('/admin-update-gallery','AdminController:getGalleryUpdate')->setName('adminGallery.update');

    $this->post('/admin-update-gallery','AdminController:postGalleryUpdate');

    //for new gallery item

    $this->get('/admin-create-new-gallery','AdminController:getNewGalleryCreate')->setName('adminNewGallery.create');

    $this->post('/admin-create-new-gallery','AdminController:postNewGalleryCreate');

  //auth controller routes
    $this->get('/admin-password-change','PasswordController:getChangePassword')->setName('auth.password.change');

    $this->post('/admin-password-change','PasswordController:postChangePassword');

   ////
    $this->get('/admin-upload-image','ImageController:getImageUpload')->setName('adminUpload.update');

    $this->post('/admin-upload-image','ImageController:postImageUpload');

    $this->get('/admin-contact','AdminController:getNewContactCreate')->setName('adminContact.create');

    $this->post('/admin-contact','AdminController:postNewContactCreate');

    $this->get('/admin-about','AdminController:getNewAboutCreate')->setName('adminAbout.create');

    $this->post('/admin-about','AdminController:postNewAboutCreate');

    $this->get('/admin-land','AdminController:getNewLandingCreate')->setName('adminLand.create');

    $this->post('/admin-land','AdminController:postNewLandingCreate');

    $this->get('/admin-land-delete','AdminController:getLandingDelete')->setName('adminLand.delete');

    $this->post('/admin-land-delete','AdminController:postLandingDelete');

    $this->get('/admin-gallery-delete','AdminController:getGalleryDelete')->setName('adminGallery.delete');
/*    $this->get('/admin-upload-image','SiriusController:getImageUpload')->setName('adminUpload.update');

    $this->post('/admin-upload-image','SiriusController:postImageUpload');
*/
})->add(new AuthMiddleware($container));
