<?php
ob_clean();
header('Content-Type: application/json');
session_start();

require_once '../includes/connect.php';
require_once '../includes/Employee.php';

$res = [];

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method.");
    }

    // ✅ تغيير كلمة السر أولاً لأنه مستقل
    if (isset($_POST['action']) && $_POST['action'] === 'change_password') {

        if (!isset($_SESSION['employee_id'])) {
            throw new Exception("Not authorized");
        }

        $employee_id = $_SESSION['employee_id'];
        $current = $_POST['current_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if ($new !== $confirm) {
            throw new Exception("New passwords do not match");
        }

        $stmt = $conn->prepare("SELECT password FROM employees WHERE id = ?");
        $stmt->bind_param("i", $employee_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $employee = $result->fetch_assoc();
        $stmt->close();

        if (!$employee || !password_verify($current, $employee['password'])) {
            throw new Exception("Incorrect current password");
        }

        $new_hash = password_hash($new, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE employees SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $new_hash, $employee_id);

        if ($stmt->execute()) {
            $res = ['status' => 'success', 'message' => 'Password updated successfully ✅'];
        } else {
            throw new Exception("Failed to update password");
        }

        $stmt->close();
    
    } else {

        // ✅ باقي العمليات
        $employee = new Employee($conn);

        if (isset($_POST['add'])) {

            $full_name = $_POST['full_name'] ?? '';
            $email     = $_POST['email'] ?? '';
            $phone     = $_POST['phone'] ?? '';
            $position  = $_POST['position'] ?? '';
            $salary    = floatval($_POST['salary'] ?? 0);
            $hire_date = $_POST['hire_date'] ?? '';
            $role      = $_POST['role'] ?? '';
            $password  = $_POST['password'] ?? '';

            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("
                INSERT INTO employees (full_name, email, phone, position, salary, hire_date, role, password) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->bind_param("ssssdsss", $full_name, $email, $phone, $position, $salary, $hire_date, $role, $password_hash);

            if ($stmt->execute()) {
                $res = ['status'=>'success', 'message'=>'Employee added successfully'];
            } else {
                throw new Exception("Failed to add employee");
            }

            $stmt->close();

        } elseif (isset($_POST['edit'])) {
            $res = $employee->edit($_POST);

        } elseif (isset($_POST['delete'])) {
            $id = $_POST['id'] ?? 0;
            $res = $employee->delete($id);

        } else {
            throw new Exception("Invalid action.");
        }
    }

} catch (Exception $e) {
    $res = ['status' => 'error', 'message' => $e->getMessage()];
}

$conn->close();
echo json_encode($res);
