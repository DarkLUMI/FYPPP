<?php
session_start();
include 'connection.php';

$books = [];

if (isset($_GET["submit1"])) {
    $searchTerm = '%' . $_GET['search'] . '%';
    $stmt = $link->prepare("SELECT * FROM books WHERE title LIKE ?");
    $stmt->bind_param("s", $searchTerm);
} else {
    $stmt = $link->prepare("SELECT * FROM books");
}

if ($stmt->execute()) {
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $row['BOOK_IMG'] = base64_encode($row['BOOK_IMG']);
        $books[] = $row;
    }
    echo json_encode($books);
} else {
    echo json_encode(["error" => "Failed to fetch books"]);
}

$stmt->close();
$link->close();
exit();
?>