<?php
session_start();
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    $stmt = $link->prepare("INSERT INTO contactus_info (CON_NAME, CON_EMAIL, CON_PHONE, CON_MSG) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($link->error));
    }

    $bind = $stmt->bind_param("ssss", $name, $email, $phone, $message);
    if ($bind === false) {
        die('Bind failed: ' . htmlspecialchars($stmt->error));
    }

    $execute = $stmt->execute();
    if ($execute === false) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    $stmt->close();
    $link->close();

    header("Location: ../Frontend/HTML_code/UserContact.html?success=1");
    exit();
} else {
    echo "Invalid request method.";
}
?>
