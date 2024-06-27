<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = 'SELECT a.BOOK_SERIAL, b.TITLE, a.BORROW_DATE, a.EXP_DATE, a.RETURN_DATE, a.USER_NAME 
            FROM borrow_history AS a 
            INNER JOIN books AS b ON a.BOOK_SERIAL = b.BOOK_SERIAL';
    
    $stmt = $link->prepare($sql);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $bookRecordArray = [];
            
            while ($row = $result->fetch_assoc()) {
                $bookRecordArray[] = $row;
            }

            echo json_encode($bookRecordArray);

        } else {
            echo "No records found";
        }
    } else {
        echo "Execution failed: " . $stmt->error;
    }

    $stmt->close();
}

$link->close();
exit();
?>