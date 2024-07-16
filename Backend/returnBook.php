<?php
session_start();
include "connection.php";

if (isset($_POST['book_serial'])) {
    $book_serial = $_POST['book_serial'];
    $username = $_POST['username'];

    $sql_return_check = 'SELECT RETURN_TF FROM borrow_history WHERE BOOK_SERIAL = ?';
    $stmt_return_check = $link->prepare($sql_return_check);
    $stmt_return_check->bind_param("s", $book_serial);

    $checkSql = "SELECT COUNT(*) FROM borrow_history WHERE USER_NAME = ? AND RETURN_TF = 0 AND EXP_DATE < NOW()";
    $checkStmt = mysqli_prepare($link, $checkSql);
    mysqli_stmt_bind_param($checkStmt, "s", $username);
    mysqli_stmt_execute($checkStmt);
    mysqli_stmt_bind_result($checkStmt, $unreturnedCount);
    mysqli_stmt_fetch($checkStmt);
    mysqli_stmt_close($checkStmt);

    if ($stmt_return_check->execute()) {
        $result = $stmt_return_check->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $sql_update_return = 'UPDATE borrow_history SET RETURN_TF = 1, RETURN_DATE = NOW() WHERE BOOK_SERIAL = ? AND RETURN_TF = 0';
            $stmt_update_return = $link->prepare($sql_update_return);
            $stmt_update_return->bind_param("s", $book_serial);

            if ($stmt_update_return->execute()) {
                echo "Book returned successfully.";
            } else {
                echo "Book failed to return.";
            }
            $stmt_update_return->close();
        } else {
            echo "No records found.";
        }

        if ($unreturnedCount <= 1) {
            $updateSql = "UPDATE users SET USER_STATUS = 0 WHERE USER_STATUS = 1 AND USER_NAME = ?";
            $updateStmt = mysqli_prepare($link, $updateSql);
            mysqli_stmt_bind_param($updateStmt, "s", $username);
            mysqli_stmt_execute($updateStmt);
            mysqli_stmt_close($updateStmt);
        }
    } else {
        echo "Execution failed: " . $stmt_return_check->error;
    }
    $stmt_return_check->close();
}

$link->close();
exit();
?>
