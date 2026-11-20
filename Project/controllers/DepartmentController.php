<?php
include_once(__DIR__ . "/../config.php");
include_once(__DIR__ . "/../models/DB.php");
include_once(__DIR__ . "/../models/Department.php");
include_once(__DIR__ . "/../views/DepartmentView.php");

class DepartmentController
{
    private $department;

    // Membuat objek model departemen
    function __construct()
    {
        $this->department = new Department(Config::$db_host, Config::$db_user, Config::$db_pass, Config::$db_name);
    }

    // Menampilkan daftar departemen
    public function index()
    {
        $this->department->open();
        $this->department->getAll();
        $data = $this->department->fetchAll();
        $this->department->close();

        $view = new DepartmentView();
        $view->renderList($data);
    }

    // Menampilkan form tambah departemen
    public function create()
    {
        $view = new DepartmentView();
        $view->renderForm(null);
    }

    // Menyimpan departemen baru
    public function store()
    {
        $data = $this->formData();
        if ($data['name'] !== "" && $data['code'] !== "") {
            $this->department->open();
            $this->department->add($data);
            $this->department->close();
        }
        $this->redirect();
    }

    // Menampilkan form ubah departemen
    public function edit()
    {
        $id = (int) ($_GET['id'] ?? 0);

        $this->department->open();
        $row = $this->department->getById($id);
        $this->department->close();

        // Kalau id tidak ditemukan, kembali ke daftar
        if (!$row) {
            $this->redirect();
        }

        $view = new DepartmentView();
        $view->renderForm($row);
    }

    // Menyimpan perubahan departemen
    public function update()
    {
        $id = (int) ($_POST['id'] ?? 0);
        $data = $this->formData();

        if ($id > 0 && $data['name'] !== "" && $data['code'] !== "") {
            $this->department->open();
            $this->department->update($id, $data);
            $this->department->close();
        }
        $this->redirect();
    }

    // Menghapus departemen (dosen di dalamnya tidak ikut terhapus)
    public function delete()
    {
        $id = (int) ($_POST['id'] ?? 0);

        if ($id > 0) {
            $this->department->open();
            $this->department->delete($id);
            $this->department->close();
        }
        $this->redirect();
    }

    // Mengambil data dari form
    private function formData()
    {
        return array(
            'name' => trim($_POST['name'] ?? ''),
            'code' => trim($_POST['code'] ?? ''),
            'building' => trim($_POST['building'] ?? '')
        );
    }

    // Kembali ke halaman daftar departemen
    private function redirect()
    {
        header("Location: departments.php");
        exit;
    }
}
