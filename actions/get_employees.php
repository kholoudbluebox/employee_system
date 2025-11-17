<?php
require_once '../includes/connect.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT * FROM employees
          WHERE full_name LIKE ? OR email LIKE ? OR phone LIKE ? 
          ORDER BY id DESC";
$stmt = $conn->prepare($query);
$param = "%$search%";
$stmt->bind_param("sss", $param, $param, $param);
$stmt->execute();
$result = $stmt->get_result();

$employees = [];
while($row = $result->fetch_assoc()){
    $employees[] = $row;
}

header('Content-Type: application/json');
echo json_encode($employees);
