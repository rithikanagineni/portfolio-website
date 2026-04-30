<?php
// Database connection - PORT 3307
$conn = new mysqli("localhost:3307", "root", "", "test_db");

// Check connection
if ($conn->connect_error) {
    header('Content-Type: application/json');
    die(json_encode(['message' => '❌ Connection failed: ' . $conn->connect_error]));
}

$response = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Validate inputs
    if (empty($name) || empty($email) || empty($message)) {
        $response = "❌ Error: All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = "❌ Error: Invalid email address!";
    } else {
        // Using prepared statement for SECURITY
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
        
        if ($stmt === false) {
            $response = "❌ Error: " . $conn->error;
        } else {
            $stmt->bind_param("sss", $name, $email, $message);

            if ($stmt->execute()) {
                $response = "✅ Thank you, " . $name . "! Your message has been received. I'll get back to you soon!";
            } else {
                $response = "❌ Error: " . $stmt->error;
            }
            $stmt->close();
        }
    }
} else {
    $response = "❌ Form not submitted correctly.";
}

$conn->close();

// Return JSON response for AJAX
header('Content-Type: application/json');
echo json_encode(['message' => $response]);
?>
