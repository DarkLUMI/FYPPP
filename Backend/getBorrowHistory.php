<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

    if (!empty($searchTerm)) {
        $sql = "SELECT a.TRANS_ID, a.BOOK_SERIAL, b.TITLE, a.BORROW_DATE, a.EXP_DATE, a.RETURN_DATE, a.USER_NAME 
                FROM borrow_history AS a 
                INNER JOIN books AS b ON a.BOOK_SERIAL = b.BOOK_SERIAL 
                WHERE a.BOOK_SERIAL LIKE ? OR a.USER_NAME LIKE ? 
                ORDER BY CASE WHEN a.RETURN_DATE IS NULL THEN 0 ELSE 1 END, a.TRANS_ID DESC";
        
        $searchTerm = "%$searchTerm%";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
    } else {
        $sql = 'SELECT a.TRANS_ID, a.BOOK_SERIAL, b.TITLE, a.BORROW_DATE, a.EXP_DATE, a.RETURN_DATE, a.USER_NAME 
                FROM borrow_history AS a 
                INNER JOIN books AS b ON a.BOOK_SERIAL = b.BOOK_SERIAL 
                ORDER BY CASE WHEN a.RETURN_DATE IS NULL THEN 0 ELSE 1 END, a.TRANS_ID DESC';
        
        $stmt = $link->prepare($sql);
    }

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
        echo "Execution failed: " . $stmt->error;
    }

    $stmt->close();
}

$link->close();
exit();
?>