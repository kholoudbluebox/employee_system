<?php
require_once '../includes/connect.php';

$search = $_GET['search'] ?? '';

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
    $employees[] = [
        'id' => $row['id'],
        'full_name' => $row['full_name'],
        'email' => $row['email'],
        'phone' => $row['phone'],
        'position' => $row['position'],
        'salary' => $row['salary'],
        'hire_date' => $row['hire_date'],
        'role' => $row['role']   // مهم جدًا
    ];
}

header('Content-Type: application/json');
echo json_encode($employees);
