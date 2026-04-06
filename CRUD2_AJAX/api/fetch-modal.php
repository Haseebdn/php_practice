<?php
require "./conn.php";

$action = $_GET['c'];

if ($action == "fetchCategory") {
    // for fetching categories

    $query = "SELECT * FROM category WHERE parent_id IS NULL";
    $sql = mysqli_query($conn, $query);
    $data = mysqli_fetch_all($sql, MYSQLI_ASSOC);

    // for fetching categories

    // response
    echo json_encode(["status" => 200, "message" => "Data fetched successfully", "data" => $data], 200);
    // response
} elseif ($action == "fetchSubcat") {
    // for fetching subcategories

    $category = $_GET['category_id'];

    $query = "SELECT * FROM category WHERE parent_id='$category'";
    $sql = mysqli_query($conn, $query);
    $data = mysqli_fetch_all($sql, MYSQLI_ASSOC);
    // for fetching categories

    // response
    echo json_encode(["status" => 200, "message" => "Subcategory Fetched Successfully", "data" => $data], 200);
    // response
} elseif ($action == "fetchdata") {
    // for fetching product id for edit

    $product_id = $_GET['product_id'];
    $query = "SELECT * FROM product WHERE p_id =$product_id";
    $sql = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($sql);

    // for fetching product id for edit

    // response
    echo json_encode(["status" => 200, "message" => "Data fetched successfully", "data" => $data], 200);
    // response
}
