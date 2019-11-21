<?php

define('ROOTPATH', dirname(__DIR__));

require_once ROOTPATH . '/App/App.php';

App::init();
App::$router->start();
