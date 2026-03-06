<?php
session_start();
require '../db.php';

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

$doctor_id = $_SESSION['doctor_id'];

$name = $conn->real_escape_string($_POST['name']);
$phone = $conn->real_escape_string($_POST['phone']);
$new_password = $_POST['password'];

// IMAGE UPLOAD
$photo_name = "";

if (!empty($_FILES['photo']['name'])) {

    $photo_name = time() . "-" . basename($_FILES['photo']['name']);
    $target_path = "../uploads/doctors/" . $photo_name;

    move_uploaded_file($_FILES['photo']['tmp_name'], $target_path);

    // update with photo
    $conn->query("UPDATE doctors SET photo='$photo_name' WHERE id='$doctor_id'");
}

// PASSWORD UPDATE (optional)
if (!empty($new_password)) {
    $conn->query("UPDATE doctors SET password='$new_password' WHERE id='$doctor_id'");
}

// BASIC FIELDS UPDATE
$conn->query("
    UPDATE doctors SET 
    name='$name',
    phone='$phone'
    WHERE id='$doctor_id'
");

header("Location: profile.php?success=1");
exit();
?>
