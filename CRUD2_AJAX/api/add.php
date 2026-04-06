<?php
require "./conn.php";
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";


// ======================= updation

if ($_POST['editIndex'] && !empty($_POST['editIndex'])) {

    // validation
    if (isset($_POST)) {

        if ($_POST['p_name'] == '' || $_POST['category'] == '' || $_POST['p_description'] == '' || $_POST['p_price'] == '' || $_POST['s_price'] == '' || $_POST['tax'] == '' || $_POST['qty'] == '') {

            echo json_encode(["status" => 403, "message" => "Please fillout all fields"], 403);
        }
        // validation
        else {
            // data storing in variables

            $editIndex = intval($_POST['editIndex']);
            $category = mysqli_real_escape_string($conn, $_POST['category']);
            $pName = mysqli_real_escape_string($conn, $_POST['p_name']);
            $pQty = mysqli_real_escape_string($conn, $_POST['qty']);
            $pDescription = mysqli_real_escape_string($conn, $_POST['p_description']);
            $pPrice = mysqli_real_escape_string($conn, $_POST['p_price']);
            $sPrice = mysqli_real_escape_string($conn, $_POST['s_price']);
            $pTax = mysqli_real_escape_string($conn, $_POST['tax']);
            $is_active = $_POST['is_active'];

            // data storing in variables

            // subcategory

            $subcategory = (isset($_POST['subcategory']) && ($_POST['subcategory'] != "")) ? $_POST['subcategory'] : NULL;

            $subcategoryValue = is_null($subcategory) ? "NULL" : "'$subcategory'";

            // subcategory

            // Product thumbnail

            $pThumbnail = $_FILES['p_thumbnail'];
            $query = "SELECT p_thumbnail  FROM product WHERE p_id = $editIndex ";
            $sql = mysqli_query($conn, $query);
            $record = mysqli_fetch_assoc($sql);
            $newName = '';

            if (isset($_FILES['p_thumbnail']) && $_FILES['p_thumbnail']['name'] != '') {

                $picName = $_FILES['p_thumbnail']['name'];
                $ext = strtolower(pathinfo($picName, PATHINFO_EXTENSION));

                if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
                    echo json_encode(["status" => 403, "message" => "Invalid File Format"], 403);
                    exit();
                }

                $newName = time() . rand(1, 10000) . '.' . $ext;

                move_uploaded_file($_FILES['p_thumbnail']['tmp_name'], "../uploads/thumbnails/" . $newName);
                if (!empty($record['p_thumbnail']) && file_exists("../uploads/thumbnails/" . $record['p_thumbnail'])) {
                    unlink("../uploads/thumbnails/" . $record['p_thumbnail']);
                }
            }

            if ($newName == '') {
                $newName = $record['p_thumbnail'];
            }

            // Product thumbnail

            // query & response

            $query = "UPDATE product SET `category_id`='$category' , `subcategory_id`=$subcategoryValue , `p_thumbnail`='$newName' , `p_name`='$pName' , `p_description`='$pDescription' , `qty`='$pQty' , `p_price`='$pPrice' , `s_price`='$sPrice' , `tax`='$pTax' , `is_active`='$is_active'  WHERE p_id = $editIndex";

            $run = mysqli_query($conn, $query);
            if ($run) {
                echo json_encode(["status" => 200, "message" => "Data Inserted Successfully"], 200);
            } else {
                echo json_encode(["status" => 500, "message" => "Data Insertion Failed", "error" => mysqli_error($conn, $run)], 200);
            }

            // query & response
        }
    }
}
// ======================= updation
// ======================= insertion
else if (isset($_POST)) {
    // validation

    if ($_POST['p_name'] == '' || $_POST['category'] == '' || $_POST['p_description'] == '' || $_POST['p_price'] == '' || $_POST['s_price'] == '' || $_POST['tax'] == '' || $_POST['qty'] == '') {

        echo json_encode(["status" => 403, "message" => "Please fillout all fields"], 403);
    }
    // validation
    else {
        // data storing in variables

        $category = mysqli_real_escape_string($conn, $_POST['category']);
        $pName = mysqli_real_escape_string($conn, $_POST['p_name']);
        $pQty = mysqli_real_escape_string($conn, $_POST['qty']);
        $pDescription = mysqli_real_escape_string($conn, $_POST['p_description']);
        $pPrice = mysqli_real_escape_string($conn, $_POST['p_price']);
        $sPrice = mysqli_real_escape_string($conn, $_POST['s_price']);
        $pTax = mysqli_real_escape_string($conn, $_POST['tax']);
        $is_active = $_POST['is_active'];

        // data storing in variables

        // subcategory

        $subcategory = (isset($_POST['subcategory']) && ($_POST['subcategory'] != "")) ? $_POST['subcategory'] : NULL;

        $subcategoryValue = is_null($subcategory) ? "NULL" : "'$subcategory'";

        // subcategory

        // product thumbnail

        $pThumbnail = $_FILES['p_thumbnail'];
        $newName = '';

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

        // product thumbnail

        // query & response

        $query = "INSERT INTO product (category_id,subcategory_id,p_thumbnail,p_name,p_description,qty,p_price,s_price,tax,is_active) VALUES('$category',$subcategoryValue,'$newName','$pName','$pDescription','$pQty','$pPrice','$sPrice','$pTax','$is_active')";

        $run = mysqli_query($conn, $query);
        if ($run) {
            echo json_encode(["status" => 200, "message" => "Data Inserted Successfully"], 200);
        } else {
            echo json_encode(["status" => 500, "message" => "Data Insertion Failed", "error" => mysqli_error($conn, $run)], 200);
        }
        // query & response
    }
}
// ======================= insertion
