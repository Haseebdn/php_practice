<?php
include "./connection.php";

if (isset($_POST) && !empty($_POST)) {

    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // header("location:../php_classes/class2.php ");   // cannot be used simultaneously with print or echo
    // header("refresh:3;url=../class2.php");

    $response = [];
    $full_name = $_POST['user_name'] ?? '';
    $email = $_POST['u_email'] ?? '';
    $pnumber = $_POST['p_number'] ?? '';
    $gender = $_POST['gender'] ?? '';

    $created_at = date('Y-m-d h:i');

    if ($full_name == '' || $email == '' || $pnumber == '' || $gender == '') {
        $response = ['msg' => "Please fillout values correctly", "success" => false];
        header("location:../class2.php?success=0");
        return;
    }

    $query = "INSERT INTO `infotable` (`user_name`, `u_email`, `p_number`, `gender`,`created_at`) VALUES ('$full_name', '$email', '$pnumber', '$gender','$created_at')";

    if (mysqli_query($conn, $query)) {
        $response = ['msg' => "Data Inserted Successfully", "success" => true];
    } else {
        $error = mysqli_error($conn);
        $response = ['msg' => "Data Insertion failed. Error: $error", "success" => false];
    }

    // $response = json_encode($response);
    $is_success = $response['success'] ? 1 : 0;
header("location:../class2.php?success=$is_success");
exit();
}
