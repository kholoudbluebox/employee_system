<?php
require_once 'connect.php';

/**
 * Class Employee
 * Handles CRUD operations for employees
 */
class Employee {
    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    /**
     * Add a new employee
     */
    public function add($data){
        try {
            $this->validate($data);

            // Duplicate email check
            $stmt = $this->conn->prepare("SELECT id FROM employees WHERE email=?");
            $stmt->bind_param("s", $data['email']);
            $stmt->execute();
            $stmt->store_result();
            if($stmt->num_rows > 0) throw new Exception("Email already exists.");
            $stmt->close();

            // Duplicate phone check
            $stmt = $this->conn->prepare("SELECT id FROM employees WHERE phone=?");
            $stmt->bind_param("s", $data['phone']);
            $stmt->execute();
            $stmt->store_result();
            if($stmt->num_rows > 0) throw new Exception("Phone number already exists.");
            $stmt->close();

            // Insert
            $stmt = $this->conn->prepare("INSERT INTO employees (full_name,email,phone,position,salary,hire_date) VALUES (?,?,?,?,?,?)");
            $stmt->bind_param("ssssds", $data['full_name'], $data['email'], $data['phone'], $data['position'], $data['salary'], $data['hire_date']);
            if(!$stmt->execute()) throw new Exception("Failed to add employee.");
            return ['status'=>'success','message'=>'Employee added successfully'];

        } catch(Exception $e){
            return ['status'=>'error','message'=>$e->getMessage()];
        }
    }

    /**
     * Edit an existing employee
     */
   public function edit($data){
    try {
        $this->validate($data, true);

        // تحقق من تكرار الإيميل
        $stmt = $this->conn->prepare("SELECT id FROM employees WHERE email=? AND id<>?");
        $stmt->bind_param("si", $data['email'], $data['id']);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0) throw new Exception("Email already exists.");
        $stmt->close();

        // تحقق من تكرار الهاتف
        $stmt = $this->conn->prepare("SELECT id FROM employees WHERE phone=? AND id<>?");
        $stmt->bind_param("si", $data['phone'], $data['id']);
        $stmt->execute();
        $stmt->store_result();
        if($stmt->num_rows > 0) throw new Exception("Phone number already exists.");
        $stmt->close();

        // تحديث البيانات بما فيها role
        $stmt = $this->conn->prepare("
            UPDATE employees 
            SET full_name=?, email=?, phone=?, position=?, salary=?, hire_date=?, role=? 
            WHERE id=?
        ");
        $stmt->bind_param(
            "ssssdssi", 
            $data['full_name'], $data['email'], $data['phone'], 
            $data['position'], $data['salary'], $data['hire_date'], 
            $data['role'], $data['id']
        );
        if(!$stmt->execute()) throw new Exception("Failed to update employee.");
        return ['status'=>'success','message'=>'Employee updated successfully'];

    } catch(Exception $e){
        return ['status'=>'error','message'=>$e->getMessage()];
    }
}

    /**
     * Delete an employee
     */
    public function delete($id){
        try {
            $stmt = $this->conn->prepare("DELETE FROM employees WHERE id=?");
            $stmt->bind_param("i", $id);
            if(!$stmt->execute()) throw new Exception("Failed to delete employee.");
            return ['status'=>'success','message'=>'Employee deleted successfully'];
        } catch(Exception $e){
            return ['status'=>'error','message'=>$e->getMessage()];
        }
    }

    /**
     * Validate employee data
     */
    private function validate($data, $isEdit=false){
        if($isEdit && empty($data['id'])) throw new Exception("Invalid employee ID.");
        if(empty($data['full_name']) || empty($data['email']) || empty($data['phone']) || empty($data['position']) || empty($data['salary']) || empty($data['hire_date'])){
            throw new Exception("All fields are required.");
        }
        if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) throw new Exception("Invalid email format.");
        if(!is_numeric($data['salary'])) throw new Exception("Salary must be a number.");
    }
}
?>
