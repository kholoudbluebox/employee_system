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

<!-- jQuery & Bootstrap & DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Custom JS -->
<script src="assets/js/employees.js"></script>