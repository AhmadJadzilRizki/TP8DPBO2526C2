<?php
include_once(__DIR__ . "/../config.php");
include_once(__DIR__ . "/../models/DB.php");
include_once(__DIR__ . "/../models/Course.php");
include_once(__DIR__ . "/../models/Lecturer.php");
include_once(__DIR__ . "/../views/CourseView.php");

class CourseController
{
    private $course;
    private $lecturer;

    // Membuat objek model yang dibutuhkan
    function __construct()
    {
        $this->course = new Course(Config::$db_host, Config::$db_user, Config::$db_pass, Config::$db_name);
        $this->lecturer = new Lecturer(Config::$db_host, Config::$db_user, Config::$db_pass, Config::$db_name);
    }

    // Menampilkan daftar mata kuliah
    public function index()
    {
        $this->course->open();
        $this->course->getAll();
        $data = $this->course->fetchAll();
        $this->course->close();

        $view = new CourseView();
        $view->renderList($data);
    }

    // Menampilkan form tambah mata kuliah
    public function create()
    {
        $view = new CourseView();
        $view->renderForm(null, $this->getLecturers());
    }

    // Menyimpan mata kuliah baru
    public function store()
    {
        $data = $this->formData();
        if ($data['code'] !== "" && $data['name'] !== "") {
            $this->course->open();
            $this->course->add($data);
            $this->course->close();
        }
        $this->redirect();
    }

    // Menampilkan form ubah mata kuliah
    public function edit()
    {
        $id = (int) ($_GET['id'] ?? 0);

        $this->course->open();
        $row = $this->course->getById($id);
        $this->course->close();

        // Kalau id tidak ditemukan, kembali ke daftar
        if (!$row) {
            $this->redirect();
        }

        $view = new CourseView();
        $view->renderForm($row, $this->getLecturers());
    }

    // Menyimpan perubahan mata kuliah
    public function update()
    {
        $id = (int) ($_POST['id'] ?? 0);
        $data = $this->formData();

        if ($id > 0 && $data['code'] !== "" && $data['name'] !== "") {
            $this->course->open();
            $this->course->update($id, $data);
            $this->course->close();
        }
        $this->redirect();
    }

    // Menghapus mata kuliah
    public function delete()
    {
        $id = (int) ($_POST['id'] ?? 0);

        if ($id > 0) {
            $this->course->open();
            $this->course->delete($id);
            $this->course->close();
        }
        $this->redirect();
    }

    // Mengambil data dari form
    private function formData()
    {
        $lecturerId = ($_POST['lecturer_id'] ?? '') !== '' ? (int) $_POST['lecturer_id'] : null;

        return array(
            'code' => trim($_POST['code'] ?? ''),
            'name' => trim($_POST['name'] ?? ''),
            'credits' => (int) ($_POST['credits'] ?? 0),
            'lecturer_id' => $lecturerId
        );
    }

    // Daftar dosen untuk dropdown pada form
    private function getLecturers()
    {
        $this->lecturer->open();
        $this->lecturer->getAll();
        $list = $this->lecturer->fetchAll();
        $this->lecturer->close();
        return $list;
    }

    // Kembali ke halaman daftar mata kuliah
    private function redirect()
    {
        header("Location: courses.php");
        exit;
    }
}
