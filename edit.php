<?php
require_once 'config/Database.php';
require_once 'helpers/functions.php';

$pdo = Database::getInstance()->getConnection();

// 1. Validasi ID dari URL
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    set_flash('danger', 'ID produk tidak valid!');
    redirect('index.php');
}

// 2. Ambil data produk yang akan diedit (Requirement 6: Pre-filled & Requirement 7: Prepared Statement)
$stmt = $pdo->prepare("SELECT * FROM produk WHERE id = :id");
$stmt->execute([':id' => $id]);
$produk = $stmt->fetch();

// Jika data tidak ada di database, kembalikan ke index.php
if (!$produk) {
    set_flash('danger', 'Data produk tidak ditemukan!');
    redirect('index.php');
}

// 3. Ambil data Kategori & Supplier untuk dropdown
try {
    $kategori_list = $pdo->query("SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC")->fetchAll();
    $supplier_list = $pdo->query("SELECT id, nama_supplier FROM supplier ORDER BY nama_supplier ASC")->fetchAll();
} catch (PDOException $e) {
    die("Gagal memuat data relasi: " . $e->getMessage());
}

// 4. Proses Update saat form disubmit (Metode POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_produk = trim($_POST['nama_produk'] ?? '');
    $kategori_id = $_POST['kategori_id'] ?? '';
    $supplier_id = $_POST['supplier_id'] ?? '';
    $stok        = $_POST['stok'] ?? '';
    $harga       = $_POST['harga'] ?? '';

    // Validasi form
    if (empty($nama_produk) || empty($kategori_id) || empty($supplier_id) || $stok === '' || $harga === '') {
        set_flash('danger', 'Semua kolom formulir wajib diisi!');
    } else {
        try {
            // Requirement 7: Query update wajib pakai Prepared Statement
            $sql = "UPDATE produk 
                    SET nama_produk = :nama_produk, 
                        kategori_id = :kategori_id, 
                        supplier_id = :supplier_id, 
                        stok = :stok, 
                        harga = :harga 
                    WHERE id = :id";
            
            $stmtUpdate = $pdo->prepare($sql);
            $stmtUpdate->execute([
                ':nama_produk' => $nama_produk,
                ':kategori_id' => $kategori_id,
                ':supplier_id' => $supplier_id,
                ':stok'        => (int)$stok,
                ':harga'       => (float)$harga,
                ':id'          => $id
            ]);

            // Requirement 9: Flash message & Redirect
            set_flash('success', "Data produk '{$nama_produk}' berhasil diperbarui!");
            redirect('index.php');

        } catch (PDOException $e) {
            set_flash('danger', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }
}

$page_title = "Edit Produk";
require_once 'templates/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-warning text-dark py-3">
                <h5 class="card-title mb-0 fw-bold">
                    <i class="bi bi-pencil-square me-2"></i>Form Edit Produk Komputer
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="edit.php?id=<?= e($produk['id']); ?>" method="POST">
                    
                    <!-- Nama Produk (Pre-filled value) -->
                    <div class="mb-3">
                        <label for="nama_produk" class="form-label fw-bold">Nama Produk / Hardware</label>
                        <input type="text" name="nama_produk" id="nama_produk" class="form-control" 
                               value="<?= e($produk['nama_produk']); ?>" required>
                    </div>

                    <div class="row">
                        <!-- Dropdown Kategori (Pre-selected) -->
                        <div class="col-md-6 mb-3">
                            <label for="kategori_id" class="form-label fw-bold">Kategori</label>
                            <select name="kategori_id" id="kategori_id" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach ($kategori_list as $kat): ?>
                                    <option value="<?= e($kat['id']); ?>" <?= ($kat['id'] == $produk['kategori_id']) ? 'selected' : ''; ?>>
                                        <?= e($kat['nama_kategori']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Dropdown Supplier (Pre-selected) -->
                        <div class="col-md-6 mb-3">
                            <label for="supplier_id" class="form-label fw-bold">Supplier / Distributor</label>
                            <select name="supplier_id" id="supplier_id" class="form-select" required>
                                <option value="">-- Pilih Supplier --</option>
                                <?php foreach ($supplier_list as $sup): ?>
                                    <option value="<?= e($sup['id']); ?>" <?= ($sup['id'] == $produk['supplier_id']) ? 'selected' : ''; ?>>
                                        <?= e($sup['nama_supplier']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Stok (Pre-filled value) -->
                        <div class="col-md-6 mb-3">
                            <label for="stok" class="form-label fw-bold">Jumlah Stok (Unit)</label>
                            <input type="number" name="stok" id="stok" class="form-control" 
                                   min="0" value="<?= e($produk['stok']); ?>" required>
                        </div>

                        <!-- Harga (Pre-filled value) -->
                        <div class="col-md-6 mb-4">
                            <label for="harga" class="form-label fw-bold">Harga Satuan (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="harga" id="harga" class="form-control" 
                                       min="0" step="1000" value="<?= e((int)$produk['harga']); ?>" required>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-between pt-2 border-top">
                        <a href="index.php" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-warning px-4 fw-bold">
                            <i class="bi bi-check-circle me-1"></i>Update Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once 'templates/footer.php'; ?>