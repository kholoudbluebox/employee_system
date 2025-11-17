<?php include 'includes/header.php'; ?>

<h2>Welcome to Employee System</h2>
<div class="container mt-4">
 

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold text-primary">Employee List</h2>
    <button class="btn btn- shadow-sm" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
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
      <input type="text" id="liveSearch" class="form-control mb-3" placeholder="Search employees...">

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
<script>
let table = $('#employeeTable').DataTable({
      searching: false, // ✅ تعطيل البحث الافتراضي

    ajax: {
        url: "actions/get_employees.php",
        data: function(d){
            d.search = $('#liveSearch').val(); // تمرير البحث
        },
        dataSrc: ""
    },
    columns: [
        { data: "full_name" },
        { data: "email" },
        { data: "phone" },
        { data: "position" },
        { data: "salary", render: function(data){ return "$" + parseFloat(data).toFixed(2); } },
        { data: "hire_date" },
        { data: "id", render: function(id, type, row){
            return `
                <button class="btn btn-sm btn-warning edit-btn"
                        data-id="${id}" data-name="${row.full_name}"
                        data-email="${row.email}" data-phone="${row.phone}"
                        data-position="${row.position}" data-salary="${row.salary}"
                        data-hire="${row.hire_date}" data-bs-toggle="modal"
                        data-bs-target="#editEmployeeModal">
                  ✏️ Edit
                </button>
                <button class="btn btn-sm btn-danger delete-btn"
                        data-id="${id}" data-bs-toggle="modal"
                        data-bs-target="#deleteEmployeeModal">
                  🗑️ Delete
                </button>
            `;
        }}
    ]
});

// 🔹 Live search
$('#liveSearch').on('keyup', function(){
    table.ajax.reload();
});

// تحديث Total Salary بعد تحميل البيانات
table.on('xhr', function(){
    let data = table.ajax.json();
    let total = 0;
    data.forEach(emp => total += parseFloat(emp.salary));
    document.getElementById('totalSalary').textContent = "$" + total.toFixed(2);
});

// تحميل بيانات Edit / Delete للمودالات
document.addEventListener('click', function(e){
    if(e.target.classList.contains('edit-btn')){
        document.getElementById('edit_id').value = e.target.dataset.id;
        document.getElementById('edit_name').value = e.target.dataset.name;
        document.getElementById('edit_email').value = e.target.dataset.email;
        document.getElementById('edit_phone').value = e.target.dataset.phone;
        document.getElementById('edit_position').value = e.target.dataset.position;
        document.getElementById('edit_salary').value = e.target.dataset.salary;
        document.getElementById('edit_hire').value = e.target.dataset.hire;
    }
    if(e.target.classList.contains('delete-btn')){
        document.getElementById('delete_id').value = e.target.dataset.id;
    }
});
</script>


  <!--  total salary -->
  <tfoot>
    <tr>
      <th colspan="4" class="text-end">Total Salary:</th>
      <th id="totalSalary">$0.00</th>
      <th colspan="2"></th>
    </tr>
  </tfoot>
</table>

    </div>
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


<script>
  document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      document.getElementById('delete_id').value = this.dataset.id;
    });
  });
</script>


<?php include 'includes/footer.php'; ?>
