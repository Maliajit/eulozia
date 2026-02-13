<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SHOW DATABASES LIKE 'eulozia'");

if ($result->num_rows > 0) {
    echo "Database 'eulozia' exists";
} else {
    echo "Database 'eulozia' does not exist";
}

$conn->close();
?>
