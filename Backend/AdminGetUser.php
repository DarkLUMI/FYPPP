<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

    if (!empty($searchTerm)) {
        $sql = "SELECT USER_RNAME, USER_NAME, USER_EMAIL, USER_PHONE, USER_ADDR, USER_SESS, USER_DEP, USER_REDATE, USER_STATUS 
                FROM users 
                WHERE USER_EMAIL LIKE ? OR USER_NAME LIKE ? 
                ORDER BY USER_REDATE DESC";
        
        $searchTerm = "%$searchTerm%";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
    } else {
        $sql = 'SELECT USER_RNAME, USER_NAME, USER_EMAIL, USER_PHONE, USER_ADDR, USER_SESS, USER_DEP, USER_REDATE, USER_STATUS 
                FROM users 
                WHERE ACC_TYPE LIKE 0 
                ORDER BY USER_REDATE DESC';
        
        $stmt = $link->prepare($sql);
    }

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $userRecordArray = [];
            
            while ($row = $result->fetch_assoc()) {
                $userRecordArray[] = $row;
            }

            echo json_encode($userRecordArray);

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