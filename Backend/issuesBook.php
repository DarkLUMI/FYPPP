<?php
session_start();
include 'connection.php'; // Ensure this file correctly establishes $link or $conn

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username']) && isset($_POST['bookSerial'])) {

        $bookSerialString = $_POST['bookSerial'];
        $bookSerialArray = explode(',', $bookSerialString);

        $username = $_POST['username'];
        $borrowDateString = date('Y-m-d');
        $expDateString = date('Y-m-d', strtotime('+7 days'));

        $isValid = true;

        $sql_user = "SELECT USER_NAME FROM users WHERE USER_NAME = ?";
        $stmt_user = $link->prepare($sql_user);
        $stmt_user->bind_param("s", $username);

        if ($stmt_user->execute()) {
            $stmt_user->store_result();

            if ($stmt_user->num_rows == 0) {
                echo "<script>
                        alert('Username not found.');
                        window.location.href = '../Frontend/HTML_code/AdminIssueBook.html';
                    </script>";
                $isValid = false;
            }
        } else {
            echo "Error checking user: " . $stmt_user->error . "<br>";
            $isValid = false;
        }

        foreach ($bookSerialArray as $bookSerial) {
            $sql_book = "SELECT BOOK_SERIAL FROM books WHERE BOOK_SERIAL = ?";
            $stmt_book = $link->prepare($sql_book);
            $stmt_book->bind_param("s", $bookSerial);

            if ($stmt_book->execute()) {
                $stmt_book->store_result();

                if ($stmt_book->num_rows == 0) {
                    echo "<script>
                        alert('Book serial not found.');
                        window.location.href = '../Frontend/HTML_code/AdminIssueBook.html';
                    </script>";
                    $isValid = false;
                }
            } else {
                echo "Error checking book: " . $stmt_book->error . "<br>";
                $isValid = false;
            }
        }

        if ($isValid) {
            foreach ($bookSerialArray as $bookSerial) {
                $sql_insert = "INSERT INTO borrow_history (BORROW_DATE, EXP_DATE, BOOK_SERIAL, USER_NAME) VALUES (?, ?, ?, ?)";
                $stmt_insert = $link->prepare($sql_insert);
                $stmt_insert->bind_param("ssss", $borrowDateString, $expDateString, $bookSerial, $username);

                if ($stmt_insert->execute()) {
                    echo "<script>
                            alert('Book issued successfully.');
                            window.location.href = '../Frontend/HTML_code/AdminIssueBook.html';
                          </script>";
                } else {
                    echo "Error updating borrow history: " . $stmt_insert->error;
                }
            }
        } else {
            echo "Invalid operation due to previous errors.";
        }
    }
}

$link->close();
exit();
?>