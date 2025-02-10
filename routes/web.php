<?php


use Core\Router;


Router::get('/', 'HomeController@index');

Router::get('', 'HomeController@index');


Router::get('home', 'HomeController@index');

Router::get('register', 'HomeController@register');

Router::get('contact', 'HomeController@contact');

Router::post('products', 'HomeController@sendData');

Router::get('about', function(){
    echo 'this is fun';
    exit;
});



Router::post('home', 'HomeController@getUserById');




