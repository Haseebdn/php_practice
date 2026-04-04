<?php
require "./conn.php";

if (isset($_POST)) {

    if ($_POST['p_name'] == '' || $_POST['category'] == '' || $_POST['p_description'] == '' || $_POST['p_price'] == '' || $_POST['s_price'] == '' || $_POST['tax'] == '' || $_POST['qty'] == '') {

        echo json_encode(["status" => 403, "message" => "Please fillout all fields"], 403);

    } else {

        $category = mysqli_real_escape_string($conn, $_POST['category']);
        // $subcategory = mysqli_real_escape_string($conn, $_POST['subcategory']);
        $pName = mysqli_real_escape_string($conn, $_POST['p_name']);
        $pQty = mysqli_real_escape_string($conn, $_POST['qty']);
        $pDescription = mysqli_real_escape_string($conn, $_POST['p_description']);
        $pPrice = mysqli_real_escape_string($conn, $_POST['p_price']);
        $sPrice = mysqli_real_escape_string($conn, $_POST['s_price']);
        $pTax = mysqli_real_escape_string($conn, $_POST['tax']);
        $is_active = $_POST['is_active'];
        $pThumbnail = $_FILES['p_thumbnail'];
        $newName = '';

        $subcategory = (isset($_POST['subcategory']) && ($_POST['subcategory'] != "")) ? $_POST['subcategory'] : NULL;

        $subcategoryValue = is_null($subcategory) ? "NULL" : "'$subcategory'";

        if (isset($_FILES['p_thumbnail']) && $_FILES['p_thumbnail']['name'] != '') {

            $picName = $_FILES['p_thumbnail']['name'];
            $ext = strtolower(pathinfo($picName, PATHINFO_EXTENSION));

            if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
                echo json_encode(["status" => 403, "message" => "Invalid File Format"], 403);
                exit();
            }

            $newName = time() . rand(1, 10000) . '.' . $ext;

            move_uploaded_file($_FILES['p_thumbnail']['tmp_name'], "../uploads/thumbnails/" . $newName);
        }


        $query = "INSERT INTO product (category_id,subcategory_id,p_thumbnail,p_name,p_description,qty,p_price,s_price,tax,is_active) VALUES('$category',$subcategoryValue,'$newName','$pName','$pDescription','$pQty','$pPrice','$sPrice','$pTax','$is_active')";
        $run = mysqli_query($conn, $query);

        if ($run) {
            echo json_encode(["status" => 200, "message" => "Data Inserted Successfully"], 200);
        } else {
            echo json_encode(["status" => 500, "message" => "Data Insertion Failed", "error" => mysqli_error($conn, $run)], 200);
        }
    }
}
