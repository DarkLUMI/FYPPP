<?php
$link = mysqli_connect("localhost", "root", "", "librarydb");

if (mysqli_connect_errno()) {
    echo json_encode(array("message" => "Failed to connect to MySQL: " . mysqli_connect_error()));
    http_response_code(500);
    exit();
}

$postData = json_decode(file_get_contents('php://input'), true);
$username = $postData['username'];

try {
    $sql = "UPDATE users u JOIN borrow_history b ON u.USER_NAME = b.USER_NAME SET u.USER_STATUS = 1 
    WHERE u.USER_STATUS = 0 AND u.USER_NAME = ? AND b.RETURN_TF = 0 AND b.EXP_DATE < NOW();";

    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);

    mysqli_stmt_execute($stmt);

    $rowsAffected = mysqli_stmt_affected_rows($stmt);
    if ($rowsAffected > 0) {
        http_response_code(200);
        echo json_encode(array("message" => "User status updated successfully."));
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "No update needed or user not found."));
    }

    mysqli_stmt_close($stmt);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array("message" => "Failed to update user status: " . $e->getMessage()));
}

mysqli_close($link);
?>
