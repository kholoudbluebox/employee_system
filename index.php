<?php include 'includes/header.php';'includes/connect.php';echo "Connected successfully!"; ?>

<h2>Welcome to Employee System</h2>

<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#employeeModal">Add Employee</button>

<div class="modal fade" id="employeeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="actions/employees.php">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Employee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="emp_id">
          <div class="mb-3"><label>Full Name</label><input type="text" name="full_name" class="form-control" required></div>
          <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
          <div class="mb-3"><label>Phone</label><input type="text" name="phone" class="form-control"></div>
          <div class="mb-3"><label>Position</label><input type="text" name="position" class="form-control"></div>
          <div class="mb-3"><label>Salary</label><input type="number" step="0.01" name="salary" class="form-control"></div>
          <div class="mb-3"><label>Hire Date</label><input type="date" name="hire_date" class="form-control"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="save" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
