<?php
include '../includes/connect.php';


if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM employees WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: ../employee_list.php");
    exit;
}

if(isset($_POST['save'])){
    $id = $_POST['id'];
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    $hire = $_POST['hire_date'];

    if($id){ 
        $stmt = $conn->prepare("UPDATE employees SET full_name=?, email=?, phone=?, position=?, salary=?, hire_date=? WHERE id=?");
        $stmt->bind_param("ssssdis", $name, $email, $phone, $position, $salary, $hire, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO employees(full_name,email,phone,position,salary,hire_date) VALUES(?,?,?,?,?,?)");
        $stmt->bind_param("ssssds", $name, $email, $phone, $position, $salary, $hire);
    }

    $stmt->execute();
    $stmt->close();
    header("Location: ../employee_list.php");
    exit;
}
?>
