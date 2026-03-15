<?php
$hostname = "localhost";
$username = "root";
$password = "Haseeb430@";
$database = "formsub";
$port = 3306;

$conn = mysqli_connect($hostname, $username, $password, $database, $port);
if (!$conn) {
    echo "Connection Failed. Error: " . mysqli_connect_error($conn);
    die();
}
