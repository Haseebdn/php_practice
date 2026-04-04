<?php
require "./conn.php";

$action = $_GET['c'];

if ($action == "fetchCategory") {

    $query = "SELECT * FROM category WHERE parent_id IS NULL";
    $sql = mysqli_query($conn, $query);
    $data = mysqli_fetch_all($sql, MYSQLI_ASSOC);

    echo json_encode(["status" => 200, "message" => "Data fetched successfully", "data" => $data], 200);
} elseif ($action == "fetchSubcat") {

    $category = $_GET['category_id'];

    $query = "SELECT * FROM category WHERE parent_id='$category'";
    $sql = mysqli_query($conn, $query);
    $data = mysqli_fetch_all($sql, MYSQLI_ASSOC);

    echo json_encode(["status" => 200, "message" => "Subcategory Fetched Successfully", "data" => $data], 200);
} elseif ($action == "fetchdata") {
    $product_id = $_GET['product_id'];

    $query = "SELECT * FROM product WHERE p_id =$product_id";
    $sql = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($sql);

    echo json_encode(["status" => 200, "message" => "Data fetched successfully", "data" => $data], 200);
}
