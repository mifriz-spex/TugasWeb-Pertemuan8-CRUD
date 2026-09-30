<?php

class Database
{
    // 1. Properti statis untuk menyimpan satu-satunya instance
    private static $instance = null;
    private $pdo;

    // Konfigurasi Database (sesuaikan jika ada perubahan di Laragon kamu)
    private $host     = '127.0.0.1';
    private $db_name  = 'inventaris_db';
    private $username = 'root';
    private $password = 'r11k3dz';
    private $port     = '3306';

    // 2. Private constructor agar class ini TIDAK BISA di-instansiasi langsung dengan "new Database()"
    private function __construct()
    {
        $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name};charset=utf8mb4";
        
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lempar Exception jika ada error query
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Ambil data dalam bentuk associative array
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Gunakan native prepared statements
        ];

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            die("Koneksi Database Gagal: " . $e->getMessage());
        }
    }

    // 3. Mencegah cloning objek
    private function __clone() {}

    // 4. Mencegah unserialize objek
    public function __wakeup()
    {
        throw new Exception("Cannot unserialize a singleton.");
    }

    // 5. Method statis global untuk mengakses koneksi PDO
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Getter untuk mengambil objek PDO
    public function getConnection()
    {
        return $this->pdo;
    }
}