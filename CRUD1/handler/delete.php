<?php
include "./connection.php";

if (isset($_GET) && !empty($_GET)) {

    $id = $_GET['id'];

    

    $query = "DELETE FROM `infotable` WHERE `id`='$id'";
    
    if (mysqli_query($conn, $query)) {
        $response = ['msg' => "Data Deleted Successfully", "success" => true];
    } else {
        $error = mysqli_error($conn);
        $response = ['msg' => "Data Deletion failed. Error: $error", "success" => false];
    }
    
    $is_success = $response['success'];
    header("location:../list.php?delete-success=$is_success");
}
