<?php
session_start();
include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_serial'])) {
    $book_serial = $_POST['book_serial'];

    $sql_check = 'SELECT * FROM books WHERE BOOK_SERIAL = ?';
    $stmt_check = $link->prepare($sql_check);
    $stmt_check->bind_param("i", $book_serial);

    if ($stmt_check->execute()) {
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            $sql_delete = 'UPDATE books SET DLT_BOOK = 1 WHERE BOOK_SERIAL = ?';
            $stmt_delete = $link->prepare($sql_delete);
            $stmt_delete->bind_param("i", $book_serial);

            if ($stmt_delete->execute()) {
                echo "Book marked as deleted successfully.";
            } else {
                echo "Failed to mark book as deleted.";
            }

            $stmt_delete->close();
        } else {
            echo "No records found for the provided book ID.";
        }
    } else {
        echo "Execution failed: " . $stmt_check->error;
    }

    $stmt_check->close();
}

$link->close();
exit();
?>
