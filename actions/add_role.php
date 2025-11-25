<?php
include '../includes/connect.php';

if(isset($_POST['role_name'])) {
    $role = trim($_POST['role_name']);

    $stmt = $conn->prepare("INSERT INTO roles (role_name) VALUES (?)");
    $stmt->bind_param("s", $role);
    $stmt->execute();
}

header("Location: ../settings.php");
exit;
