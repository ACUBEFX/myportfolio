<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portfolio_db"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $service = $_POST['service'];

    // Prepare the SQL query to insert the data into the database
    $stmt = $conn->prepare("INSERT INTO service_requests (name, phone, service) VALUES (?, ?, ?)");
    
    if ($stmt === false) {
        echo json_encode(["status" => "error", "message" => "SQL prepare error: " . $conn->error]);
    } else {
        $stmt->bind_param("sss", $name, $phone, $service);

        // Execute the query
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Your request has been submitted successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
        }

        $stmt->close();
    }
}

$conn->close();
?>
