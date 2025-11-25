<?php


// ✅ لو المستخدم مش عامل تسجيل دخول
if (!isset($_SESSION['employee_id'])) {
    header("Location: login.php");
    exit();
}

// ✅ حماية من تغيير الدور يدويًا
$allowed_roles = ['admin', 'manager', 'employee'];

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $allowed_roles)) {
    header("Location: login.php");
    exit();
}
?>
