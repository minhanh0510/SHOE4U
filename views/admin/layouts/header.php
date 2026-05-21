<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Shoe4U</title>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="/Shoe4U_1/assets/css/style.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>

body {
  background: var(--snow);
  padding-top: 0;
}

.admin-header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 64px;
  background: linear-gradient(135deg, var(--ink) 0%, var(--ink2) 100%);
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 24px;
  z-index: 1000;
  box-shadow: var(--shadow-sm);
}

.header-left {
  display: flex;
  align-items: center;
  gap: 12px;
}

.header-left .logo-icon {
  width: 40px;
  height: 40px;
  border-radius: 12px;
  background: linear-gradient(135deg, var(--blue), var(--blue-mid));
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 18px;
  box-shadow: 0 5px 18px rgba(75,184,240,.42);
}

.header-left .logo-text {
  display: flex;
  flex-direction: column;
  line-height: 1.1;
}

.header-left .logo-name {
  font-family: 'Outfit', sans-serif;
  font-size: 18px;
  font-weight: 900;
  color: white;
  letter-spacing: -0.5px;
}

.header-left .logo-name em {
  color: var(--blue);
  font-style: normal;
}

.header-left .logo-tagline {
  font-size: 9px;
  font-weight: 700;
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--mist);
  margin-top: 1px;
}

.header-right {
  display: flex;
  align-items: center;
  gap: 20px;
}

.header-right .admin-name {
  color: rgba(255,255,255,0.7);
  font-size: 13px;
  font-weight: 500;
}

.logout-btn {
  background: rgba(255,255,255,0.1);
  padding: 8px 16px;
  border-radius: 30px;
  color: white;
  text-decoration: none;
  font-size: 13px;
  font-weight: 500;
  transition: all 0.2s;
  display: flex;
  align-items: center;
  gap: 6px;
}

.logout-btn:hover {
  background: var(--danger);
  color: white;
}

.admin-container {
  display: flex;
  margin-top: 64px;
  min-height: calc(100vh - 64px);
}

.sidebar {
  width: 260px;
  background: var(--white);
  border-right: 1px solid var(--fog);
  position: fixed;
  top: 64px;
  bottom: 0;
  left: 0;
  overflow-y: auto;
  box-shadow: var(--shadow-xs);
}

.sidebar-menu {
  list-style: none;
  padding: 20px 0;
}

.sidebar-menu li {
  margin-bottom: 4px;
}

.sidebar-menu li a {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 20px;
  color: var(--slate);
  text-decoration: none;
  font-weight: 500;
  transition: var(--t);
  border-left: 3px solid transparent;
}

.sidebar-menu li a i {
  width: 20px;
  text-align: center;
  font-size: 16px;
  color: var(--blue);
}

.sidebar-menu li:hover a {
  color: var(--blue-mid);
  background: var(--blue-pale);
}

.sidebar-menu li.active a {
  color: var(--blue-mid);
  background: rgba(75,184,240,0.08);
  border-left-color: var(--blue);
  font-weight: 600;
}

.main-content {
  flex: 1;
  margin-left: 260px;
  padding: 24px 28px;
  padding-bottom: 80px;
}

.content-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
  flex-wrap: wrap;
  gap: 12px;
}

.content-header h1 {
  font-size: 24px;
  font-weight: 700;
  color: var(--ink);
  display: flex;
  align-items: center;
  gap: 10px;
  font-family: 'Playfair Display', serif;
}

.content-header h1 i {
  color: var(--blue);
  font-size: 22px;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  margin-bottom: 28px;
}

.stat-card {
  background: var(--white);
  border-radius: var(--r-lg);
  padding: 20px;
  display: flex;
  align-items: center;
  gap: 16px;
  border: 1px solid var(--fog);
  transition: var(--t);
  text-decoration: none;
  box-shadow: var(--shadow-xs);
}

.stat-card:hover {
  transform: translateY(-2px);
  box-shadow: var(--shadow-sm);
  border-color: var(--blue);
}

.stat-icon {
  width: 52px;
  height: 52px;
  border-radius: var(--r);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
}

