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
    $bookname = $_POST['bookname'];
    $bserial = $_POST['bserial'];
    $authorname = $_POST['authorname'];
    $pubname = $_POST['pubname'];
    $purcdate = $_POST['purcdate'];
    $bprice = $_POST['bprice'];

    if (isset($_FILES['f1']) && $_FILES['f1']['error'] == 0) {
        $fileTmpPath = $_FILES['f1']['tmp_name'];
        $fileSize = $_FILES['f1']['size'];
        $fileType = $_FILES['f1']['type'];

        $fileContent = file_get_contents($fileTmpPath);

        $checkSql = "SELECT COUNT(*) as count FROM books WHERE BOOK_SERIAL = ? AND DLT_BOOK = 0";
        $stmt = $conn->prepare($checkSql);
        $stmt->bind_param("s", $bserial);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->fetch_assoc()['count'];

        if ($count > 0) {
            echo "<script>
                alert('The book serial number already exists. Please try again with a different serial number.');
                window.location.href = '../Frontend/HTML_code/AdminAddBook.html';
            </script>";
            exit();
        }

        $sql = "INSERT INTO books (TITLE, BOOK_IMG, PUB_NAME, BOOK_BDATE, BOOK_PRICE, AUTHOR, BOOK_SERIAL, AVAILABLE)
                VALUES (?, ?, ?, ?, ?, ?, ?, 1)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssdss", $bookname, $fileContent, $pubname, $purcdate, $bprice, $authorname, $bserial);
        $stmt->send_long_data(1, $fileContent);

        if ($stmt->execute()) {
            echo "<script>
                alert('Book added successfully.');
                window.location.href = '../Frontend/HTML_code/AdminAddBook.html';
            </script>";
        } else {
            echo "Error adding book: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "<script>
            alert('Please select a valid image file.');
            window.location.href = '../Frontend/HTML_code/AdminAddBook.html';
        </script>";
    }

    $conn->close();
}
?>
