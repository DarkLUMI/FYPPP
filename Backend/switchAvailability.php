<?php
session_start();
include "connection.php";

if (isset($_POST['book_serial'])) {
    $book_serial = $_POST['book_serial'];

    $sql_switch_check = 'SELECT AVAILABLE FROM books WHERE BOOK_SERIAL = ?';
    $stmt_switch_check = $link->prepare($sql_switch_check);
    $stmt_switch_check->bind_param("s", $book_serial);

    if ($stmt_switch_check->execute()) {
        $result = $stmt_switch_check->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $sql_update_switch = 'UPDATE books SET AVAILABLE = CASE WHEN AVAILABLE = 0 THEN 1 ELSE 0 END WHERE BOOK_SERIAL = ?';
                $stmt_update_switch = $link->prepare($sql_update_switch);
                $stmt_update_switch->bind_param("s", $book_serial);

                if ($stmt_update_switch->execute()) {
                    echo "Book Availability switched successfully.";
                } else {
                    echo "Book failed to switch";
                }
                $stmt_update_switch->close();
        } else {
            echo "No records found";
        }
    } else {
        echo "Execution failed: " . $stmt_switch_check->error;
    }
    $stmt_switch_check->close();
}

$link->close();
exit();
?>