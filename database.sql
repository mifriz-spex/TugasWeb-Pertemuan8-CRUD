CREATE DATABASE IF NOT EXISTS inventaris_db;
USE inventaris_db;

CREATE TABLE kategori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL
);

CREATE TABLE supplier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_supplier VARCHAR(100) NOT NULL,
    kontak VARCHAR(50) NOT NULL,
    alamat TEXT NOT NULL 
);

CREATE TABLE produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(150) NOT NULL,
    kategori_id INT NOT NULL,
    supplier_id INT NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    harga DECIMAL(15,2) NOT NULL,
    FOREIGN KEY (kategori_id) REFERENCES kategori(id) ON DELETE CASCADE,
    FOREIGN KEY (supplier_id) REFERENCES supplier(id) ON DELETE CASCADE
);

CREATE TABLE log_aktivitas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    deskripsi VARCHAR(255) NOT NULL,
    waktu TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed Data Kategori
INSERT INTO kategori (nama_kategori) VALUES
('Processor'),
('RAM'),
('VGA / Kartu Grafis'),
('Motherboard'),
('Storage (SSD/HDD)');

-- Seed Data Supplier
INSERT INTO supplier (nama_supplier, kontak, alamat) VALUES
('PT Asus Indonesia Tech', '081234567890', 'Jl. Sudirman No. 10, Jakarta'),
('PT MSI Global Mandiri', '085677889900', 'Jl. Thamrin No. 88, Medan'),
('PT Gigabyte Mega Distribusi', '081298765432', 'Komp. Ruko Harco Mangga Dua Blok A/5'),
('CV Corsair Jaya Nusantara', '082111223344', 'Jl. Gajah Mada No. 45, Surabaya'),
('PT Samsung Tech Partner', '087812344321', 'Kawasan Industri Cikarang Blok B2');

-- Seed Data Produk
INSERT INTO produk (nama_produk, kategori_id, supplier_id, stok, harga) VALUES
('Intel Core i5-13400F', 1, 1, 15, 3250000.00),
('Corsair Vengeance 32GB (2x16GB) DDR5', 4, 3, 20, 1750000.00),
('NVIDIA GeForce RTX 4060 8GB', 2, 2, 8, 4850000.00),
('ASUS ROG Strix B760-A Gaming', 3, 1, 5, 3600000.00),
('Samsung 980 Pro SSD NVMe 1TB', 5, 5, 12, 1650000.00);