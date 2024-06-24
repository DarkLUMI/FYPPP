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
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $session = $_POST['session'];
    $department = $_POST['department'];

    $checkEmailQuery = "SELECT COUNT(*) as count FROM users WHERE USER_EMAIL = ?"; //Check db got the email mou
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email); ////defend sql injection
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->fetch_assoc()['count'];

    if ($count > 0) {
        echo "<script>
            alert('The email you provided has already been used. Please try again.');
            window.location.href = '../Frontend/HTML_code/Register.html';
        </script>";
        exit();
    }

    $checkUserNameQuery = "SELECT COUNT(*) as count FROM users WHERE USER_NAME = ?"; //Check db got the same user name mou
    $stmt1 = $conn->prepare($checkUserNameQuery);
    $stmt1->bind_param("s", $username); ////defend sql injection
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $count1 = $result1->fetch_assoc()['count'];

    if ($count1 > 0) {
        echo "<script>
            alert('The username you provided has already been used. Please try again.');
            window.location.href = '../Frontend/HTML_code/Register.html';
        </script>";
        exit();
    }

    if ($password == $confirm_password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); //encryption password in sql
        $sql = "INSERT INTO users (USER_RENO, USER_RNAME, USER_NAME, USER_EMAIL, USER_PASS, USER_PHONE, USER_ADDR, USER_SESS, USER_DEP, USER_REDATE) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $name, $username, $email, $hashedPassword, $phone, $address, $session, $department); //defend sql injection

        if ($stmt->execute()) {
            echo "New record created successfully";
            $sql1 = "SELECT USER_NAME, USER_PASS FROM users WHERE USER_EMAIL = ?";
            $stmt = $conn->prepare($sql1);
            $stmt->bind_param("s", $email); //defend sql injection
            $stmt->execute();
            $result = $stmt->get_result();

                echo "<script>
                    alert('New account created. Please proceed to login:');
                    window.location.href = '../Frontend/HTML_code/Login.html';
                </script>";
        }
        $conn->close();
        exit();
    } else {
        $conn->close();
        header("Location: ../Frontend/HTML_code/Register.html");
        exit();
    }
}
?>