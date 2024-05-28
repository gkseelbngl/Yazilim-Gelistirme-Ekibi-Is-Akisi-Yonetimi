<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$id = $_GET['id'];

$sql = "DELETE FROM tasks WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Görev başarıyla silindi.";
} else {
    echo "Error: " . $conn->error;
}
