<?php
// Database connection
$servername = "localhost";
$username = "root";  // default for XAMPP
$password = "";      // default is empty
$dbname = "khagesh";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(displayMessage("Connection failed: " . $conn->connect_error, "error"));
}

// Function to display message with gradient page background
function displayMessage($msg, $type = "success") {
    // Text color based on type
    $color = $type === "success" ? "#28a745" : "#dc3545"; // green or red

    // Gradient background for full page
    $pageBackground = "linear-gradient(135deg, #434343ff, #45f3f9ff, #61b1b4ff)";

    return "
    <body style='
        margin: 0;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: $pageBackground;
    '>
        <div style='
            font-family: Arial, sans-serif;
            color: $color;
            background: #000000cc;
            padding: 25px 40px;
            text-align: center;
            border-radius: 12px;
            font-size: 24px;
            font-weight: bold;
            box-shadow: 0 0 15px $color;
        '>$msg</div>
    </body>
    ";
}

// Collect form data
$suc_code = $_POST['suc_code'];
$name = $_POST['name']; 
$email = $_POST['email'];
$phone_no = $_POST['phone_no'];

// Check if the user is already registered by Suc_Code
$check_sql = "SELECT * FROM students WHERE Suc_Code = '$suc_code'";
$result = $conn->query($check_sql);

if ($result->num_rows > 0) {
    // User already registered
    echo displayMessage("Student with this Suc_Code is already registered!", "error");
} else {
    // Insert into database
    $sql = "INSERT INTO students (Suc_Code, Name, Email, Phone_No)
            VALUES ('$suc_code', '$name', '$email', '$phone_no')";

    if ($conn->query($sql) === TRUE) {
        echo displayMessage("New student registered successfully!", "success");
    } else {
        echo displayMessage("Error: " . $sql . "<br>" . $conn->error, "error");
    }
}

$conn->close();
?>