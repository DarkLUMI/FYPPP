<?php
session_start();

include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['userEmail'])) {
        $useremail = $_GET['userEmail'];
        $sql = "SELECT RECORD_ID, REQBOOK_N, REQBOOK_URL, ISSUED, USER_EMAIL
                FROM book_rec 
                WHERE USER_EMAIL = ? 
                ORDER BY CASE WHEN ISSUED IS NULL THEN 0 ELSE 1 END, RECORD_ID ASC";

        $stmt = $link->prepare($sql);
        $stmt->bind_param("s", $useremail);

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
