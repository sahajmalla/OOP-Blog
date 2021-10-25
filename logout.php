<?php 

require_once 'core/init.php';

$userLogOut = new User();

$userLogOut->logout();

Redirect::to('index.php');