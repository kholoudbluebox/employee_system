<?php
require_once '../includes/connect.php';
require_once '../includes/Employee.php';

header('Content-Type: application/json');

$employee = new Employee($conn);

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') throw new Exception("Invalid request method.");

    // Determine action using switch-case
    switch(true){
        case isset($_POST['add']):
            $res = $employee->add($_POST);
            break;
        case isset($_POST['edit']):
            $res = $employee->edit($_POST);
            break;
        case isset($_POST['delete']):
            $id = $_POST['id'] ?? 0;
            $res = $employee->delete($id);
            break;
        default:
            throw new Exception("Invalid action.");
    }

} catch (Exception $e) {
    $res = ['status'=>'error','message'=>$e->getMessage()];
}

echo json_encode($res);
?>
