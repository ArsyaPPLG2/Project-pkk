CREATE DATABASE tokoookyu;
USE tokoookyu;

CREATE TABLE `product` (
    `id_produk` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `deskripsi` TEXT,
    `harga` DECIMAL(10, 2) NOT NULL,
    `qty` INT NOT NULL,
    `foto` VARCHAR(255)
);

CREATE TABLE `admin` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nama` VARCHAR(100) NOT NULL,
    `produk` VARCHAR(100),
    `jumlah` INT,
    `foto` VARCHAR(255)
);

CREATE TABLE `user` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `role` ENUM('admin', 'user') DEFAULT 'user',
    `name` VARCHAR(100) NOT NULL,
    `birthdate` DATE,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `phone` VARCHAR(15),
    `profile_picture` VARCHAR(255)
);
INSERT INTO `user` (`username`, `role`, `name`, `birthdate`, `password`, `email`, `phone`, `profile_picture`)
VALUES ('Arz', 'admin', 'Admin-Satu', '2007-03-10', 'Arz', 'Arz@gmail.com', '081234567890', 'Icon - Furina.jpeg'),

CREATE TABLE `pesan` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nama` VARCHAR(100) NOT NULL,
    `pesan` TEXT NOT NULL,
    `tanggal` DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `help_requests` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL,
    `message` TEXT NOT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
);