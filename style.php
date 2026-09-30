/* ========================================================
   Custom Styling - Inventaris Toko Komputer (KompuStore)
   ======================================================== */

@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

:root {
    --primary-color: #2563eb;
    --primary-hover: #1d4ed8;
    --dark-bg: #0f172a;
    --card-bg: #ffffff;
    --border-color: #e2e8f0;
    --text-muted: #64748b;
}

body {
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
    background-color: #f1f5f9;
    color: #1e293b;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

/* Navbar */
.navbar {
    background-color: var(--dark-bg) !important;
    border-bottom: 2px solid #334155;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.navbar-brand {
    font-weight: 700;
    font-size: 1.25rem;
    letter-spacing: -0.3px;
}

.nav-link {
    font-weight: 500;
    transition: color 0.2s ease-in-out;
}

.nav-link:hover {
    color: #60a5fa !important;
}

/* Card Kontainer */
.card {
    border: 1px solid var(--border-color);
    border-radius: 12px;
    background-color: var(--card-bg);
    box-shadow: 0 6px 16px rgba(15, 23, 42, 0.04);
    overflow: hidden;
}

.card-header {
    border-bottom: 1px solid var(--border-color);
    font-weight: 600;
}

/* Tabel Data */
.table {
    margin-bottom: 0;
    vertical-align: middle;
}

.table thead th {
    background-color: #f8fafc;
    color: #475569;
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid var(--border-color);
    padding: 14px 16px;
}

.table tbody td {
    padding: 14px 16px;
    font-size: 0.925rem;
    border-bottom: 1px solid #f1f5f9;
}

.table tbody tr:hover {
    background-color: #f8fafc;
    transition: background-color 0.15s ease-in-out;
}

/* Badge Stok & Kategori */
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

/* Form Input & Select */
.form-label {
    color: #334155;
    font-size: 0.9rem;
    margin-bottom: 6px;
}

.form-control, .form-select {
    border: 1.5px solid #cbd5e1;
    border-radius: 8px;
    padding: 9px 14px;
    font-size: 0.925rem;
    transition: all 0.2s ease-in-out;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
}

/* Tombol Aksi */
.btn {
    border-radius: 8px;
    font-weight: 600;
    padding: 8px 16px;
    transition: all 0.2s ease-in-out;
}

.btn-sm {
    padding: 5px 10px;
    font-size: 0.85rem;
    border-radius: 6px;
}

.btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-primary:hover {
    background-color: var(--primary-hover);
    border-color: var(--primary-hover);
    transform: translateY(-1px);
}

/* Flash Alert Styling */
.alert {
    border-radius: 8px;
    border: none;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
}

/* Footer */
footer {
    margin-top: auto;
    border-top: 1px solid var(--border-color);
    background-color: #ffffff;
}