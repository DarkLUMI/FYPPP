<?php
header('Content-Type: application/json');

include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $userName = $_GET['userName'];
    $userEmail = $_GET['userEmail'];
    

    $sql = "SELECT 'next_return' AS TABLE_NAME, MIN(EXP_DATE) AS COUNT FROM borrow_history WHERE USER_NAME = ? AND RETURN_TF = 0
            UNION ALL 
            SELECT 'borrowed_book' AS TABLE_NAME, COUNT(TRANS_ID) AS COUNT FROM borrow_history 
            WHERE USER_NAME = ?
            UNION ALL
            SELECT 'user_status' AS TABLE_NAME, USER_STATUS AS COUNT FROM users WHERE USER_NAME = ?
            UNION ALL
            SELECT 'requested_book' AS TABLE_NAME, COUNT(RECORD_ID) AS COUNT FROM book_rec WHERE USER_EMAIL = ?";

    $stmt = $link->prepare($sql);
    $stmt->bind_param("ssss", $userName, $userName, $userName, $userEmail);

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