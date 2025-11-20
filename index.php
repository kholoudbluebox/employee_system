<?php include 'includes/header.php'; ?>

<h2>Welcome to Employee System</h2>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold text-primary">Employee List</h2>
    <button class="btn shadow-sm" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
        ➕ Add Employee
    </button>
</div>

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
            <tbody></tbody>
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

<?php include 'includes/modals.php'; ?>
<?php include 'includes/footer.php'; ?>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let table = $('#employeeTable').DataTable({
    searching: false,
    ajax: {
        url: "actions/get_employees.php",
        data: function(d){ d.search = $('#liveSearch').val(); },
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
                  ✏ Edit
                </button>
                <button class="btn btn-sm btn-danger delete-btn"
                        data-id="${id}" data-bs-toggle="modal"
                        data-bs-target="#deleteEmployeeModal">
                  🗑 Delete
                </button>
            `;
        }}
    ]
});

// Live search
$('#liveSearch').on('keyup', function(){ table.ajax.reload(); });

// Update total salary
table.on('xhr', function(){
    let data = table.ajax.json();
    let total = 0;
    data.forEach(emp => total += parseFloat(emp.salary));
    document.getElementById('totalSalary').textContent = "$" + total.toFixed(2);
});

// Fill edit/delete modal data
$(document).on('click', '.edit-btn', function(){
    $('#edit_id').val($(this).data('id'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_email').val($(this).data('email'));
    $('#edit_phone').val($(this).data('phone'));
    $('#edit_position').val($(this).data('position'));
    $('#edit_salary').val($(this).data('salary'));
    $('#edit_hire').val($(this).data('hire'));
});
$(document).on('click', '.delete-btn', function(){
    $('#delete_id').val($(this).data('id'));
});

// ----------- ADD EMPLOYEE -----------
$('#addEmployeeForm').on('submit', function(e){
    e.preventDefault();
    $.ajax({
        url: 'actions/employees.php',
        method: 'POST',
        data: $(this).serialize() + '&add=1',
        dataType: 'json',
        success: function(res){
            if(res.status === 'error'){
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: res.message
                });
            } else {
                $('#addEmployeeModal').modal('hide');
                $('#addEmployeeForm')[0].reset();
                table.ajax.reload(null, false);
                Swal.fire({
                    icon: 'success',
                    title: 'Added!',
                    text: 'Employee added successfully'
                });
            }
        }
    });
});

// ----------- EDIT EMPLOYEE -----------
$('#editEmployeeForm').on('submit', function(e){
    e.preventDefault();
    $.ajax({
        url: 'actions/employees.php',
        method: 'POST',
        data: $(this).serialize() + '&edit=1',
        dataType: 'json',
        success: function(res){
            if(res.status === 'error'){
                Swal.fire({ icon:'error', title:'Error', text: res.message });
            } else {
                $('#editEmployeeModal').modal('hide');
                table.ajax.reload(null,false);
                Swal.fire({ icon:'success', title:'Updated!', text:'Employee updated successfully' });
            }
        }
    });
});

// ----------- DELETE EMPLOYEE -----------
$('#deleteEmployeeForm').on('submit', function(e){
    e.preventDefault();

    $.ajax({
        url: 'actions/employees.php',
        method: 'POST',
        data: $('#deleteEmployeeForm').serialize() + '&delete=1',
        dataType: 'json',
        success: function(res){
            $('#deleteEmployeeModal').modal('hide'); 
            table.ajax.reload(null, false);

            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: 'Employee has been deleted.',
                timer: 2000,
                showConfirmButton: false
            });
        }
    });
});
</script>