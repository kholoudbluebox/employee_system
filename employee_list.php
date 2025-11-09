<?php include 'includes/header.php'; ?>
<?php include 'includes/connect.php'; ?>

<h2>Employee List</h2>
<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#employeeModal">Add Employee</button>

<?php
$result = $conn->query("SELECT * FROM employees ORDER BY id DESC");
?>

<table class="table table-bordered bg-white">
    <thead class="table-dark">
        <tr>
            <th>Full Name</th><th>Email</th><th>Phone</th><th>Position</th><th>Salary</th><th>Hire Date</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if($result->num_rows > 0): ?>
        <?php while($emp = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($emp['full_name']) ?></td>
            <td><?= htmlspecialchars($emp['email']) ?></td>
            <td><?= htmlspecialchars($emp['phone']) ?></td>
            <td><?= htmlspecialchars($emp['position']) ?></td>
            <td><?= htmlspecialchars($emp['salary']) ?></td>
            <td><?= htmlspecialchars($emp['hire_date']) ?></td>
            <td>
                <button class="btn btn-sm btn-warning" 
                    data-bs-toggle="modal" 
                    data-bs-target="#employeeModal" 
                    data-id="<?= $emp['id'] ?>"
                    data-name="<?= htmlspecialchars($emp['full_name'], ENT_QUOTES) ?>"
                    data-email="<?= htmlspecialchars($emp['email'], ENT_QUOTES) ?>"
                    data-phone="<?= htmlspecialchars($emp['phone'], ENT_QUOTES) ?>"
                    data-position="<?= htmlspecialchars($emp['position'], ENT_QUOTES) ?>"
                    data-salary="<?= $emp['salary'] ?>"
                    data-hire="<?= $emp['hire_date'] ?>">
                    Edit
                </button>
                <a href="actions/employees.php?delete=<?= $emp['id'] ?>" 
                   class="btn btn-sm btn-danger"
                   onclick="return confirm('Are you sure you want to delete this employee?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="7" class="text-center">No employees found</td></tr>
    <?php endif; ?>
    </tbody>
</table>

<?php include 'includes/footer.php'; ?>
