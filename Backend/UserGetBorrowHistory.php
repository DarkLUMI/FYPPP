<?php
session_start();

include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['userName'])) {
        $username = $_GET['userName'];
        $sql = "SELECT a.TRANS_ID, a.BOOK_SERIAL, b.TITLE, a.BORROW_DATE, a.EXP_DATE, a.RETURN_DATE, a.USER_NAME 
                FROM borrow_history AS a 
                INNER JOIN books AS b ON a.BOOK_SERIAL = b.BOOK_SERIAL 
                WHERE a.USER_NAME = ? 
                ORDER BY CASE WHEN a.RETURN_DATE IS NULL THEN 0 ELSE 1 END, a.TRANS_ID DESC";

        $stmt = $link->prepare($sql);
        $stmt->bind_param("s", $username);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $bookRecordArray = [];
                
                while ($row = $result->fetch_assoc()) {
                    $bookRecordArray[] = $row;
                }

                echo json_encode($bookRecordArray);
            } else {
                echo json_encode([]);
            }
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Execution failed: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        http_response_code(401);
        echo json_encode(['error' => 'User not authenticated']);
    }
}

$link->close();
exit();
?>
