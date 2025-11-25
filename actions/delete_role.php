<?php
include '../includes/connect.php';

if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM roles WHERE id = $id");
}

header("Location: ../settings.php");
exit;
