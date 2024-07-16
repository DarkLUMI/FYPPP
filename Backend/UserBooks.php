<?php
session_start();
include 'connection.php';

$books = [];

if (isset($_GET["submit1"])) {
    $searchTerm = '%' . $_GET['search'] . '%';
    $stmt = $link->prepare("SELECT TITLE, PUB_NAME, AUTHOR, SUM(AVAILABLE) AS AVAILABLE_COUNT
                            FROM books
                            WHERE TITLE LIKE ? AND DLT_BOOK = 0
                            GROUP BY TITLE
                            ORDER BY AVAILABLE_COUNT DESC");
    $stmt->bind_param("s", $searchTerm);
} else {
    $stmt = $link->prepare("SELECT TITLE, PUB_NAME, AUTHOR, SUM(AVAILABLE) AS AVAILABLE_COUNT
                            FROM books
                            WHERE DLT_BOOK = 0
                            GROUP BY TITLE
                            ORDER BY AVAILABLE_COUNT DESC");
}

if ($stmt->execute()) {
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }

    $stmt->close();

    foreach ($books as &$book) {
        $title = $book['TITLE'];
        $imgStmt = $link->prepare("SELECT BOOK_IMG FROM books WHERE TITLE = ? AND DLT_BOOK = 0 LIMIT 1");
        $imgStmt->bind_param("s", $title);
        $imgStmt->execute();
        $imgResult = $imgStmt->get_result();

        if ($imgRow = $imgResult->fetch_assoc()) {
            $book['BOOK_IMG'] = base64_encode($imgRow['BOOK_IMG']);
        }

        $imgStmt->close();
    }

    $link->close();

    echo json_encode($books);
} else {
    echo json_encode(["error" => "Failed to fetch books"]);
    $stmt->close();
    $link->close();
    exit();
}
?>
