<!-- Add Employee Modal -->
<div class="modal fade" id="employeeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="actions/employees.php">
      <div class="modal-content">
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
  // تحميل بيانات الموظف داخل الـ Modal عند الضغط على Edit
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

  // ✅ تفعيل DataTables
  $(document).ready(function () {
    $('#employeeTable').DataTable({
      pageLength: 5, // عدد الصفوف في كل صفحة
      lengthChange: false, // إخفاء خيار "عرض عدد الصفوف"
      order: [[0, 'asc']], // ترتيب حسب الاسم افتراضيًا
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
          <button type="submit" name="add" class="btn btn-success">Add Employee</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>
