<?php
require_once 'config/Database.php';
require_once 'helpers/functions.php';

$pdo = Database::getInstance()->getConnection();

// 1. Ambil data Kategori & Supplier untuk isi dropdown (Requirement 5)
try {
    $stmtKat = $pdo->query("SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC");
    $kategori_list = $stmtKat->fetchAll();

    $stmtSup = $pdo->query("SELECT id, nama_supplier FROM supplier ORDER BY nama_supplier ASC");
    $supplier_list = $stmtSup->fetchAll();
} catch (PDOException $e) {
    die("Gagal memuat data relasi: " . $e->getMessage());
}

// 2. Proses saat Form disubmit (Metode POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_produk = trim($_POST['nama_produk'] ?? '');
    $kategori_id = $_POST['kategori_id'] ?? '';
    $supplier_id = $_POST['supplier_id'] ?? '';
    $stok        = $_POST['stok'] ?? '';
    $harga       = $_POST['harga'] ?? '';

    // Validasi sederhana
    if (empty($nama_produk) || empty($kategori_id) || empty($supplier_id) || $stok === '' || $harga === '') {
        set_flash('danger', 'Semua kolom formulir wajib diisi!');
    } else {
        try {
            // Requirement 7: Wajib menggunakan Prepared Statements
            $sql = "INSERT INTO produk (nama_produk, kategori_id, supplier_id, stok, harga) 
                    VALUES (:nama_produk, :kategori_id, :supplier_id, :stok, :harga)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nama_produk' => $nama_produk,
                ':kategori_id' => $kategori_id,
                ':supplier_id' => $supplier_id,
                ':stok'        => (int)$stok,
                ':harga'       => (float)$harga
            ]);

            // Requirement 9: Flash message & Redirect Pattern (PRG)
            set_flash('success', 'Produk berhasil ditambahkan ke inventaris!');
            redirect('index.php');

        } catch (PDOException $e) {
            set_flash('danger', 'Gagal menyimpan produk: ' . $e->getMessage());
        }
    }
}

$page_title = "Tambah Produk Baru";
require_once 'templates/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white py-3">
                <h5 class="card-title mb-0">
                    <i class="bi bi-plus-circle me-2"></i>Form Tambah Produk Komputer
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="create.php" method="POST">
                    
                    <!-- Nama Produk -->
                    <div class="mb-3">
                        <label for="nama_produk" class="form-label fw-bold">Nama Produk / Hardware</label>
                        <input type="text" name="nama_produk" id="nama_produk" class="form-control" 
                               placeholder="Contoh: Intel Core i5-13400F" required>
                    </div>

                    <div class="row">
                        <!-- Dropdown Kategori (Requirement 5) -->
                        <div class="col-md-6 mb-3">
                            <label for="kategori_id" class="form-label fw-bold">Kategori</label>
                            <select name="kategori_id" id="kategori_id" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach ($kategori_list as $kat): ?>
                                    <option value="<?= e($kat['id']); ?>">
                                        <?= e($kat['nama_kategori']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Dropdown Supplier (Requirement 5) -->
                        <div class="col-md-6 mb-3">
                            <label for="supplier_id" class="form-label fw-bold">Supplier / Distributor</label>
                            <select name="supplier_id" id="supplier_id" class="form-select" required>
                                <option value="">-- Pilih Supplier --</option>
                                <?php foreach ($supplier_list as $sup): ?>
                                    <option value="<?= e($sup['id']); ?>">
                                        <?= e($sup['nama_supplier']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Stok -->
                        <div class="col-md-6 mb-3">
                            <label for="stok" class="form-label fw-bold">Jumlah Stok (Unit)</label>
                            <input type="number" name="stok" id="stok" class="form-control" 
                                   min="0" placeholder="0" required>
                        </div>

                        <!-- Harga -->
                        <div class="col-md-6 mb-4">
                            <label for="harga" class="form-label fw-bold">Harga Satuan (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga" id="harga" class="form-control" 
                                       min="0" step="1000" placeholder="Contoh: 3500000" required>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-between pt-2 border-top">
                        <a href="index.php" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-save me-1"></i>Simpan Produk
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'templates/footer.php'; ?>