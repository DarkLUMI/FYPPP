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
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT USER_NAME, USER_PASS, ACC_TYPE FROM users WHERE USER_EMAIL = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row['USER_PASS'];

            if (password_verify($password, $hashedPassword)) {
                $token = bin2hex(random_bytes(32));
                $_SESSION['token'] = $token;
                $_SESSION['USER_EMAIL'] = $email;
                $username = $row['USER_NAME'];
                $userType = ($row['ACC_TYPE'] == 0) ? 'User' : 'Admin';

                echo "<script>
                    sessionStorage.setItem('token', '$token');
                    sessionStorage.setItem('USER_EMAIL', '$email');
                    sessionStorage.setItem('USER_NAME', '$username');
                    sessionStorage.setItem('USER_TYPE', '$userType');
                    window.location.href = '../Frontend/HTML_code/UserDashboard.html';
                </script>";
            } else {
                echo "<script>
                    alert('Invalid email or password. Please try again.');
                    window.location.href = '../Frontend/HTML_code/Login.html';
                </script>";
            }
        } else {
            echo "<script>
                alert('Invalid email or password. Please try again.');
                window.location.href = '../Frontend/HTML_code/Login.html';
            </script>";
        }
    }
}

$conn->close();
exit();
?>