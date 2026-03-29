<?php
include "./connection.php";

if (isset($_GET) && !empty($_GET)) {

    $id = $_GET['id'];

    $query = "SELECT profile_img,certificates FROM infotable WHERE id = $id";
    $sql = mysqli_query($conn, $query);
    $record = mysqli_fetch_row($sql);

    // =================================== deleting profile img
    if (file_exists("../uploads/profilePictures/$record[0]")) {
        unlink("../uploads/profilePictures/$record[0]");
    }

    // =================================== deleting certificates
    $oldCertificates = $record[1];
    $oldCertificatesArr = [];
    if (!empty($oldCertificates)) {
        $oldCertificatesArr = explode(',', $oldCertificates);
    }

    if (!empty($oldCertificatesArr)) {
        foreach ($oldCertificatesArr as $del) {
            if (file_exists("../uploads/certificates/" . $del)) {
                unlink("../uploads/certificates/" . $del);
            }
        }
    }

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
