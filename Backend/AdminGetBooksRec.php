<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

    if (!empty($searchTerm)) {
        $sql = "SELECT BOOK_ID, BOOK_SERIAL, BOOK_IMG, TITLE, AUTHOR, PUB_NAME, BOOK_BDATE, BOOK_PRICE, AVAILABLE 
                FROM books 
                WHERE (TITLE LIKE ? OR PUB_NAME LIKE ?) AND DLT_BOOK = 0 
                ORDER BY BOOK_ID ASC";
        
        $searchTerm = "%$searchTerm%";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
    } else {
        $sql = "SELECT BOOK_SERIAL, BOOK_IMG, TITLE, AUTHOR, PUB_NAME, BOOK_BDATE, BOOK_PRICE, AVAILABLE 
                FROM books 
                WHERE DLT_BOOK = 0
                ORDER BY BOOK_ID ASC";
        
        $stmt = $link->prepare($sql);
    }

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $bookRecordArray = [];
            
            while ($row = $result->fetch_assoc()) {
                // Convert BLOB image data to base64
                if (!empty($row['BOOK_IMG'])) {
                    $row['BOOK_IMG'] = base64_encode($row['BOOK_IMG']);
                }
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
