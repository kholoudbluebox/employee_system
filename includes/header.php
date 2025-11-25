<?php
include 'functions.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FreeWork</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<style>
  body { padding-top: 70px; }
  .logo { height: 45px; }

  /* Sidebar */
  .sidebar {
    width: 230px;
    height: 100vh;
    position: fixed;
    top: 70px;
    left: 0;
    background: linear-gradient(180deg, #0d6efd, #0748b8);
    color: white;
    padding-top: 20px;
    box-shadow: 2px 0px 10px rgba(0,0,0,0.15);
    border-right: 1px solid rgba(255,255,255,0.2);
    overflow-y: auto;
  }

  .sidebar .menu-title {
    font-size: 13px;
    text-transform: uppercase;
    opacity: 0.8;
    padding: 0 20px;
    margin-bottom: 8px;
    letter-spacing: 1px;
  }

  .sidebar a {
    display: flex;
    align-items: center;
    gap: 12px;
    color: white;
    padding: 12px 20px;
    text-decoration: none;
    font-size: 15px;
    transition: 0.25s;
    border-radius: 6px;
    margin: 4px 12px;
  }

  .sidebar a:hover {
    background: rgba(255,255,255,0.2);
    transform: translateX(6px);
  }

  .sidebar .divider {
    height: 1px;
    background: rgba(255,255,255,0.3);
    margin: 15px 20px;
  }

  /* Page Content */
  .content {
    margin-left: 250px;
    padding: 25px;
  }
</style>
</head>
<body>

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
      <img src="assets/images/kk.png" alt="Logo" class="logo">
      <span>FreeWork</span>
    </a>
  </div>
</nav>

<!-- ✅ Sidebar -->
<div class="sidebar">
  <div class="menu-title">Main</div>

  <a href="index.php">🏠 Home</a>
  <a href="employees.php">👥 Employees</a>

  <div class="divider"></div>

  <div class="menu-title">System</div>

    <a href="profile.php">🧑‍💻 Profile</a>
  <a href="settings.php">⚙️ Settings</a>

  <div class="divider"></div>

  <a href="logout.php">🚪 Logout</a>
</div>

<!-- ✅ Start Page Content Wrapper -->
<div class="content">
