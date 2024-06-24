<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {

        session_start();

        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "librarydb";

        $email =  $_SESSION['USER_EMAIL'];

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $fileData = file_get_contents($_FILES["image"]["tmp_name"]);
        $escapedFileData = $conn->real_escape_string($fileData);

        $sql = "UPDATE users SET USER_IMG = '$escapedFileData' WHERE USER_EMAIL = '$email'";

        
        if ($conn->query($sql) === TRUE) {
            echo "Image uploaded successfully!";
            echo "<script>
            window.location.href = '../Frontend/HTML_code/UserProfile.html';
            </script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            echo "<script>
            window.location.href = '../Frontend/HTML_code/UserProfile.html';
            </script>";
        }

        $conn->close();
    }
}
?>