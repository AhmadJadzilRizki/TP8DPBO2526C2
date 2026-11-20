-- =====================================================
-- Database : tp_mvc25
-- Tabel    : departments, lecturers, courses
-- =====================================================

CREATE DATABASE IF NOT EXISTS tp_mvc25
    CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE tp_mvc25;

-- Hapus tabel lama (anak dulu, baru induk)
DROP TABLE IF EXISTS courses;
DROP TABLE IF EXISTS lecturers;
DROP TABLE IF EXISTS departments;

-- =====================================================
-- Tabel departments (baru)
-- =====================================================
CREATE TABLE departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(10) NOT NULL,
    building VARCHAR(50)
) ENGINE=InnoDB;

-- =====================================================
-- Tabel lecturers (tabel awal + kolom department_id)
-- =====================================================
CREATE TABLE lecturers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    nidn VARCHAR(20) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    join_date DATE NOT NULL,
    department_id INT NULL,
    FOREIGN KEY (department_id) REFERENCES departments(id)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- Tabel courses (baru)
-- =====================================================
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) NOT NULL,
    name VARCHAR(100) NOT NULL,
    credits INT NOT NULL,
    lecturer_id INT NULL,
    FOREIGN KEY (lecturer_id) REFERENCES lecturers(id)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- Data awal
-- =====================================================
INSERT INTO departments (name, code, building) VALUES
('Ilmu Komputer', 'ILKOM', 'Gedung FPMIPA C'),
('Rekayasa Perangkat Lunak', 'RPL', 'Gedung JICA'),
('Sistem Informasi', 'SI', 'Gedung FPMIPA B');

INSERT INTO lecturers (name, nidn, phone, join_date, department_id) VALUES
('Dr. Andi Prasetyo, M.Kom.', '0412058801', '081234567801', '2015-08-17', 1),
('Rina Marlina, M.T.', '0420068502', '081234567802', '2018-02-01', 1),
('Budi Hartono, M.Cs.', '0405078703', '081234567803', '2012-09-03', 2),
('Sari Wulandari, M.Kom.', '0418099004', '081234567804', '2020-01-13', 2),
('Dimas Nugraha, M.T.', '0430118205', '081234567805', '2019-07-22', 3);

INSERT INTO courses (code, name, credits, lecturer_id) VALUES
('IK101', 'Algoritma dan Pemrograman', 3, 1),
('IK203', 'Struktur Data', 3, 2),
('IK305', 'Basis Data', 3, 1),
('RP210', 'Desain dan Pemrograman Berbasis Objek', 4, 3),
('RP320', 'Rekayasa Perangkat Lunak', 3, 4),
('SI220', 'Analisis dan Perancangan Sistem', 3, 5);
