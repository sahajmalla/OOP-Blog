<?php
require_once 'core/init.php';

$userDeletePost = new User();
$blogDelete = new Blog();

if (!$userDeletePost->isLoggedin()) {
    Redirect::to('login.php');
}

if (Input::get('id') === '') {
    Redirect::to(404);
}

if (!($blogDelete->findById(Input::get('id')))) {
    Redirect::to(404);
}

try {
    $blogDelete->delete($blogDelete->data()->id);
    Session::flash('deletePostSuccess', 'Post Successfully deleted!');
    Redirect::to('dashboard.php');
} catch (Exception $e) {
    die($e->getMessage());
}
