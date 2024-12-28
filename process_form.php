<?php
// Database connection settings
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "services"; // Updated database name

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

    // Prepare the SQL statement
    $sql = "INSERT INTO hire_requests (name, contact_number, design_type, description) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Error preparing statement: ' . $conn->error);
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

?>
