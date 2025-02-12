<?php

namespace routes;

use App\Core\Router;


Router::get('/', 'Controller@index');

Router::get('', 'Controller@index');


Router::get('home', 'Controller@index');

Router::get('register', 'Controller@register');

Router::get('contact', 'Controller@contact');

Router::post('products', 'Controller@sendData');

Router::get('dashboard', 'Back\\AdminController@dashboard');

Router::get('about', function(){
    echo 'this is fun';
    exit;
});



Router::post('home', 'Controller@getUserById');




