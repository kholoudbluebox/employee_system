<?php include 'connect.php'; ?>
<?php $roles = $conn->query("SELECT * FROM roles ORDER BY role_name ASC"); ?>

<!-- Add Employee Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="addEmployeeForm">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Add New Employee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Full Name</label>
              <input type="text" name="full_name" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Phone</label>
              <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Position</label>
              <input type="text" name="position" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Salary</label>
              <input type="number" step="0.01" name="salary" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Hire Date</label>
              <input type="date" name="hire_date" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Role</label>
              <select name="role" class="form-select" required>
                <option value="" disabled selected>Select role</option>
                <?php while($r = $roles->fetch_assoc()): ?>
                  <option value="<?= $r['role_name'] ?>"><?= ucfirst($r['role_name']) ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Confirm Password</label>
              <input type="password" name="confirm_password" class="form-control" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Edit Employee Modal -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="editEmployeeForm">
      <div class="modal-content">
        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title">Edit Employee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Full Name</label>
              <input type="text" name="full_name" id="edit_name" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Email</label>
              <input type="email" name="email" id="edit_email" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Phone</label>
              <input type="text" name="phone" id="edit_phone" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Position</label>
              <input type="text" name="position" id="edit_position" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Salary</label>
              <input type="number" step="0.01" name="salary" id="edit_salary" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Hire Date</label>
              <input type="date" name="hire_date" id="edit_hire" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Role</label>
<select name="role" id="edit_role" class="form-select" required>
    <option value="" disabled>Select role</option>
    <?php
    $roles = $conn->query("SELECT * FROM roles ORDER BY role_name ASC");
    while($r = $roles->fetch_assoc()):
    ?>
      <option value="<?= $r['role_name'] ?>"><?= ucfirst($r['role_name']) ?></option>
    <?php endwhile; ?>
</select>

            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Password </label>
              <input type="password" name="password" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Confirm Password</label>
              <input type="password" name="confirm_password" class="form-control">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-warning">Update</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Delete Employee Modal -->
<div class="modal fade" id="deleteEmployeeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="deleteEmployeeForm">
      <input type="hidden" name="id" id="delete_id">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Delete Employee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this employee?</p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Yes, Delete</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>