.stat-info h3 {
  font-size: 28px;
  font-weight: 700;
  color: var(--ink);
  line-height: 1.2;
  font-family: 'Outfit', sans-serif;
}

.stat-info p {
  font-size: 13px;
  color: var(--mist);
  margin-top: 4px;
  font-weight: 500;
}

.stat-link {
  text-decoration: none !important;
  color: inherit !important;
  display: block;
}

.stat-link * {
  text-decoration: none !important;
}

.card {
  background: var(--white);
  border-radius: var(--r-xl);
  border: 1px solid var(--fog);
  overflow: hidden;
  margin-bottom: 20px;
  box-shadow: var(--shadow-xs);
}

.card-header {
  padding: 16px 20px;
  border-bottom: 1px solid var(--fog);
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: rgba(232, 241, 244, 0.02);
}

.card-header h3 {
  font-size: 16px;
  font-weight: 600;
  color: var(--ink);
  display: flex;
  align-items: center;
  gap: 8px;
  font-family: 'Outfit', sans-serif;
}

.card-header h3 i {
  color: var(--blue);
}

.card-body {
  padding: 20px;
}

.table {
  width: 100%;
  border-collapse: collapse;
}

.table thead th {
  text-align: left;
  padding: 12px 12px;
  background: var(--blue-pale);
  font-size: 12px;
  font-weight: 600;
  color: var(--steel);
  border-bottom: 1px solid var(--fog);
}

.table tbody td {
  padding: 12px 12px;
  border-bottom: 1px solid var(--fog);
  vertical-align: middle;
}

.table tbody tr:hover {
  background: rgba(75,184,240,0.03);
}

.table-responsive {
  overflow-x: auto;
}

.badge {
  display: inline-block;
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 600;
}

