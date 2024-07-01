<?php
header('Content-Type: application/json');

include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT 'total_users' AS TABLE_NAME, COUNT(USER_RENO) AS COUNT FROM users
            UNION ALL
            SELECT 'pending_borrowed_books' AS TABLE_NAME, COUNT(TRANS_ID) AS COUNT FROM borrow_history WHERE RETURN_TF = 0
            UNION ALL
            SELECT 'total_library_books' AS TABLE_NAME, COUNT(BOOK_SERIAL) AS COUNT FROM books
            UNION ALL
            SELECT 'total_requested_books' AS TABLE_NAME, COUNT(RECORD_ID) AS COUNT FROM book_rec WHERE ISSUED = 0";

    $stmt = $link->prepare($sql);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        $dashboardData = [];
        while ($row = $result->fetch_assoc()) {
            $dashboardData[] = $row;
        }

        echo json_encode($dashboardData);
    } else {
        echo json_encode(["error" => "Execution failed: " . $stmt->error]);
    }

    $stmt->close();
}

$link->close();
?>