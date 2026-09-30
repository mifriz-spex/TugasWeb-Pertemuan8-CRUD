<?php
require_once __DIR__ . '/../helpers/functions.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? e($page_title) . ' - Toko Komputer' : 'Inventaris Toko Komputer'; ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="bi bi-cpu-fill text-success me-2"></i>KompuStore
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><i class="bi bi-box-seam me-1"></i>Daftar Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="create.php"><i class="bi bi-plus-circle me-1"></i>Tambah Produk</a>
                </li>
            </ul>
            <span class="navbar-text text-light small">
                <i class="bi bi-shield-check text-success me-1"></i>Admin Inventaris
            </span>
        </div>
    </div>
</nav>

<!-- Container Utama -->
<div class="container mb-5">
    <!-- Otomatis menampilkan Flash Message jika ada -->
    <?php display_flash(); ?>