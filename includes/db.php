<?php
session_start();
$hostname = "localhost";
$username = "root";
$password = "";
$database = "ecommerce";

try {
    $conn = mysqli_connect($hostname, $username, $password, $database);
} catch (mysqli_sql_exception $e) {
    echo "Database connection failed:  " . $e->getMessage();
}
