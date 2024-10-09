<?php
require '../vendor/autoload.php';

use App\Controllers\SiteController;
use App\Controllers\UserController;
use App\Controllers\CourseController;
use App\Controllers\LectureController;

// Tạo phiên làm việc
session_start();

// Lấy URI và loại bỏ dấu "/"
$request = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Tách URL thành các phần
$requestParts = explode('/', $request);

// Lấy tên controller, action và id từ URL
$controller = isset($requestParts[0]) ? $requestParts[0] : 'home';
$action = isset($requestParts[1]) ? $requestParts[1] : 'index';
$id = isset($requestParts[2]) ? $requestParts[2] : null;

// Khởi tạo các controller
$siteController = new SiteController();
$userController = new UserController();
$courseController = new CourseController();
$lectureController = new LectureController();

// Điều hướng theo controller và action
switch ($controller) {
    case 'courses':
        if ($action == 'index') {
            $siteController->courses();
        } elseif ($action == 'show' && $id) {
            $courseController->show($id);
        } elseif ($action == 'edit' && $id) {
            $courseController->edit($id);
        } elseif ($action == 'delete' && $id) {
            $courseController->delete($id);
        } elseif ($action == 'create') {
            $courseController->create();
        } elseif ($action == 'store') {
            $courseController->store();
        } elseif ($action == 'update' && $id) {
            $courseController->update($id);
        } else {
            echo "Action không hợp lệ trong Courses Controller!";
        }
        break;
    case '':
        $siteController->home();
        break;

    case 'home':
        $siteController->home();
        break;

    case 'login':
        $userController->login();
        break;

    case 'logout':
        session_destroy();  // Xử lý đăng xuất
        header('Location: /login');
        exit();

    case 'profile':
        $userController->showProfile();
        break;

    case 'user':
        if ($action == 'list' || $action == 'index') {
            $userController->listUsers();
        } elseif ($action == 'create') {
            $userController->createUser();
        } elseif ($action == 'edit' && $id) {
            $userController->editUser($id);
        } elseif ($action == 'delete' && $id) {
            $userController->deleteUser($id);
        } else {
            echo "Action không hợp lệ trong User Controller!";
        }
        break;

    case 'lecture':
        if ($action == 'create' && $id) {
            $lectureController->addLecture($id);
        } elseif ($action == 'edit' && $id) {
            $lectureController->editLecture($id);
        } elseif ($action == 'delete' && $id) {
            $lectureController->deleteLecture($id);
        } elseif ($action == 'show' && $id) {
            $lectureController->showLecture($id);
        } else {
            echo "Action không hợp lệ trong User Controller!";
        }
        break;
    default:
        echo "Page not found!";
        break;
}
