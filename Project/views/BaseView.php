<?php
include_once(__DIR__ . "/Template.php");

// Kelas dasar semua view: membungkus isi halaman dengan layout (navbar + head)
class BaseView
{
    // $active = menu yang ditandai aktif (LECTURERS / DEPARTMENTS / COURSES)
    protected function show($title, $active, $content)
    {
        $layout = new Template("layout");
        $layout->replace("JUDUL", $title);
        $layout->replace("ISI", $content);
        foreach (array("LECTURERS", "DEPARTMENTS", "COURSES") as $menu) {
            $layout->replace("AKTIF_" . $menu, $menu === $active ? "active" : "");
        }
        $layout->write();
    }
}
