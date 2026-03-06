<?php
require '../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_POST['name'], $_POST['email'], $_POST['message'])) {
        echo "Invalid form submission!";
        exit;
    }

    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO contacts (name, email, message) VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql)) {
        echo "Message sent successfully!";
    } else {
        echo "Failed to send message!";
    }
}
?>
