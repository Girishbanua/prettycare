<?php
session_start();
$hostname = "localhost";
$username = "root";
$password = "";
$database = "ecommerce";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Database connection failed.");
}

mysqli_set_charset($conn, "utf8mb4");
