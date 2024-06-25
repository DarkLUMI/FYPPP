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

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bname = $_POST['bname'];
    $burl = $_POST['burl'];
    $user_email = $_SESSION['USER_EMAIL'];

    $Xissue = 0;
    
    $stmt = $conn->prepare("INSERT INTO book_rec (REQBOOK_N, REQBOOK_URL, ISSUED, USER_EMAIL) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $bname, $burl, $Xissue, $user_email);


    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }

    $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    }

$conn->close();
?>
