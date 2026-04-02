<?php
require "./conn.php";

$action = $_GET['c'];

if ($action == "fetchCategory") {

    $query = "SELECT * FROM category WHERE parent_id IS NULL";
    $sql = mysqli_query($conn, $query);
    $data = mysqli_fetch_all($sql, MYSQLI_ASSOC);

    echo json_encode(["status" => 200, "msg" => "Data fetched successfully", "data" => $data], 200);
} elseif ($action == "fetchSubcat") {

    $category = $_GET['category_id'];

    $query = "SELECT * FROM category WHERE parent_id='$category'";
    $sql = mysqli_query($conn, $query);
    $data = mysqli_fetch_all($sql, MYSQLI_ASSOC);

    echo json_encode(["status" => 200, "msg" => "Subcategory Fetched Successfully", "data" => $data], 200);
}
