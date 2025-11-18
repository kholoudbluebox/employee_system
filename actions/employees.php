<?php
require_once '../includes/connect.php';

if(isset($_POST['add'])){
    $stmt = $conn->prepare("INSERT INTO employees (full_name,email,phone,position,salary,hire_date) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("ssssds", $_POST['full_name'],$_POST['email'],$_POST['phone'],$_POST['position'],$_POST['salary'],$_POST['hire_date']);
    $stmt->execute();
    echo "success";
}

if(isset($_POST['edit'])){
    $stmt = $conn->prepare("UPDATE employees SET full_name=?, email=?, phone=?, position=?, salary=?, hire_date=? WHERE id=?");
    $stmt->bind_param("ssssdsi", $_POST['full_name'],$_POST['email'],$_POST['phone'],$_POST['position'],$_POST['salary'],$_POST['hire_date'], $_POST['id']);
    $stmt->execute();
    echo "success";
}

if(isset($_POST['delete'])){
    $stmt = $conn->prepare("DELETE FROM employees WHERE id=?");
    $stmt->bind_param("i", $_POST['id']);
    $stmt->execute();
    echo "success";
}