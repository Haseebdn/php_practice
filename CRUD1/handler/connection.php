<?php
$config = require 'config.php';

$conn = mysqli_connect(
    $config['hostname'],
    $config['username'],
    $config['password'],
    $config['database'],
    $config['port']
);
if (!$conn) {
    echo "Connection Failed. Error: " . mysqli_connect_error($conn);
    die();
}