.badge-success { background: #E8F5E9; color: #2E7D32; }
.badge-danger { background: #FFEBEE; color: #C62828; }
.badge-warning { background: #FFF8E1; color: #F57C00; }
.badge-info { background: #E3F2FD; color: #1565C0; }
.badge-primary { background: #E3F2FD; color: #1976D2; }
.badge-secondary { background: #F1F5F9; color: #475569; }

.btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 8px 16px;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 500;
  text-decoration: none;
  cursor: pointer;
  transition: var(--t);
  border: none;
  font-family: 'Outfit', sans-serif;
}

.btn-primary {
  background: linear-gradient(135deg, var(--blue), var(--blue-mid));
  color: white;
  box-shadow: 0 4px 12px rgba(75,184,240,.3);
}

.btn-primary:hover {
  transform: translateY(-1px);
  box-shadow: 0 6px 18px rgba(75,184,240,.45);
}

.btn-secondary {
  background: #F1F5F9;
  color: #475569;
}

.btn-secondary:hover {
  background: #E2E8F0;
}

.btn-danger {
  background: var(--danger);
  color: white;
}

.btn-danger:hover {
  background: #DC2626;
}

.btn-success {
  background: var(--success);
  color: white;
}

.btn-success:hover {
  background: #16A34A;
}

.btn-sm {
  padding: 5px 10px;
  font-size: 12px;
}

.btn-info {
  background: #E3F2FD;
  color: #1976D2;
}

.btn-warning {
  background: #FFF8E1;
  color: #F57C00;
}

.btn-view-all {
  background: transparent;
  color: var(--blue);
  font-size: 12px;
  font-weight: 600;
  text-decoration: none;
}

.btn-view-all:hover {
  text-decoration: underline;
}

.form-group {
  margin-bottom: 18px;
}

.form-group label {
  display: block;
  font-size: 11.5px;
  font-weight: 700;
  margin-bottom: 6px;
  color: var(--slate);
  letter-spacing: 0.5px;
  text-transform: uppercase;
}

.form-group .required {
  color: var(--danger);
}

.form-control {
  width: 100%;
  padding: 10px 14px;
  border: 1.5px solid var(--fog);
  border-radius: var(--r-lg);
  font-size: 14px;
  transition: var(--t);
  font-family: 'Outfit', sans-serif;
  background: var(--white);
}

.form-control:focus {
  outline: none;
  border-color: var(--blue);
  box-shadow: 0 0 0 3px rgba(75,184,240,0.1);
}

textarea.form-control {
  resize: vertical;
  min-height: 100px;
}

select.form-control {
  cursor: pointer;
}

.form-inline {
  display: flex;
  gap: 10px;
  align-items: center;
  flex-wrap: wrap;
}

.form-actions {
  margin-top: 20px;
  padding-top: 20px;
  border-top: 1px solid var(--fog);
  display: flex;
  gap: 10px;
}

.row {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 20px;
}

.col-6 { grid-column: span 1; }
.col-12 { grid-column: span 2; }

@media (max-width: 768px) {
  .row { grid-template-columns: 1fr; }
  .col-6 { grid-column: span 1; }
}

.pagination {
  display: flex;
  gap: 8px;
  margin-top: 20px;
  justify-content: center;
  flex-wrap: wrap;
}

.pagination a {
  padding: 8px 12px;
  border: 1px solid var(--fog);
  border-radius: 8px;
  text-decoration: none;
  color: var(--mist);
  font-size: 13px;
  transition: var(--t);
}

.pagination a:hover {
  border-color: var(--blue);
  color: var(--blue-mid);
}

.pagination a.active {
  background: linear-gradient(135deg, var(--blue), var(--blue-mid));
  color: white;
  border-color: transparent;
}

.alert {
  padding: 14px 18px;
  border-radius: var(--r-lg);
  margin-bottom: 20px;
  font-size: 13px;
  font-weight: 500;
}

.alert-success {
  background: #ECFDF5;
  color: #065F46;
  border-left: 4px solid var(--success);
}

.alert-danger {
  background: #FEF2F2;
  color: #991B1B;
  border-left: 4px solid var(--danger);
}

.info-table {
  width: 100%;
}

.info-table tr {
  border-bottom: 1px solid var(--fog);
}

.info-table th {
  width: 150px;
  padding: 10px;
  font-weight: 600;
  color: var(--mist);
  text-align: left;
}

.info-table td {
  padding: 10px;
}

.image-gallery {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
  gap: 15px;
}

.image-item {
  position: relative;
  border: 1px solid var(--fog);
  border-radius: var(--r);
  padding: 5px;
  background: var(--white);
}

.image-item img {
  width: 100%;
  height: 150px;
  object-fit: cover;
  border-radius: 8px;
}

.image-actions {
  position: absolute;
  top: 8px;
  right: 8px;
}

.btn-delete-image {
  display: inline-block;
  width: 30px;
  height: 30px;
  background: var(--danger);
  color: #fff;
  text-align: center;
  line-height: 30px;
  border-radius: 8px;
  text-decoration: none;
  transition: var(--t);
}

.btn-delete-image:hover {
  background: #DC2626;
  transform: scale(1.05);
}

.chart-container {
  width: 100%;
  max-width: 350px;
  height: 250px;
  margin: auto;
}

.actions {
  white-space: nowrap;
  display: flex;
  gap: 6px;
  flex-wrap: wrap;
}

@media (max-width: 768px) {
  .sidebar {
    width: 70px;
  }
  .sidebar-menu li a span {
    display: none;
  }
  .sidebar-menu li a i {
    margin: 0;
  }
  .main-content {
    margin-left: 70px;
  }
  .stats-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 480px) {
  .stats-grid {
    grid-template-columns: 1fr;
  }
  .content-header {
    flex-direction: column;
    align-items: flex-start;
  }
}
</style>
</head>
<body>

<header class="admin-header">
    <div class="header-left">
        <div class="logo-icon"><i class="fas fa-shoe-prints"></i></div>
        <div class="logo-text">
            <span class="logo-name">Shoe<em>4U</em> Admin</span>
            <span class="logo-tagline">Management Panel</span>
        </div>
    </div>
    <div class="header-right">
        <span class="admin-name"><i class="fas fa-user-circle"></i> <?= $_SESSION['full_name'] ?? 'Admin' ?></span>
        <a href="<?= ADMIN_URL ?>logout.php" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i> Đăng xuất
        </a>
    </div>
</header>

<div class="admin-container">