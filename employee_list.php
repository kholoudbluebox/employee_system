<?php
include 'includes/header.php';
?>

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold text-primary">Employee List</h2>
    <button class="btn btn-success shadow-sm" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
      ➕ Add Employee
    </button>
  </div>

  <?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-<?= $_SESSION['msg_type'] ?> alert-dismissible fade show" role="alert">
      <?= $_SESSION['message'] ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['message']); unset($_SESSION['msg_type']); ?>
  <?php endif; ?>

  <?php $result = getAllEmployees($conn); ?>

  <div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">
      <table id="employeeTable" class="table table-hover align-middle mb-0">
        <thead class="table-dark">
          <tr>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Position</th>
            <th>Salary</th>
            <th>Hire Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($emp = $result->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($emp['full_name']) ?></td>
                <td><?= htmlspecialchars($emp['email']) ?></td>
                <td><?= htmlspecialchars($emp['phone']) ?></td>
                <td><?= htmlspecialchars($emp['position']) ?></td>
                <td>$<?= number_format($emp['salary'], 2) ?></td>
                <td><?= date('d M Y', strtotime($emp['hire_date'])) ?></td>
                <td>
                  <button
                    class="btn btn-sm btn-warning edit-btn me-1"
                    data-id="<?= $emp['id'] ?>"
                    data-name="<?= htmlspecialchars($emp['full_name'], ENT_QUOTES) ?>"
                    data-email="<?= htmlspecialchars($emp['email'], ENT_QUOTES) ?>"
                    data-phone="<?= htmlspecialchars($emp['phone'], ENT_QUOTES) ?>"
                    data-position="<?= htmlspecialchars($emp['position'], ENT_QUOTES) ?>"
                    data-salary="<?= htmlspecialchars($emp['salary'], ENT_QUOTES) ?>"
                    data-hire="<?= htmlspecialchars($emp['hire_date'], ENT_QUOTES) ?>"
                    data-bs-toggle="modal"
                    data-bs-target="#editEmployeeModal">
                    ✏️ Edit
                  </button>
                  <a href="actions/employees.php?delete=<?= $emp['id'] ?>"
                    class="btn btn-sm btn-danger"
                    onclick="return confirm('Are you sure you want to delete this employee?')">
                    🗑️ Delete
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="7" class="text-center text-muted">No employees found</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- 🔹 Add Employee Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="actions/employees.php">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Add Employee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3"><label>Full Name</label><input type="text" name="full_name" class="form-control" required></div>
          <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
          <div class="mb-3"><label>Phone</label><input type="text" name="phone" class="form-control" required></div>
          <div class="mb-3"><label>Position</label><input type="text" name="position" class="form-control" required></div>
          <div class="mb-3"><label>Salary</label><input type="number" step="0.01" name="salary" class="form-control" required></div>
          <div class="mb-3"><label>Hire Date</label><input type="date" name="hire_date" class="form-control" required></div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="add" class="btn btn-success">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- 🔹 Edit Employee Modal -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="actions/employees.php">
      <div class="modal-content">
        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title">Edit Employee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">
          <div class="mb-3"><label>Full Name</label><input type="text" name="full_name" id="edit_name" class="form-control" required></div>
          <div class="mb-3"><label>Email</label><input type="email" name="email" id="edit_email" class="form-control" required></div>
          <div class="mb-3"><label>Phone</label><input type="text" name="phone" id="edit_phone" class="form-control" required></div>
          <div class="mb-3"><label>Position</label><input type="text" name="position" id="edit_position" class="form-control" required></div>
          <div class="mb-3"><label>Salary</label><input type="number" step="0.01" name="salary" id="edit_salary" class="form-control" required></div>
          <div class="mb-3"><label>Hire Date</label><input type="date" name="hire_date" id="edit_hire" class="form-control" required></div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="save" class="btn btn-warning">Update</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- 🔹 Script to load employee data into edit modal -->
<script>
document.querySelectorAll('.edit-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    document.getElementById('edit_id').value = this.dataset.id;
    document.getElementById('edit_name').value = this.dataset.name;
    document.getElementById('edit_email').value = this.dataset.email;
    document.getElementById('edit_phone').value = this.dataset.phone;
    document.getElementById('edit_position').value = this.dataset.position;
    document.getElementById('edit_salary').value = this.dataset.salary;
    document.getElementById('edit_hire').value = this.dataset.hire;
  });
});
</script>

<?php
include 'includes/footer.php';
?>
