<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

    if (!empty($searchTerm)) {
        $sql = "SELECT a.RECORD_ID, b.USER_NAME, a.USER_EMAIL, a.REQBOOK_N, a.REQBOOK_URL, a.ISSUED 
                FROM book_rec AS a 
                INNER JOIN users AS b ON a.USER_EMAIL = b.USER_EMAIL
                WHERE b.USER_NAME LIKE ? OR a.REQBOOK_N LIKE ? 
                ORDER BY CASE WHEN a.ISSUED = 0 THEN 0 ELSE 1 END, a.RECORD_ID ASC";
        
        $searchTerm = "%$searchTerm%";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
    } else {
        $sql = 'SELECT a.RECORD_ID, b.USER_NAME, a.USER_EMAIL, a.REQBOOK_N, a.REQBOOK_URL, a.ISSUED 
                FROM book_rec AS a 
                INNER JOIN users AS b ON a.USER_EMAIL = b.USER_EMAIL 
                ORDER BY CASE WHEN a.ISSUED = 0 THEN 0 ELSE 1 END, a.RECORD_ID ASC';
        
        $stmt = $link->prepare($sql);
    }

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $reqbookRecordArray = [];
            
            while ($row = $result->fetch_assoc()) {
                $reqbookRecordArray[] = $row;
            }

            echo json_encode($reqbookRecordArray);

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