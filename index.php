<?php
session_start();

if(!isset($_SESSION['employee_id'])){
    header('Location: login.php');
    exit();
}

require_once 'includes/connect.php';

// تحديد الصلاحيات حسب الدور
$role = $_SESSION['role'];
$canAdd = $role === 'admin' || $role === 'manager';
$canEdit = $role === 'admin' || $role === 'manager';
$canDelete = $role === 'admin';
?>

<?php include 'includes/header.php'; ?>

<h2>Welcome </h2>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold text-primary"><?= $_SESSION['full_name'] ?> (<?= ucfirst($role) ?>)</h2>
    <?php if($canAdd): ?>

    <?php endif; ?>
</div>

<!-- باقي جدول الموظفين بنفس الكود السابق مع DataTable -->
