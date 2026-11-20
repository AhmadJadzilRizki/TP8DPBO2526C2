<?php
// Model tabel lecturers
class Lecturer extends DB
{
    // Semua dosen + nama departemennya
    function getAll()
    {
        $query = "SELECT l.*, d.name AS department_name
                  FROM lecturers l
                  LEFT JOIN departments d ON l.department_id = d.id
                  ORDER BY l.id";
        return $this->execute($query);
    }

    // Satu dosen berdasarkan id
    function getById($id)
    {
        $this->execute("SELECT * FROM lecturers WHERE id = ?", "i", array($id));
        return $this->getResult();
    }

    function add($data)
    {
        $query = "INSERT INTO lecturers (name, nidn, phone, join_date, department_id) VALUES (?, ?, ?, ?, ?)";
        return $this->execute($query, "ssssi", array(
            $data['name'], $data['nidn'], $data['phone'], $data['join_date'], $data['department_id']
        ));
    }

    function update($id, $data)
    {
        $query = "UPDATE lecturers
                  SET name = ?, nidn = ?, phone = ?, join_date = ?, department_id = ?
                  WHERE id = ?";
        return $this->execute($query, "ssssii", array(
            $data['name'], $data['nidn'], $data['phone'], $data['join_date'], $data['department_id'], $id
        ));
    }

    function delete($id)
    {
        return $this->execute("DELETE FROM lecturers WHERE id = ?", "i", array($id));
    }
}
