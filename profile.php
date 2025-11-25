<?php
session_start();

// تأكد أن الموظف مسجّل دخول
if(!isset($_SESSION['employee_id'])){
    header('Location: login.php');
    exit();
}

include 'includes/connect.php';
include 'includes/header.php';

// جلب بيانات الموظف الحالي
$employee_id = $_SESSION['employee_id'];
$stmt = $conn->prepare("SELECT * FROM employees WHERE id = ?");
$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();
$employee = $result->fetch_assoc();
$stmt->close();
?>

<h2 class="fw-bold text-primary mb-3">My Profile 👤</h2>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm p-4 border-0">
            <h5 class="mb-3">Personal Information</h5>
            <p><strong>Full Name:</strong> <?= htmlspecialchars($employee['full_name']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($employee['email']) ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($employee['phone']) ?></p>
            <p><strong>Position:</strong> <?= htmlspecialchars($employee['position']) ?></p>
            <p><strong>Salary:</strong> $<?= number_format($employee['salary'],2) ?></p>
            <p><strong>Role:</strong> <?= ucfirst($employee['role']) ?></p>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm p-4 border-0">
            <h5 class="mb-3">Change Password</h5>
            <form id="changePasswordForm">
                <div class="mb-3">
                    <label>Current Password</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>New Password</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Confirm New Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Update Password</button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<!-- jQuery & SweetAlert2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function(){
    $('#changePasswordForm').on('submit', function(e){
        e.preventDefault();
        let formData = $(this).serialize() + '&action=change_password';

        $.ajax({
            url: 'actions/employees.php',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(res){
                if(res.status === 'error'){
                    Swal.fire({ icon:'error', title:'Error', text: res.message });
                } else {
                    Swal.fire({ icon:'success', title:'Success', text: res.message });
                    $('#changePasswordForm')[0].reset();
                }
            },
            error: function(xhr,status,error){
                Swal.fire({ icon:'error', title:'AJAX Error', text: error });
            }
        });
    });
});
</script>
