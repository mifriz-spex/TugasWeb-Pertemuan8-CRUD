@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

:root {
    --primary-color: #16a34a;       /* Hijau Emerald */
    --primary-hover: #15803d;       /* Hijau Gelap untuk hover */
    --primary-light: #dcfce7;       /* Hijau Pastel Lembut */
    --dark-bg: #064e3b;             /* Hijau Gelap Elegan untuk Navbar */
    --card-bg: #ffffff;
    --border-color: #e2e8f0;
    --text-muted: #64748b;
}

body {
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
    background-color: #f0fdf4;       /* Background sedikit kehijauan lembut */
    color: #1e293b;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

/* Navbar */
.navbar {
    background-color: var(--dark-bg) !important;
    border-bottom: 3px solid var(--primary-color);
    box-shadow: 0 4px 12px rgba(6, 78, 59, 0.15);
}

.navbar-brand {
    font-weight: 700;
    font-size: 1.25rem;
    letter-spacing: -0.3px;
    color: #ffffff !important;
}

.nav-link {
    font-weight: 500;
    color: #a7f3d0 !important;
    transition: color 0.2s ease-in-out;
}

.nav-link:hover {
    color: #ffffff !important;
}

/* Card Kontainer */
.card {
    border: 1px solid var(--border-color);
    border-radius: 12px;
    background-color: var(--card-bg);
    box-shadow: 0 6px 16px rgba(22, 163, 74, 0.05);
    overflow: hidden;
}

/* Override Header Card Default Bootstrap */
.card-header.bg-primary,
.card-header.bg-success {
    background-color: var(--primary-color) !important;
    border-color: var(--primary-color) !important;
    color: #ffffff !important;
}

/* Tabel Data */
.table thead th {
    background-color: #f0fdf4;
    color: #166534;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #bbf7d0;
    padding: 14px 16px;
}

.table tbody td {
    padding: 14px 16px;
    font-size: 0.925rem;
    border-bottom: 1px solid #f1f5f9;
}

.table tbody tr:hover {
    background-color: #f7fee7;
    transition: background-color 0.15s ease-in-out;
}

/* Text & Aksen Hijau */
.text-primary, .text-success {
    color: var(--primary-color) !important;
}

/* Badge Stok */
.badge-stok-aman {
    background-color: #dcfce7;
    color: #15803d;
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 20px;
}

.badge-stok-tipis {
    background-color: #fef3c7;
    color: #b45309;
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 20px;
}

.badge-stok-habis {
    background-color: #fee2e2;
    color: #b91c1c;
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 20px;
}

/* Input Form & Focus Ring */
.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.2);
}

/* Tombol Aksi */
.btn-primary, .btn-success {
    background-color: var(--primary-color) !important;
    border-color: var(--primary-color) !important;
    color: #ffffff !important;
}

.btn-primary:hover, .btn-success:hover {
    background-color: var(--primary-hover) !important;
    border-color: var(--primary-hover) !important;
    transform: translateY(-1px);
}

.btn-outline-primary {
    color: var(--primary-color) !important;
    border-color: var(--primary-color) !important;
}

.btn-outline-primary:hover {
    background-color: var(--primary-color) !important;
    color: #ffffff !important;
}