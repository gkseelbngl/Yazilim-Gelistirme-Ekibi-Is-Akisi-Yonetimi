<?php
include('../includes/db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: projects.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
