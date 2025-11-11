
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'connect.php';

/**
 * Retrieve all employee records
 */
function getAllEmployees($conn) {
    if (!$conn) return false;
    return $conn->query("SELECT * FROM employees ORDER BY id DESC");
}

/**
 * Verify duplicate email
 */
function isDuplicateEmail($conn, $email) {
    $stmt = $conn->prepare("SELECT id FROM employees WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $exists = $stmt->num_rows > 0;
    $stmt->close();
    return $exists;
}

/**
 * Execute data insertion
 */
function addEmployee($conn, $name, $email, $phone, $position, $salary, $hire_date) {
    $stmt = $conn->prepare("INSERT INTO employees (full_name, email, phone, position, salary, hire_date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssds", $name, $email, $phone, $position, $salary, $hire_date);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}

/**
 * Display session-based messages
 */
function displayMessage() {
    if (isset($_SESSION['message'])) {
        $type = $_SESSION['msg_type'] ?? 'info';
        echo '<div class="alert alert-' . htmlspecialchars($type) . ' mt-3">' 
            . htmlspecialchars($_SESSION['message']) . 
            '</div>';
        unset($_SESSION['message'], $_SESSION['msg_type']);
    }
}
?>
