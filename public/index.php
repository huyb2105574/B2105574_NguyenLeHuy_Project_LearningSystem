<?php

require '../vendor/autoload.php';

use App\Controllers\SiteController;
use App\Controllers\UserController;
use App\Controllers\CourseController;
// Tạo phiên làm việc
session_start();

// Xử lý request
$request = $_SERVER['REQUEST_URI'];

$siteController = new SiteController();
$userController = new UserController();
$courseController = new CourseController();

switch ($request) {
    case '/home':
        $siteController->home();
        break;

    case '/courses':
        $siteController->courses();
        break;

    case '/courses/create':
        $courseController->create();
        break;

    case '/courses/store':
        $courseController->store();
        break;

    case '/login':
        $userController->login();
        break;

    case '/logout':
        session_destroy();  // Xử lý đăng xuất
        header('Location: /login');
        exit();
    case '/profile':
        $userController->showProfile();
        break;
    case '/create_user':
        $userController->createUser();
        break;
    default:
        echo "Page not found!";
        break;
}
