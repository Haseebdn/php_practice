<?php
include "./connection.php";

if (isset($_POST) && !empty($_POST)) {
    // ===========================================
    $response = [];
    $full_name = $_POST['user_name'] ?? '';
    $email = $_POST['u_email'] ?? '';
    $pnumber = $_POST['p_number'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $full_name = mysqli_real_escape_string($conn, $full_name);
    $email = mysqli_real_escape_string($conn, $email);
    $pnumber = mysqli_real_escape_string($conn, $pnumber);
    $gender = mysqli_real_escape_string($conn, $gender);
    $id = intval($_GET['id']);
    $teacher_id = mysqli_real_escape_string($conn, $_POST['teacher_id']);
    // ===========================================

    // ===========================================

    $subjects = '';
    if (isset($_POST['subjects'])) {
        $subjects = mysqli_real_escape_string($conn, implode(',', $_POST['subjects']));
    }
    // ===========================================

    // ===========================================


    $picName = $_FILES['profile_img']['name'];

    $query = "SELECT profile_img,certificates FROM infotable WHERE id = $id";
    $sql = mysqli_query($conn, $query);
    $record = mysqli_fetch_row($sql);
    $new_profile_pic = $record[0];


    if ($picName) {

        $ext = strtolower(pathinfo($picName, PATHINFO_EXTENSION));

        if (!in_array($ext, ['jpg', 'png', 'jpeg'])) {
            $response = ['msg' => "Data Insertion failed. Error: invalid file format", "success" => false];
        }

        $new_profile_pic = time() . rand(1, 100000) . '.' . $ext;

        move_uploaded_file($_FILES['profile_img']['tmp_name'], '../uploads/profilePictures/' . $new_profile_pic);

        if (file_exists("../uploads/profilePictures/$record[0]")) {
            unlink("../uploads/profilePictures/$record[0]");
        }
    }
    // ===========================================

    // ===========================================
    $newCertificates = $_FILES['certificates']['name'];
    $nCertificatesTemp = $_FILES['certificates']['tmp_name'];
    $oldCertificates = $record[1];
    $oldCertificatesArr = [];
    if (!empty($oldCertificates)) {
        $oldCertificatesArr = explode(',', $oldCertificates);
    }

    $imgExt = [];
    $newNames = [];

    if (!empty($newCertificates) && !empty($newCertificates[0])) {
        foreach ($newCertificates as $cert) {
            $ext = strtolower(pathinfo($cert, PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
                $response = ['msg' => "Invalid file format", "success" => false];
                header("location:../list.php?success=0");
                exit();
            }
            $imgExt[] = $ext;
        }

        foreach ($nCertificatesTemp as $key => $tmp) {
            $newNames[] = time() . rand(1, 100000) . '.' . $imgExt[$key];
            move_uploaded_file($tmp, '../uploads/certificates/' . $newNames[$key]);
        }


        if (!empty($oldCertificatesArr)) {
            foreach ($oldCertificatesArr as $del) {
                if (file_exists("../uploads/certificates/$del")) {
                    unlink("../uploads/certificates/$del");
                }
            }
        }

        $newNamesStr = '';
        $newNamesStr = $oldCertificates;
        if (!empty($newNames)) {
            $newNamesStr = implode(',', $newNames);
        }
    }
    // ===========================================


    // echo '<pre>';
    // print_r($imgExt);
    // echo '</pre>';
    // die;


    if ($full_name == '' || $email == '' || $pnumber == '' || $gender == '') {
        $response = ['msg' => "Please fillout values correctly", "success" => false];
        header("location:../list.php?success=0");
        return;
    }

    $query = "UPDATE `infotable` SET `user_name`='$full_name',`u_email`='$email' ,`p_number`='$pnumber', `gender`='$gender',`profile_img`='$new_profile_pic', `subjects`='$subjects', `teacher_id`='$teacher_id',`certificates`='$newNamesStr' WHERE `id`='$id' ";

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
