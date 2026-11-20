<?php
// Model tabel courses
class Course extends DB
{
    // Semua mata kuliah + nama dosen pengampunya
    function getAll()
    {
        $query = "SELECT c.*, l.name AS lecturer_name
                  FROM courses c
                  LEFT JOIN lecturers l ON c.lecturer_id = l.id
                  ORDER BY c.id";
        return $this->execute($query);
    }

    // Satu mata kuliah berdasarkan id
    function getById($id)
    {
        $this->execute("SELECT * FROM courses WHERE id = ?", "i", array($id));
        return $this->getResult();
    }

    function add($data)
    {
        $query = "INSERT INTO courses (code, name, credits, lecturer_id) VALUES (?, ?, ?, ?)";
        return $this->execute($query, "ssii", array(
            $data['code'], $data['name'], $data['credits'], $data['lecturer_id']
        ));
    }

    function update($id, $data)
    {
        $query = "UPDATE courses SET code = ?, name = ?, credits = ?, lecturer_id = ? WHERE id = ?";
        return $this->execute($query, "ssiii", array(
            $data['code'], $data['name'], $data['credits'], $data['lecturer_id'], $id
        ));
    }

    function delete($id)
    {
        return $this->execute("DELETE FROM courses WHERE id = ?", "i", array($id));
    }
}
