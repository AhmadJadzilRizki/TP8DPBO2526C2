<?php
// Kelas dasar semua model: mengurus koneksi dan eksekusi query
class DB
{
    protected $db_host = "";
    protected $db_user = "";
    protected $db_pass = "";
    protected $db_name = "";
    protected $db_link = null;
    protected $result = null;

    function __construct($db_host, $db_user, $db_pass, $db_name)
    {
        $this->db_host = $db_host;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_name = $db_name;
    }

    // Membuka koneksi ke database
    function open()
    {
        // Matikan mode exception bawaan agar error ditangani manual
        mysqli_report(MYSQLI_REPORT_OFF);
        $this->db_link = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        if (!$this->db_link) {
            die("Koneksi gagal: " . mysqli_connect_error());
        }
        mysqli_set_charset($this->db_link, "utf8mb4");
    }

    // Menjalankan query dengan prepared statement (aman dari SQL injection)
    function execute($query, $types = "", $params = array())
    {
        $stmt = mysqli_prepare($this->db_link, $query);
        if (!$stmt) {
            die("Query gagal: " . mysqli_error($this->db_link));
        }
        if ($types !== "") {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }
        if (!mysqli_stmt_execute($stmt)) {
            die("Query gagal: " . mysqli_stmt_error($stmt));
        }
        // SELECT menghasilkan result set, INSERT/UPDATE/DELETE menghasilkan false
        $this->result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $this->result;
    }

    // Mengambil 1 baris hasil query (array asosiatif)
    function getResult()
    {
        return mysqli_fetch_assoc($this->result);
    }

    // Mengambil semua baris hasil query
    function fetchAll()
    {
        $rows = array();
        while ($row = $this->getResult()) {
            array_push($rows, $row);
        }
        return $rows;
    }

    // Menutup koneksi
    function close()
    {
        mysqli_close($this->db_link);
    }
}
