<?php
require "./conn.php";


$id = $_POST['ID'];

if (isset($_POST) && !empty($id)) {
    // fetching product thumbnail 

    $query = "SELECT p_thumbnail FROM product Where p_id=$id";
    $sql = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($sql);

    // fetching product thumbnail    

    // deleting product thumbnail  & row  

    if (!empty($data['p_thumbnail']) && file_exists("../uploads/thumbnails/" . $data['p_thumbnail'])) {
        unlink("../uploads/thumbnails/" . $data['p_thumbnail']);
    }

    $query = "DELETE FROM product WHERE p_id=$id";
    
    // deleting product thumbnail & row   


    $run = mysqli_query($conn, $query);
    if ($run) {
        echo json_encode(["status" => 200, "message" => "Data Deleted Successfully"], 200);
    } else {
        echo json_encode(["status" => 500, "message" => "Data Deletion Failed", "error" => mysqli_error($conn, $run)], 200);
    }
}
