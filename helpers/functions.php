<?php

// Pastikan session sudah aktif untuk mendukung flash message
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * 1. Helper Sanitasi Output HTML (Requirement 8)
 * Mencegah serangan XSS dengan htmlspecialchars()
 */
function e($data)
{
    return htmlspecialchars($data ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * 2. Helper Flash Message - Menyimpan Pesan (Requirement 9)
 * @param string $type ('success' atau 'danger' / 'error')
 * @param string $message (Pesan notifikasi)
 */
function set_flash($type, $message)
{
    $_SESSION['flash'] = [
        'type'    => $type,    // 'success' untuk hijau, 'danger' untuk merah
        'message' => $message
    ];
}

/**
 * 3. Helper Flash Message - Menampilkan & Menghapus Pesan (Requirement 9)
 * Pesan langsung dihapus setelah ditampilkan (Flash)
 */
function display_flash()
{
    if (isset($_SESSION['flash'])) {
        $type    = $_SESSION['flash']['type'];
        $message = $_SESSION['flash']['message'];

        // Hapus flash message dari session agar hanya tampil sekali
        unset($_SESSION['flash']);

        // Render alert box (HTML rapi yang kompatibel dengan Bootstrap/CSS biasa)
        echo '
        <div class="alert alert-' . e($type) . '" style="padding: 12px 16px; margin-bottom: 20px; border-radius: 6px; font-weight: 500; ' 
            . ($type === 'success' ? 'background-color: #d1e7dd; color: #0f5132; border: 1px solid #badbcc;' : 'background-color: #f8d7da; color: #842029; border: 1px solid #f5c2c7;') 
            . '">
            ' . e($message) . '
        </div>';
    }
}

/**
 * 4. Helper Redirect (Redirect Pattern)
 * Membantu pola Post-Redirect-Get (PRG)
 */
function redirect($url)
{
    header("Location: " . $url);
    exit;
}

/**
 * 5. Helper Tambahan: Format Mata Uang Rupiah (Sangat berguna untuk toko komputer)
 */
function format_rupiah($angka)
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}