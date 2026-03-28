<?php
include "./connection.php";

if (isset($_POST) && !empty($_POST)) {

    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // header("location:../php_classes/class2.php ");   // cannot be used simultaneously with print or echo
    // header("refresh:3;url=../class2.php");

    //================================
    $response = [];
    $full_name = mysqli_real_escape_string($conn, $_POST['user_name'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['u_email'] ?? '');
    $pnumber = mysqli_real_escape_string($conn, $_POST['p_number'] ?? '');
    $gender = mysqli_real_escape_string($conn, $_POST['gender'] ?? '');
    $teacher_id = mysqli_real_escape_string($conn, $_POST['teacher_id']);
    $created_at = date('Y-m-d h:i');
    //================================

    //================================
    if (isset($_POST['subjects'])) {
        $subjects = mysqli_real_escape_string($conn, implode(',', $_POST['subjects']));
    }
    //================================

    //================================
    $pic = $_FILES['profile_img']['name'];

    $ext = strtolower(pathinfo($pic, PATHINFO_EXTENSION));

    if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
        $response = ['msg' => "Data Insertion failed. Error: Invalid file format", "success" => false];
    }

    $picName = time() . rand(1, 10000) . '.' . $ext;
    move_uploaded_file($_FILES['profile_img']['tmp_name'], '../uploads/profilePictures/' . $picName);
    //================================

    //================================
    $certificates = $_FILES['certificates']['name'];
    $cImgsTmp = $_FILES['certificates']['tmp_name'];
    $cImgsNewN = [];
    $cImgExt = [];
    //
    if (!empty($certificates)) {

        foreach ($certificates as $item) {
            $ext = strtolower(pathinfo($item, PATHINFO_EXTENSION));

            if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
                $response = ['msg' => "Data Insertion failed. Error: Invalid file format", "success" => false];
                header("location:../list.php?success=0");
                return;
            }

            $cImgExt[] = $ext;
        }
    }

    foreach ($cImgsTmp as $key => $tmp) {
        $cImgsNewN[] = time() . rand(1, 10000) . '.' . $cImgExt[$key];
        move_uploaded_file($tmp, '../uploads/certificates/' . $cImgsNewN[$key]);
    }
    $newNameC = '';
    $newNameC = implode(',', $cImgsNewN);

    // echo '<pre>';
    // print_r($newNameC);
    // echo '</pre>';
    // die;
    //================================



    if ($full_name == '' || $email == '' || $pnumber == '' || $gender == '') {
        $response = ['msg' => "Please fillout values correctly", "success" => false];
        header("location:../list.php?success=0");
        return;
    }

    $query = "INSERT INTO `infotable` (`user_name`, `u_email`, `p_number`,`profile_img`, `gender`,`subjects`,`teacher_id`,`certificates`,`created_at`) VALUES ('$full_name', '$email', '$pnumber','$picName', '$gender','$subjects','$teacher_id','$newNameC','$created_at')";

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
