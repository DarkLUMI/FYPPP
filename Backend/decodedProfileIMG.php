<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "librarydb";

$email = $_SESSION['USER_EMAIL'];

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT USER_IMG FROM users WHERE USER_EMAIL = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $imageData = $row['USER_IMG'];

    if ($imageData) {
        header("Content-type: image/jpeg");
        echo $imageData;
        exit();
    }
} 

$default_profile_img = "../Assets/Image/default_profile_pic.jpg";
header("Content-type: image/jpeg");
readfile($default_profile_img);

$conn->close();
exit();
?>