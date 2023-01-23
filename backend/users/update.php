<?php 
    session_start();
    include '../function.php';
    $conn = new db; 
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $prefix = $_POST['prefix'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $fullname = $prefix.$firstname.' '.$lastname;
        $hash = md5($password);
        if($password == '' && $password == null) {
            $result = $conn->update('users', ['prefix', 'firstname', 'lastname', 'fullname', 'phone', 'role'], 
                                        [$prefix, $firstname, $lastname, $fullname, $phone == ''? null: $phone, $role, $id]);
        }else{
            $result = $conn->update('users', ['prefix', 'firstname', 'lastname', 'fullname', 'phone', 'password', 'role'], 
                                        [$prefix, $firstname, $lastname, $fullname, $phone == ''? null: $phone, $hash, $role, $id]);
        }
        if($result == false) {
            http_response_code(500);
            echo 'Server Error';
            return;
        }
        http_response_code(201);
        echo 'อัพเดทข้อมูลสมาชิกสำเร็จ';
    }else {
        http_response_code(500);
        echo 'Server Error';
    }
