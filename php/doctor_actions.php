<?php
session_start();
require '../db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit();
}

// Folder where photos will be uploaded
$upload_dir = "../uploads/doctors/";

/* ========================== ADD DOCTOR =================*/
if (isset($_POST['add_doctor'])) {

    $name = $conn->real_escape_string($_POST['name']);
    $specialization = $conn->real_escape_string($_POST['specialization']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']); 
    $photo_name = "default-doctor.jpg"; 

    if (!empty($_FILES['photo']['name'])) {

        $file = $_FILES['photo'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
            $newName = "doctor_" . time() . "." . $ext;
            $target = $upload_dir . $newName;

            if (move_uploaded_file($file['tmp_name'], $target)) {
                $photo_name = $newName;
            }
        }
    }

    $sql = "INSERT INTO doctors (name, specialization, phone, email, password, photo)
            VALUES ('$name', '$specialization', '$phone', '$email', '$password', '$photo_name')";

    $conn->query($sql);

    header("Location: ../admin/manage_doctors.php");
    exit();
}

/* ====================== UPDATE DOCTOR =================*/

if (isset($_POST['update_doctor'])) {

    $id = intval($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $specialization = $conn->real_escape_string($_POST['specialization']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'] ? $conn->real_escape_string($_POST['password']) : null;

    // Get old photo
    $query = $conn->query("SELECT photo FROM doctors WHERE id='$id'");
    $oldData = $query->fetch_assoc();
    $old_photo = $oldData['photo'];

    $photo_name = $old_photo; 

    if (!empty($_FILES['photo']['name'])) {

        $file = $_FILES['photo'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (in_array($ext, ['jpg', 'jpeg', 'png'])) {

            $newName = "doctor_" . time() . "." . $ext;
            $target = $upload_dir . $newName;

            if (move_uploaded_file($file['tmp_name'], $target)) {
                $photo_name = $newName;

                // delete old photo if not default
                if ($old_photo !== "default-doctor.jpg" && file_exists($upload_dir . $old_photo)) {
                    unlink($upload_dir . $old_photo);
                }
            }
        }
    }

    /* -------- Build UPDATE Query -------- */
    if ($password !== null) {
        $sql = "UPDATE doctors SET 
                    name='$name', specialization='$specialization',
                    phone='$phone', email='$email', 
                    password='$password',
                    photo='$photo_name'
                WHERE id='$id'";
    } else {
        $sql = "UPDATE doctors SET 
                    name='$name', specialization='$specialization',
                    phone='$phone', email='$email',
                    photo='$photo_name'
                WHERE id='$id'";
    }

    $conn->query($sql);

    header("Location: ../admin/manage_doctors.php");
    exit();
}

/* ================== DELETE DOCTOR =====================*/

if (isset($_GET['delete'])) {

    $id = intval($_GET['delete']);

    // Get doctor for photo deletion
    $result = $conn->query("SELECT photo FROM doctors WHERE id='$id'");
    $data = $result->fetch_assoc();

    if ($data) {
        $photo = $data['photo'];

        // Delete doctor from database
        $conn->query("DELETE FROM doctors WHERE id='$id'");

        // delete photo (except default)
        if ($photo !== "default-doctor.jpg" && file_exists($upload_dir . $photo)) {
            unlink($upload_dir . $photo);
        }
    }

    header("Location: ../admin/manage_doctors.php");
    exit();
}
?>
