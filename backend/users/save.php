<?php 
    session_start();
    include '../function.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $conn = new db; 
   
        $prefix = $_POST['prefix'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $phone = $_POST['phone'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $fullname = $prefix.$firstname.' '.$lastname;

        // hash password
        $hash = md5($password);

        // check already exists
        $result = $conn->select_count_where('users', ['username'], [$username]);
        if($result == 1) {
            http_response_code(400);
            echo 'มีชื่อผู้ใช้นี้อยู่ในระบบแล้ว';
            return;
        } 
        
        // create students
        $result = $conn->insert('users', ['prefix', 'firstname', 'lastname', 'fullname', 'phone', 'username', 'password', 'role'], 
        [$prefix, $firstname, $lastname, $fullname, $phone == ''? null: $phone, $username, $hash, $role]);
        if($result == false) {
            http_response_code(500);
            echo 'Server Error';
            return;
        }         

        http_response_code(201);
        echo 'เพิ่มข้อมูลสมาชิกสำเร็จ';
    }else {
        http_response_code(405);
        echo json_encode('Method not allowed');
    }
?>