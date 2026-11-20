<?php
// Halaman utama: pengelolaan data dosen (lecturers)
include_once(__DIR__ . "/controllers/LecturerController.php");

$controller = new LecturerController();
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
