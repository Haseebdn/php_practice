<?php
include "./connection.php";

if (isset($_POST) && !empty($_POST)) {



    $response = [];
    $full_name = $_POST['user_name'] ?? '';
    $email = $_POST['u_email'] ?? '';
    $pnumber = $_POST['p_number'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $id = $_GET['id'];
    $subjects = implode(',', $_POST['subjects']);
    $teacher_id = mysqli_real_escape_string($conn, $_POST['teacher_id']);
    $picName = $_FILES['profile_img']['name'];
    $query = "SELECT profile_img FROM infotable WHERE id = $id";
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

        if (file_exists("../uploads/profilepictures/$record[0]")) {
            unlink("../uploads/profilepictures/$record[0]");
        }
    }



    if ($full_name == '' || $email == '' || $pnumber == '' || $gender == '') {
        $response = ['msg' => "Please fillout values correctly", "success" => false];
        header("location:../list.php?success=0");
        return;
    }

    $query = "UPDATE `infotable` SET `user_name`='$full_name',`u_email`='$email' ,`p_number`='$pnumber', `gender`='$gender',`profile_img`='$new_profile_pic', `subjects`='$subjects', `teacher_id`='$teacher_id' WHERE `id`='$id' ";

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
