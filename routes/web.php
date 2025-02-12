<?php

namespace routes;

use App\Core\Router;


Router::get('/', 'Controller@index');

Router::get('', 'Controller@index');
Router::get('housingoffer', 'Controller@housingoffer');
Router::get('articledescription', 'Controller@articledescription');


Router::get('home', 'Controller@index');

Router::get('register', 'Auth\\userController@register');

Router::get('contenuinscription', 'Auth\\userController@contenuinscription');

Router::get('contact', 'Controller@contact');

Router::post('products', 'Controller@sendData');

Router::get('about', function(){
    echo 'this is fun';
    exit;
});



Router::post('home', 'Controller@getUserById');




