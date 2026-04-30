<?php
$conn = new mysqli("localhost:3307", "root", "", "test_db");

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: admin.php");
    exit();
}

$id = intval($_POST['id']);
$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$message = htmlspecialchars($_POST['message']);

// Validate
if (empty($name) || empty($email) || empty($message)) {
    die("❌ All fields are required!");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("❌ Invalid email address!");
}

// Using prepared statement for SECURITY
$stmt = $conn->prepare("UPDATE contacts SET name=?, email=?, message=? WHERE id=?");

if ($stmt === false) {
    die("❌ Error: " . $conn->error);
}

$stmt->bind_param("sssi", $name, $email, $message, $id);

if ($stmt->execute()) {
    // Redirect to admin page
    header("Location: admin.php");
    exit();
} else {
    die("❌ Error: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>