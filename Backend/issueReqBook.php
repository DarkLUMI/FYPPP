<?php
session_start();
include "connection.php";

if (isset($_POST['record_id'])) {
    $record_id = $_POST['record_id'];

    $sql_issue_check = 'SELECT ISSUED FROM book_rec WHERE RECORD_ID = ?';
    $stmt_issue_check = $link->prepare($sql_issue_check);
    $stmt_issue_check->bind_param("s", $record_id);

    if ($stmt_issue_check->execute()) {
        $result = $stmt_issue_check->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
                $sql_update_issue = 'UPDATE book_rec SET ISSUED = 1 WHERE RECORD_ID = ? AND ISSUED = 0';
                $stmt_update_issue = $link->prepare($sql_update_issue);
                $stmt_update_issue->bind_param("s", $record_id);

                if ($stmt_update_issue->execute()) {
                    echo "Book issueed successfully.";
                } else {
                    echo "Book is failed to issue";
                }
                $stmt_update_issue->close();
        } else {
            echo "No records found";
        }
    } else {
        echo "Execution failed: " . $stmt_issue_check->error;
    }
    $stmt_issue_check->close();
}

$link->close();
exit();
?>