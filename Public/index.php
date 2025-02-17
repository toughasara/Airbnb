<?php

session_start();

require_once dirname(__DIR__) . '/vendor/autoload.php';


use App\Core\App;


App::run();