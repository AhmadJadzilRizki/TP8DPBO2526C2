<?php
include_once(__DIR__ . "/BaseView.php");

class CourseView extends BaseView
{
    // Tabel daftar mata kuliah
    public function renderList($data)
    {
        $rows = "";
        foreach ($data as $row) {
            $lecturer = $row['lecturer_name'] ? e($row['lecturer_name']) : "-";
            $rows .= "<tr>
                <th>" . e($row['id']) . "</th>
                <td>" . e($row['code']) . "</td>
                <td>" . e($row['name']) . "</td>
                <td>" . e($row['credits']) . "</td>
                <td>" . $lecturer . "</td>
                <td>
                  <a class='btn btn-success' href='courses.php?action=edit&amp;id=" . e($row['id']) . "'>Edit</a>
                  <form method='post' action='courses.php?action=delete' class='d-inline' onsubmit=\"return confirm('Delete this course?')\">
                    <input type='hidden' name='id' value='" . e($row['id']) . "'>
                    <button type='submit' class='btn btn-danger'>Delete</button>
                  </form>
                </td>
              </tr>";
        }
        if ($rows === "") {
            $rows = "<tr><td colspan='6' class='text-center'>No courses yet. Click Add New to create one.</td></tr>";
        }

        $tpl = new Template("course_list");
        $tpl->replace("ROWS", $rows);
        $this->show("Courses", "COURSES", $tpl->getContent());
    }

    // Form tambah/ubah mata kuliah ($row = null berarti form tambah)
    public function renderForm($row, $lecturers)
    {
        $isEdit = ($row !== null);
        $selected = $isEdit ? $row['lecturer_id'] : null;

        // Pilihan dosen pengampu untuk dropdown
        $options = "<option value=''>-- No lecturer --</option>";
        foreach ($lecturers as $l) {
            $sel = ($selected !== null && $l['id'] == $selected) ? " selected" : "";
            $options .= "<option value='" . e($l['id']) . "'" . $sel . ">" . e($l['name']) . "</option>";
        }

        $tpl = new Template("course_form");
        $tpl->replace("ACTION", $isEdit ? "update" : "store");
        $tpl->replace("JUDUL_FORM", $isEdit ? "Update Course" : "Create Course");
        $tpl->replace("HEADER_CLASS", $isEdit ? "bg-warning" : "bg-primary");
        $tpl->replace("ID", $isEdit ? e($row['id']) : "");
        $tpl->replace("CODE", $isEdit ? e($row['code']) : "");
        $tpl->replace("NAME", $isEdit ? e($row['name']) : "");
        $tpl->replace("CREDITS", $isEdit ? e($row['credits']) : "");
        $tpl->replace("OPSI_LECTURER", $options);
        $this->show($isEdit ? "Update Course" : "Create Course", "COURSES", $tpl->getContent());
    }
}
