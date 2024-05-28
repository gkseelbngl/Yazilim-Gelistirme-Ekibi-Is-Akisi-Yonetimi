<?php
$servername = "localhost";
$username = "goks_goksel";
$password = "k0-jig*J^EEMLzd5";
$dbname = "goks_goks";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
