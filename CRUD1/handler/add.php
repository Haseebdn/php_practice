<?php
include "./connection.php";

if (isset($_POST) && !empty($_POST)) {

    // echo "<pre>";
    print_r($_POST);
    // echo "</pre>";
    // header("location:../php_classes/class2.php ");   // cannot be used simultaneously with print or echo
    // header("refresh:3;url=../class2.php");
    
    $response = [];
    
    $full_name = mysqli_real_escape_string($conn, $_POST['user_name'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['u_email'] ?? '');
    $pnumber = mysqli_real_escape_string($conn, $_POST['p_number'] ?? '');
    // $profile_img = mysqli_real_escape_string($conn, $_POST['profile_img']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender'] ?? '');
    $subjects = mysqli_real_escape_string($conn, implode(',', $_POST['subject']));
    $teacher_id = mysqli_real_escape_string($conn, $_POST['teacher_id']);
    $pic = $_FILES['profile_img']['name'];
    $certificates=$_FILES['images']['name'];
    $created_at = date('Y-m-d h:i');

    // print_r($pic);
    // print_r($certificates);
    die;

    if ($full_name == '' || $email == '' || $pnumber == '' || $gender == '') {
        $response = ['msg' => "Please fillout values correctly", "success" => false];
        header("location:../list.php?success=0");
        return;
    }

    $query = "INSERT INTO `infotable` (`user_name`, `u_email`, `p_number`, `gender`,`subject`,`created_at`) VALUES ('$full_name', '$email', '$pnumber', '$gender','$subjects','$created_at')";

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
