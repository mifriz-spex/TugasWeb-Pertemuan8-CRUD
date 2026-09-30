<?php
require_once 'config/database.php';
require_once 'helpers/functions.php';

$pdo = Database::getInstance()->getConnection();

// Fitur Bonus: Pencarian Produk
$keyword = trim($_GET['keyword'] ?? '');

try {
    // Requirement 4: List produk dengan query JOIN 2 tabel (kategori & supplier)
    // Requirement 7: Menggunakan Prepared Statements
    $sql = "SELECT 
                p.id, 
                p.nama_produk, 
                p.stok, 
                p.harga, 
                k.nama_kategori, 
                s.nama_supplier 
            FROM produk p
            INNER JOIN kategori k ON p.kategori_id = k.id
            INNER JOIN supplier s ON p.supplier_id = s.id";

    // Jika ada input pencarian
    if (!empty($keyword)) {
        $sql .= " WHERE p.nama_produk LIKE :keyword OR k.nama_kategori LIKE :keyword OR s.nama_supplier LIKE :keyword";
    }

    $sql .= " ORDER BY p.id DESC";

    $stmt = $pdo->prepare($sql);

    if (!empty($keyword)) {
        $stmt->execute([':keyword' => "%{$keyword}%"]);
    } else {
        $stmt->execute();
    }

    $daftar_produk = $stmt->fetchAll();

} catch (PDOException $e) {
    die("Gagal mengambil data produk: " . $e->getMessage());
}

$page_title = "Daftar Inventaris Produk";
require_once 'templates/header.php';
?>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-4">
        
        <!-- Baris Header & Aksi Atas -->
        <div class="row align-items-center mb-4">
            <div class="col-md-6 mb-3 mb-md-0">
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-motherboard text-primary me-2"></i>Inventaris Hardware Komputer
                </h4>
                <p class="text-muted small mb-0">Total <?= count($daftar_produk); ?> item produk terdaftar</p>
            </div>
            <div class="col-md-6 d-flex flex-column flex-sm-row justify-content-md-end gap-2">
                <!-- Form Pencarian (Bonus) -->
                <form action="index.php" method="GET" class="d-flex">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" 
                               placeholder="Cari produk / kategori..." 
                               value="<?= e($keyword); ?>">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                <!-- Tombol Tambah Produk -->
                <a href="create.php" class="btn btn-primary text-nowrap">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Produk
                </a>
            </div>
        </div>

        <?php if (!empty($keyword)): ?>
            <div class="alert alert-light border py-2 mb-3 d-flex justify-content-between align-items-center">
                <span class="small">Hasil pencarian untuk: <strong>"<?= e($keyword); ?>"</strong></span>
                <a href="index.php" class="btn btn-sm btn-link text-decoration-none p-0">Reset Pencarian</a>
            </div>
        <?php endif; ?>

        <!-- Tabel Data Produk -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%;">No</th>
                        <th style="width: 28%;">Nama Hardware</th>
                        <th style="width: 15%;">Kategori</th>
                        <th style="width: 18%;">Supplier</th>
                        <th style="width: 14%;">Harga Satuan</th>
                        <th class="text-center" style="width: 8%;">Stok</th>
                        <th class="text-center" style="width: 12%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($daftar_produk)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                                Belum ada data produk komputer yang tersedia.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($daftar_produk as $row): ?>
                            <tr>
                                <td class="text-center fw-bold text-muted"><?= $no++; ?></td>
                                
                                <!-- Requirement 8: Wajib pakai htmlspecialchars via helper e() -->
                                <td>
                                    <span class="fw-semibold text-dark"><?= e($row['nama_produk']); ?></span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary border">
                                        <?= e($row['nama_kategori']); ?>
                                    </span>
                                </td>
                                <td class="text-muted small">
                                    <i class="bi bi-truck me-1"></i><?= e($row['nama_supplier']); ?>
                                </td>
                                <td class="fw-bold text-primary">
                                    <?= format_rupiah($row['harga']); ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($row['stok'] > 10): ?>
                                        <span class="badge-stok-aman"><?= e($row['stok']); ?> unit</span>
                                    <?php elseif ($row['stok'] > 0): ?>
                                        <span class="badge-stok-tipis"><?= e($row['stok']); ?> unit</span>
                                    <?php else: ?>
                                        <span class="badge-stok-habis">Habis</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group gap-1">
                                        <!-- Tombol Edit (Pre-filled) -->
                                        <a href="edit.php?id=<?= e($row['id']); ?>" 
                                           class="btn btn-sm btn-outline-warning" 
                                           title="Edit Produk">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <!-- Tombol Delete dengan Konfirmasi (Requirement 6) -->
                                        <a href="delete.php?id=<?= e($row['id']); ?>" 
                                           class="btn btn-sm btn-outline-danger" 
                                           title="Hapus Produk" 
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus produk <?= addslashes(e($row['nama_produk'])); ?>?');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php require_once 'templates/footer.php'; ?>