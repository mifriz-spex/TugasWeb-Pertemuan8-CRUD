<?php
require_once 'config/Database.php';
require_once 'helpers/functions.php';

// Ambil ID produk dari parameter URL
$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    set_flash('danger', 'ID produk tidak valid!');
    redirect('index.php');
}

$pdo = Database::getInstance()->getConnection();

try {
    // -------------------------------------------------------------
    // POIN BONUS: Implementasi Database Transaction (ACID)
    // -------------------------------------------------------------
    $pdo->beginTransaction();

    // 1. Ambil detail produk terlebih dahulu sebelum dihapus (Requirement 7: Prepared Statement)
    $stmtCheck = $pdo->prepare("SELECT nama_produk FROM produk WHERE id = :id");
    $stmtCheck->execute([':id' => $id]);
    $produk = $stmtCheck->fetch();

    if (!$produk) {
        // Jika data tidak ditemukan, batalkan transaksi
        $pdo->rollBack();
        set_flash('danger', 'Produk tidak ditemukan atau sudah dihapus!');
        redirect('index.php');
    }

    // 2. Query hapus produk dari database (Requirement 7: Prepared Statement)
    $stmtDelete = $pdo->prepare("DELETE FROM produk WHERE id = :id");
    $stmtDelete->execute([':id' => $id]);

    // 3. Catat aksi penghapusan ke tabel log_aktivitas (Poin Bonus)
    $deskripsiLog = "Menghapus produk: " . $produk['nama_produk'] . " (ID: {$id})";
    $stmtLog = $pdo->prepare("INSERT INTO log_aktivitas (deskripsi) VALUES (:deskripsi)");
    $stmtLog->execute([':deskripsi' => $deskripsiLog]);

    // 4. Jika kedua query di atas berhasil tanpa kendala, simpan permanen
    $pdo->commit();

    // Requirement 9: Flash message & Redirect Pattern
    set_flash('success', "Produk '{$produk['nama_produk']}' berhasil dihapus dan tercatat di log!");

} catch (PDOException $e) {
    // Jika ada satu saja error, batalkan semua perubahan database
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    set_flash('danger', 'Gagal menghapus produk: ' . $e->getMessage());
}

// Kembalikan ke halaman utama
redirect('index.php');