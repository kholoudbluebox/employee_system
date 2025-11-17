 <!-- 🔹 Add Employee Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="actions/employees.php">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
      
<button id="addEmployeeBtn" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
  ➕ Add Employee
</button>
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
          <button type="submit" name="add" class="btn btn-primary">Save</button>
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
          <button type="submit" name="edit" class="btn btn-warning">Update</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- 🔹 Delete Employee Modal -->
<div class="modal fade" id="deleteEmployeeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="actions/employees.php">
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
          <button type="submit" name="delete" class="btn btn-danger">Yes, Delete</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Add Employee Modal -->
<div class="modal fade" id="employeeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="actions/employees.php">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Add New Employee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="full_name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control">
          </div>
          <div class="mb-3">
            <label>Position</label>
            <input type="text" name="position" class="form-control">
          </div>
          <div class="mb-3">
            <label>Salary</label>
            <input type="number" step="0.01" name="salary" class="form-control">
          </div>
          <div class="mb-3">
            <label>Hire Date</label>
            <input type="date" name="hire_date" class="form-control">
          </div>
        </div>
        <script>
<?php while ($emp = $result->fetch_assoc()): ?>
<tr>
  <td><?= htmlspecialchars($emp['full_name']) ?></td>
  <td><?= htmlspecialchars($emp['email']) ?></td>
  <td><?= htmlspecialchars($emp['phone']) ?></td>
  <td><?= htmlspecialchars($emp['position']) ?></td>
  <td>$<?= number_format($emp['salary'], 2) ?></td>
  <td><?= date('d M Y', strtotime($emp['hire_date'])) ?></td>
  <td>
    <!-- زر يفتح Modal -->
    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $emp['id'] ?>">✏️ Edit</button>
  </td>
</tr>

<!-- Edit Modal لكل موظف -->
<div class="modal fade" id="editModal<?= $emp['id'] ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="actions/employees.php">
      <input type="hidden" name="id" value="<?= $emp['id'] ?>">
      <div class="modal-content">
        <div class="modal-header bg-warning text-dark">
          <h5 class="modal-title">Edit Employee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3"><label>Full Name</label><input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($emp['full_name']) ?>" required></div>
          <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" value="<?= htmlspecialchars($emp['email']) ?>" required></div>
          <div class="mb-3"><label>Phone</label><input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($emp['phone']) ?>" required></div>
          <div class="mb-3"><label>Position</label><input type="text" name="position" class="form-control" value="<?= htmlspecialchars($emp['position']) ?>" required></div>
          <div class="mb-3"><label>Salary</label><input type="number" step="0.01" name="salary" class="form-control" value="<?= $emp['salary'] ?>" required></div>
          <div class="mb-3"><label>Hire Date</label><input type="date" name="hire_date" class="form-control" value="<?= $emp['hire_date'] ?>" required></div>
        </div>
        <div class="modal-footer">
          <button type="submit" name="edit" class="btn btn-warning">Update</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>
<?php endwhile; ?>

  // ✅ تفعيل DataTables
  $(document).ready(function () {
    $('#employeeTable').DataTable({
      pageLength: 5, 
      lengthChange: false, 
      order: [[0, 'asc']], 
      language: {
        search: "_INPUT_",
        searchPlaceholder: "🔍 Search employee...",
        paginate: { previous: "«", next: "»" },
        info: "Showing _START_ to _END_ of _TOTAL_ employees",
        infoEmpty: "No employees to show"
      }
    });
  });
</script>

        <div class="modal-footer">
          <button type="submit" name="add" class="btn btn-primary">Add Employee</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>
