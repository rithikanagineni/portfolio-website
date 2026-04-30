<?php
$conn = new mysqli("localhost:3307", "root", "", "test_db");

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    header("Location: admin.php");
    exit();
}

$id = intval($_GET['id']); // Convert to integer for safety

// Using prepared statement
$stmt = $conn->prepare("DELETE FROM contacts WHERE id=?");

if ($stmt === false) {
    die("❌ Error: " . $conn->error);
}

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: admin.php");
    exit();
} else {
    die("❌ Error: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>