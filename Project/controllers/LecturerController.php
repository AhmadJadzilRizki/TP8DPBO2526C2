<?php
include_once(__DIR__ . "/../config.php");
include_once(__DIR__ . "/../models/DB.php");
include_once(__DIR__ . "/../models/Lecturer.php");
include_once(__DIR__ . "/../models/Department.php");
include_once(__DIR__ . "/../views/LecturerView.php");

class LecturerController
{
    private $lecturer;
    private $department;

    // Membuat objek model yang dibutuhkan
    function __construct()
    {
        $this->lecturer = new Lecturer(Config::$db_host, Config::$db_user, Config::$db_pass, Config::$db_name);
        $this->department = new Department(Config::$db_host, Config::$db_user, Config::$db_pass, Config::$db_name);
    }

    // Menampilkan daftar dosen
    public function index()
    {
        $this->lecturer->open();
        $this->lecturer->getAll();
        $data = $this->lecturer->fetchAll();
        $this->lecturer->close();

        $view = new LecturerView();
        $view->renderList($data);
    }

    // Menampilkan form tambah dosen
    public function create()
    {
        $view = new LecturerView();
        $view->renderForm(null, $this->getDepartments());
    }

    // Menyimpan dosen baru
    public function store()
    {
        $data = $this->formData();
        if ($data['name'] !== "") {
            $this->lecturer->open();
            $this->lecturer->add($data);
            $this->lecturer->close();
        }
        $this->redirect();
    }

    // Menampilkan form ubah dosen
    public function edit()
    {
        $id = (int) ($_GET['id'] ?? 0);

        $this->lecturer->open();
        $row = $this->lecturer->getById($id);
        $this->lecturer->close();

        // Kalau id tidak ditemukan, kembali ke daftar
        if (!$row) {
            $this->redirect();
        }

        $view = new LecturerView();
        $view->renderForm($row, $this->getDepartments());
    }

    // Menyimpan perubahan dosen
    public function update()
    {
        $id = (int) ($_POST['id'] ?? 0);
        $data = $this->formData();

        if ($id > 0 && $data['name'] !== "") {
            $this->lecturer->open();
            $this->lecturer->update($id, $data);
            $this->lecturer->close();
        }
        $this->redirect();
    }

    // Menghapus dosen
    public function delete()
    {
        $id = (int) ($_POST['id'] ?? 0);

        if ($id > 0) {
            $this->lecturer->open();
            $this->lecturer->delete($id);
            $this->lecturer->close();
        }
        $this->redirect();
    }

    // Mengambil data dari form
    private function formData()
    {
        $departmentId = ($_POST['department_id'] ?? '') !== '' ? (int) $_POST['department_id'] : null;

        return array(
            'name' => trim($_POST['name'] ?? ''),
            'nidn' => trim($_POST['nidn'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'join_date' => trim($_POST['join_date'] ?? ''),
            'department_id' => $departmentId
        );
    }

    // Daftar departemen untuk dropdown pada form
    private function getDepartments()
    {
        $this->department->open();
        $this->department->getAll();
        $list = $this->department->fetchAll();
        $this->department->close();
        return $list;
    }

    // Kembali ke halaman daftar dosen
    private function redirect()
    {
        header("Location: index.php");
        exit;
    }
}
