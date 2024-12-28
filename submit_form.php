<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hire_service"; // Ensure this matches your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is received via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and retrieve form inputs
    $name = htmlspecialchars($_POST['name']);
    $contact_number = htmlspecialchars($_POST['contact_number']);
    $design_type = htmlspecialchars($_POST['design_type']);
    $description = htmlspecialchars($_POST['description']);

    // Debugging: Print received form data
    echo "Received data:<br>";
    echo "Name: $name<br>";
    echo "Contact Number: $contact_number<br>";
    echo "Design Type: $design_type<br>";
    echo "Description: $description<br>";

    // Prepare the SQL statement
    $sql = "INSERT INTO hire_requests (name, contact_number, design_type, description) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param("ssss", $name, $contact_number, $design_type, $description);

    // Execute the query
    if ($stmt->execute()) {
        echo "Your request has been submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>










