<?php

namespace routes;

use App\Core\Router;


Router::get('/', 'Controller@index');

Router::get('', 'Controller@index');


Router::get('home', 'Controller@index');

Router::get('register', 'Auth\\userController@register');

Router::post('register', 'Auth\\userController@register');

Router::get('connectez', 'Auth\\userController@connectez');

Router::get('contenuinscription', 'Auth\\userController@contenuinscription');

Router::post('login', 'Auth\\userController@login');

Router::get('pagehome', 'Controller@pagehome');

Router::post('completeRegistration', 'Auth\\userController@completeRegistration');

Router::get('contact', 'Controller@contact');

Router::post('products', 'Controller@sendData');

// hamza saaf
Router::get('dashboard', 'Back\\AdminController@dashboard');
Router::get('users', 'Back\\UserController@index');
Router::post('validat\{id}', 'Back\\AnonceController@validat');

Router::get('users', 'UsersController@index');


// end hamza saaf
Router::get('about', function(){
    echo 'this is fun';
    exit;
});



Router::post('home', 'Controller@getUserById');




////////Hmidouch Routes//////




Router::get('reservation','ReservationController@showReservationForm');
Router::post('reservation/process', 'ReservationController@processReservation');
Router::post('reservation/confirm', 'ReservationController@confirmPayment');







//////////////fin de hmidouch/////////















// zakaria routes

Router::get('housingoffer', 'Controller@housingoffer');
Router::get('articledescription', 'Controller@articledescription');
Router::get('addannounce', 'Controller@addannounce');
Router::post('addannounce', 'Controller@addannounce');
Router::get('updateannounce', 'Controller@updateannounce');
Router::get('dashboardowner', 'Controller@dashboardowner');
Router::post('OwnerRequestsController', 'Controller@OwnerRequestsController');

// fin zakaria routes