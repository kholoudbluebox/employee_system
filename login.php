<?php
session_start();
require_once 'includes/connect.php';

$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // جلب الموظف حسب البريد الإلكتروني
    $stmt = $conn->prepare("SELECT * FROM employees WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $employee = $result->fetch_assoc();

    if($employee && password_verify($password, $employee['password'])){
        // تسجيل الدخول
        $_SESSION['employee_id'] = $employee['id'];
        $_SESSION['full_name'] = $employee['full_name'];
        $_SESSION['role'] = $employee['role'];

        // إعادة التوجيه إلى index.php
        header('Location: index.php');
        exit();
    } else {
        $error = "Invalid email or password!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Employee Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="card shadow-sm p-4" style="width: 350px;">
        <h3 class="text-center mb-3">Employee Login</h3>

        <?php if($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</div>

</body>
</html>
