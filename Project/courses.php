<?php
// Halaman pengelolaan data mata kuliah (courses)
include_once(__DIR__ . "/controllers/CourseController.php");

$controller = new CourseController();
$action = $_GET['action'] ?? 'index';

// Menentukan method controller berdasarkan parameter ?action=
switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'store':
        $controller->store();
        break;
    case 'edit':
        $controller->edit();
        break;
    case 'update':
        $controller->update();
        break;
    case 'delete':
        $controller->delete();
        break;
    default:
        $controller->index();
}
