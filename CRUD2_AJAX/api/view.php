<?php
require "./conn.php";

// fetching data to view

$query = "SELECT p.*, cat.c_name As categoryName,
    subcat.c_name As subcategoryName  FROM product AS p INNER JOIN category AS cat ON p.category_id=cat.c_id LEFT JOIN category AS subcat ON p.subcategory_id=subcat.c_id";
$sql = mysqli_query($conn, $query);
$records = mysqli_fetch_all($sql, MYSQLI_ASSOC);

// fetching data to view

// echo "<pre>";
// print_r($records);
// echo "</pre>";

echo json_encode(["status" => 200, "message" => "Data Fetched Successfully", "data" => $records], 200);
