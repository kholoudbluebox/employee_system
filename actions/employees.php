<?php
require_once '../includes/connect.php';
header('Content-Type: application/json');

function send_response($status,$message){
    echo json_encode(['status'=>$status,'message'=>$message]);
    exit;
}

// ---------- ADD ----------
if(isset($_POST['add'])){
    // Server-side validation
    if(empty($_POST['full_name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['position']) || empty($_POST['salary']) || empty($_POST['hire_date'])){
        send_response('error','All fields are required.');
    }
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        send_response('error','Invalid email format.');
    }
    if(!is_numeric($_POST['salary'])){
        send_response('error','Salary must be a number.');
    }

    $stmt = $conn->prepare("INSERT INTO employees (full_name,email,phone,position,salary,hire_date) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("ssssds", $_POST['full_name'],$_POST['email'],$_POST['phone'],$_POST['position'],$_POST['salary'],$_POST['hire_date']);
    if($stmt->execute()){
        send_response('success','Employee added successfully');
    } else send_response('error','Failed to add employee.');
}

// ---------- EDIT ----------
if(isset($_POST['edit'])){
    if(empty($_POST['full_name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['position']) || empty($_POST['salary']) || empty($_POST['hire_date'])){
        send_response('error','All fields are required.');
    }
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        send_response('error','Invalid email format.');
    }
    if(!is_numeric($_POST['salary'])){
        send_response('error','Salary must be a number.');
    }

    $stmt = $conn->prepare("UPDATE employees SET full_name=?, email=?, phone=?, position=?, salary=?, hire_date=? WHERE id=?");
    $stmt->bind_param("ssssdsi", $_POST['full_name'],$_POST['email'],$_POST['phone'],$_POST['position'],$_POST['salary'],$_POST['hire_date'], $_POST['id']);
    if($stmt->execute()){
        send_response('success','Employee updated successfully');
    } else send_response('error','Failed to update employee.');
}

// ---------- DELETE ----------
if(isset($_POST['delete'])){
    $stmt = $conn->prepare("DELETE FROM employees WHERE id=?");
    $stmt->bind_param("i", $_POST['id']);
    if($stmt->execute()){
        send_response('success','Employee deleted successfully');
    } else send_response('error','Failed to delete employee.');
}
?>