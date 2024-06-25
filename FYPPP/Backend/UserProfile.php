<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "librarydb";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_name = $_SESSION['USER_NAME'];
    $user_email = $_SESSION['USER_EMAIL'];
    $user_type = $_SESSION['USER_TYPE'];

    $name = $_POST['name'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $session = $_POST['session'];
    $dept = $_POST['dept'];

    $sql = "UPDATE users SET ";

    if (!empty($name)) {
        $sql .= "USER_RNAME = '$name', ";
    }

    if (!empty($password) && !empty($confirm_password) && $password === $confirm_password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql .= "USER_PASS = '$hashedPassword', ";
    }

    if (!empty($phone)) {
        $sql .= "USER_PHONE = '$phone', ";
    }

    if (!empty($address)) {
        $sql .= "USER_ADDR = '$address', ";
    }

    if (!empty($session)) {
        $sql .= "USER_SESS = '$session', ";
    }

    if (!empty($dept)) {
        $sql .= "USER_DEP = '$dept', ";
    }

    $sql = rtrim($sql, ', ');
    $sql .= " WHERE USER_EMAIL = '$user_email'";

    $result = $conn->query($sql);

    if ($result) {
        echo "Update successful!";
        // Redirect to profile page
        echo "<script>
            window.location.href = '../Frontend/HTML_code/UserProfile.html';
        </script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>