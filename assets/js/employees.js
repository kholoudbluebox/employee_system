$(document).ready(function(){

    // Initialize DataTable
    let table = $('#employeeTable').DataTable({
        searching: false,
        ajax: {
            url: "actions/get_employees.php",
            data: function(d){ d.search = $('#liveSearch').val(); },
            dataSrc: "",
            error: function(xhr, status, error){ // Added AJAX error callback
                Swal.fire({ icon: 'error', title: 'AJAX Error', text: error });
            }
        },
        columns: [
            { data: "full_name" },
            { data: "email" },
            { data: "phone" },
            { data: "position" },
            { data: "salary", render: data => "$" + parseFloat(data).toFixed(2) },
            { data: "hire_date" },
            { data: "id", render: function(id, type, row){
                return `
                    <button class="btn btn-sm btn-warning edit-btn"
                            data-id="${id}" data-name="${row.full_name}"
                            data-email="${row.email}" data-phone="${row.phone}"
                            data-position="${row.position}" data-salary="${row.salary}"
                            data-hire="${row.hire_date}" data-bs-toggle="modal"
                            data-bs-target="#editEmployeeModal">✏ Edit</button>
                    <button class="btn btn-sm btn-danger delete-btn"
                            data-id="${id}" data-bs-toggle="modal"
                            data-bs-target="#deleteEmployeeModal">🗑 Delete</button>
                `;
            }}
        ]
    });

    // Live search
    $('#liveSearch').on('keyup', function(){ table.ajax.reload(); });

    // Update total salary
    table.on('xhr', function(){
        let data = table.ajax.json() || [];
        let total = 0;
        data.forEach(emp => total += parseFloat(emp.salary));
        $('#totalSalary').text("$" + total.toFixed(2));
    });

    // Fill edit/delete modal data
    $(document).on('click', '.edit-btn', function(){
        let btn = $(this);
        $('#edit_id').val(btn.data('id'));
        $('#edit_name').val(btn.data('name'));
        $('#edit_email').val(btn.data('email'));
        $('#edit_phone').val(btn.data('phone'));
        $('#edit_position').val(btn.data('position'));
        $('#edit_salary').val(btn.data('salary'));
        $('#edit_hire').val(btn.data('hire'));
    });
    
    $(document).on('click', '.delete-btn', function(){
        $('#delete_id').val($(this).data('id'));
    });

    // Reset forms on modal hide
    $('#addEmployeeModal').on('hidden.bs.modal', function(){
        $(this).find('form')[0].reset();
    });

    // Prevent multiple clicks
    function disableBtn(btn){
        btn.prop('disabled', true);
        setTimeout(()=>{ btn.prop('disabled', false); }, 1000);
    }

    // ---------- ADD EMPLOYEE -----------
    $('#addEmployeeForm').on('submit', function(e){
        e.preventDefault();
        let btn = $(this).find('button[type="submit"]');
        disableBtn(btn);

        // Client-side validation
        if(!this.checkValidity()){
            Swal.fire({ icon:'error', title:'Invalid Input', text:'Please fill all fields correctly.' });
            return;
        }

        let spinner = $('<span class="spinner-border spinner-border-sm ms-2"></span>');
        btn.append(spinner);

        $.ajax({
            url: 'actions/employees.php',
            method: 'POST',
            data: $(this).serialize() + '&add=1',
            dataType: 'json',
            success: function(res){
                if(res.status === 'error'){
                    Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                } else {
                    table.ajax.reload(null,false);
                    Swal.fire({ icon:'success', title:'Added!', text: res.message, timer:1500, showConfirmButton:false });
                    $('#addEmployeeModal').modal('hide');
                }
            },
            error: function(xhr, status, error){
                Swal.fire({ icon:'error', title:'AJAX Error', text: error });
            },
            complete: function(){ spinner.remove(); btn.prop('disabled', false); }
        });
    });

    // ---------- EDIT EMPLOYEE -----------
    $('#editEmployeeForm').on('submit', function(e){
        e.preventDefault();
        let btn = $(this).find('button[type="submit"]');
        disableBtn(btn);

        if(!this.checkValidity()){
            Swal.fire({ icon:'error', title:'Invalid Input', text:'Please fill all fields correctly.' });
            return;
        }

        let spinner = $('<span class="spinner-border spinner-border-sm ms-2"></span>');
        btn.append(spinner);

        $.ajax({
            url: 'actions/employees.php',
            method: 'POST',
            data: $(this).serialize() + '&edit=1',
            dataType: 'json',
            success: function(res){
                if(res.status === 'error'){
                    Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                } else {
                    table.ajax.reload(null,false);
                    Swal.fire({ icon:'success', title:'Updated!', text: res.message, timer:1500, showConfirmButton:false });
                    $('#editEmployeeModal').modal('hide');
                }
            },
            error: function(xhr,status,error){
                Swal.fire({ icon:'error', title:'AJAX Error', text:error });
            },
            complete: function(){ spinner.remove(); btn.prop('disabled', false); }
        });
    });

    // ---------- DELETE EMPLOYEE -----------
    $('#deleteEmployeeForm').on('submit', function(e){
        e.preventDefault();
        let btn = $('#deleteEmployeeForm button[type="submit"]');
        disableBtn(btn);
        let spinner = $('<span class="spinner-border spinner-border-sm ms-2"></span>');
        btn.append(spinner);

        $.ajax({
            url: 'actions/employees.php',
            method: 'POST',
            data: $(this).serialize() + '&delete=1',
            dataType: 'json',
            success: function(res){
                table.ajax.reload(null,false);
                Swal.fire({ icon:'success', title:'Deleted!', text: res.message, timer:1500, showConfirmButton:false });
                $('#deleteEmployeeModal').modal('hide');
            },
            error: function(xhr,status,error){
                Swal.fire({ icon:'error', title:'AJAX Error', text:error });
            },
            complete: function(){ spinner.remove(); btn.prop('disabled', false); }
        });
    });

    // Fix stuck backdrop issue
    $(document).on('hidden.bs.modal', function () {
        $('.modal-backdrop').remove(); 
        $('body').removeClass('modal-open'); 
        $('body').css('overflow', 'auto');
    });

});
