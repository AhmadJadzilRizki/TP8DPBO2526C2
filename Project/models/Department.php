<?php
// Model tabel departments
class Department extends DB
{
    // Semua departemen + jumlah dosen di tiap departemen
    function getAll()
    {
        $query = "SELECT d.*, COUNT(l.id) AS total_lecturers
                  FROM departments d
                  LEFT JOIN lecturers l ON l.department_id = d.id
                  GROUP BY d.id
                  ORDER BY d.id";
        return $this->execute($query);
    }

    // Satu departemen berdasarkan id
    function getById($id)
    {
        $this->execute("SELECT * FROM departments WHERE id = ?", "i", array($id));
        return $this->getResult();
    }

    function add($data)
    {
        $query = "INSERT INTO departments (name, code, building) VALUES (?, ?, ?)";
        return $this->execute($query, "sss", array($data['name'], $data['code'], $data['building']));
    }

    function update($id, $data)
    {
        $query = "UPDATE departments SET name = ?, code = ?, building = ? WHERE id = ?";
        return $this->execute($query, "sssi", array($data['name'], $data['code'], $data['building'], $id));
    }

    function delete($id)
    {
        return $this->execute("DELETE FROM departments WHERE id = ?", "i", array($id));
    }
}
