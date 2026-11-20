<?php
include_once(__DIR__ . "/BaseView.php");

class DepartmentView extends BaseView
{
    // Tabel daftar departemen
    public function renderList($data)
    {
        $rows = "";
        foreach ($data as $row) {
            $rows .= "<tr>
                <th>" . e($row['id']) . "</th>
                <td>" . e($row['name']) . "</td>
                <td>" . e($row['code']) . "</td>
                <td>" . e($row['building']) . "</td>
                <td>" . e($row['total_lecturers']) . "</td>
                <td>
                  <a class='btn btn-success' href='departments.php?action=edit&amp;id=" . e($row['id']) . "'>Edit</a>
                  <form method='post' action='departments.php?action=delete' class='d-inline' onsubmit=\"return confirm('Delete this department?')\">
                    <input type='hidden' name='id' value='" . e($row['id']) . "'>
                    <button type='submit' class='btn btn-danger'>Delete</button>
                  </form>
                </td>
              </tr>";
        }
        if ($rows === "") {
            $rows = "<tr><td colspan='6' class='text-center'>No departments yet. Click Add New to create one.</td></tr>";
        }

        $tpl = new Template("department_list");
        $tpl->replace("ROWS", $rows);
        $this->show("Departments", "DEPARTMENTS", $tpl->getContent());
    }

    // Form tambah/ubah departemen ($row = null berarti form tambah)
    public function renderForm($row)
    {
        $isEdit = ($row !== null);

        $tpl = new Template("department_form");
        $tpl->replace("ACTION", $isEdit ? "update" : "store");
        $tpl->replace("JUDUL_FORM", $isEdit ? "Update Department" : "Create Department");
        $tpl->replace("HEADER_CLASS", $isEdit ? "bg-warning" : "bg-primary");
        $tpl->replace("ID", $isEdit ? e($row['id']) : "");
        $tpl->replace("NAME", $isEdit ? e($row['name']) : "");
        $tpl->replace("CODE", $isEdit ? e($row['code']) : "");
        $tpl->replace("BUILDING", $isEdit ? e($row['building']) : "");
        $this->show($isEdit ? "Update Department" : "Create Department", "DEPARTMENTS", $tpl->getContent());
    }
}
