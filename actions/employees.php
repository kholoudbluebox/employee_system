<?php
include '../includes/functions.php';

function clean_input($data) {
  return htmlspecialchars(trim($data));
}

if (isset($_POST['edit'])) {

    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    $hire_date = $_POST['hire_date'];

    // Prepared statement لتأمين البيانات
    $stmt = $conn->prepare("UPDATE employees SET full_name=?, email=?, phone=?, position=?, salary=?, hire_date=? WHERE id=?");
    $stmt->bind_param("ssssssi", $full_name, $email, $phone, $position, $salary, $hire_date, $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Employee updated successfully!";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Failed to update employee!";
        $_SESSION['msg_type'] = "danger";
    }

    header("Location: ../index.php");
    exit;
}


/* ---------------- ADD EMPLOYEE ---------------- */
if(isset($_POST['add'])){
  $name = clean_input($_POST['full_name']);
  $email = clean_input($_POST['email']);
  $phone = clean_input($_POST['phone']);
  $position = clean_input($_POST['position']);
  $salary = clean_input($_POST['salary']);
  $hire = clean_input($_POST['hire_date']);

  if(empty($name) || empty($email) || empty($phone) || empty($position) || empty($salary) || empty($hire)) {
    $_SESSION['message'] = "⚠️ All fields are required!";
    $_SESSION['msg_type'] = "warning";
    header("Location: ../index.php");
    exit;
  }

  $check = $conn->prepare("SELECT id FROM employees WHERE email=? OR phone=?");
  $check->bind_param("ss", $email, $phone);
  $check->execute();
  $check->store_result();

  if($check->num_rows > 0){
    $_SESSION['message'] = "🚫 Email or phone number already exists!";
    $_SESSION['msg_type'] = "danger";
    $check->close();
    header("Location: ../index.php");
    exit;
  }
  $check->close();

  $stmt = $conn->prepare("INSERT INTO employees(full_name, email, phone, position, salary, hire_date) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssds", $name, $email, $phone, $position, $salary, $hire);
  $stmt->execute();
  $stmt->close();

  $_SESSION['message'] = "✅ Employee added successfully!";
  $_SESSION['msg_type'] = "success";
  header("Location: ../index.php");
  exit;
}
if (isset($_POST['delete'])) {
    $id = intval($_POST['id']);
    $stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    $_SESSION['message'] = "Employee deleted successfully.";
    $_SESSION['msg_type'] = "danger";
    header("Location: ../index.php");
    exit;
}


/* ---------------- UPDATE EMPLOYEE ---------------- */
if(isset($_POST['edit'])){
  $id = intval($_POST['id']);
  $name = clean_input($_POST['full_name']);
  $email = clean_input($_POST['email']);
  $phone = clean_input($_POST['phone']);
  $position = clean_input($_POST['position']);
  $salary = clean_input($_POST['salary']);
  $hire = clean_input($_POST['hire_date']);

  if(empty($name) || empty($email) || empty($phone) || empty($position) || empty($salary) || empty($hire)) {
    $_SESSION['message'] = "⚠️ All fields are required!";
    $_SESSION['msg_type'] = "warning";
    header("Location: ../index.php");
    exit;
  }

  $check = $conn->prepare("SELECT id FROM employees WHERE (email=? OR phone=?) AND id!=?");
  $check->bind_param("ssi", $email, $phone, $id);
  $check->execute();
  $check->store_result();

  if($check->num_rows > 0){
    $_SESSION['message'] = "🚫 Email or phone number already exists!";
    $_SESSION['msg_type'] = "danger";
    $check->close();
    header("Location: ../index.php");
    exit;
  }
  $check->close();

  $stmt = $conn->prepare("UPDATE employees SET full_name=?, email=?, phone=?, position=?, salary=?, hire_date=? WHERE id=?");
  $stmt->bind_param("ssssdsi", $name, $email, $phone, $position, $salary, $hire, $id);
  $stmt->execute();
  $stmt->close();

  $_SESSION['message'] = "✏️ Employee updated successfully!";
  $_SESSION['msg_type'] = "info";
  header("Location: ../index.php");
  exit;
}
?>
