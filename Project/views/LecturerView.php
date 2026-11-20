<?php
include_once(__DIR__ . "/BaseView.php");

class LecturerView extends BaseView
{
    // Tabel daftar dosen
    public function renderList($data)
    {
        $rows = "";
        foreach ($data as $row) {
            $dept = $row['department_name'] ? e($row['department_name']) : "-";
            $rows .= "<tr>
                <th>" . e($row['id']) . "</th>
                <td>" . e($row['name']) . "</td>
                <td>" . e($row['nidn']) . "</td>
                <td>" . e($row['phone']) . "</td>
                <td>" . e($row['join_date']) . "</td>
                <td>" . $dept . "</td>
                <td>
                  <a class='btn btn-success' href='index.php?action=edit&amp;id=" . e($row['id']) . "'>Edit</a>
                  <form method='post' action='index.php?action=delete' class='d-inline' onsubmit=\"return confirm('Delete this lecturer?')\">
                    <input type='hidden' name='id' value='" . e($row['id']) . "'>
                    <button type='submit' class='btn btn-danger'>Delete</button>
                  </form>
                </td>
              </tr>";
        }
        if ($rows === "") {
            $rows = "<tr><td colspan='7' class='text-center'>No lecturers yet. Click Add New to create one.</td></tr>";
        }

        $tpl = new Template("lecturer_list");
        $tpl->replace("ROWS", $rows);
        $this->show("Home", "LECTURERS", $tpl->getContent());
    }

    // Form tambah/ubah dosen ($row = null berarti form tambah)
    public function renderForm($row, $departments)
    {
        $isEdit = ($row !== null);
        $selected = $isEdit ? $row['department_id'] : null;

        // Pilihan departemen untuk dropdown
        $options = "<option value=''>-- No department --</option>";
        foreach ($departments as $d) {
            $sel = ($selected !== null && $d['id'] == $selected) ? " selected" : "";
            $options .= "<option value='" . e($d['id']) . "'" . $sel . ">" . e($d['name']) . "</option>";
        }

        $tpl = new Template("lecturer_form");
        $tpl->replace("ACTION", $isEdit ? "update" : "store");
        $tpl->replace("JUDUL_FORM", $isEdit ? "Update Lecturer" : "Create Lecturer");
        $tpl->replace("HEADER_CLASS", $isEdit ? "bg-warning" : "bg-primary");
        $tpl->replace("ID", $isEdit ? e($row['id']) : "");
        $tpl->replace("NAME", $isEdit ? e($row['name']) : "");
        $tpl->replace("NIDN", $isEdit ? e($row['nidn']) : "");
        $tpl->replace("PHONE", $isEdit ? e($row['phone']) : "");
        $tpl->replace("JOIN_DATE", $isEdit ? e($row['join_date']) : "");
        $tpl->replace("OPSI_DEPARTMENT", $options);
        $this->show($isEdit ? "Update Lecturer" : "Create Lecturer", "LECTURERS", $tpl->getContent());
    }
}
