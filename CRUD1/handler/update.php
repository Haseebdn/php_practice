<?php
include "./connection.php";

if (isset($_POST) && !empty($_POST)) {



    $response = [];
    $full_name = $_POST['user_name'] ?? '';
    $email = $_POST['u_email'] ?? '';
    $pnumber = $_POST['p_number'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $id = $_GET['id'];



    if ($full_name == '' || $email == '' || $pnumber == '' || $gender == '') {
        $response = ['msg' => "Please fillout values correctly", "success" => false];
        header("location:../list.php?success=0");
        return;
    }

    $query = "UPDATE `infotable` SET `user_name`='$full_name',`u_email`='$email' ,`p_number`='$pnumber', `gender`='$gender' WHERE `id`='$id' ";

    if (mysqli_query($conn, $query)) {
        $response = ['msg' => "Data Inserted Successfully", "success" => true];
    } else {
        $error = mysqli_error($conn);
        $response = ['msg' => "Data Insertion failed. Error: $error", "success" => false];
    }

    $is_success = $response['success'] ? 1 : 0;
    header("location:../list.php?success=$is_success");
    exit();
}
