<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set response content type to JSON
header('Content-Type: application/json');

// Database configuration
$servername = "localhost";
$username = "root"; // Default username for XAMPP
$password = ""; // Default password for XAMPP
$dbname = "feedback_form";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

// Get form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$message = $_POST['message'] ?? '';

// Validate inputs
if (empty($name) || empty($email) || empty($message)) {
    echo json_encode(["status" => "error", "message" => "All fields are required."]);
    exit;
}

// Prepare the SQL statement to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $message);

// Execute the statement and check if successful
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Your feedback has been submitted successfully!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Failed to submit feedback."]);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
