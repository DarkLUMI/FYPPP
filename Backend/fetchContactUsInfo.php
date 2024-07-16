<?php
session_start();
include 'connection.php';

$contacts = [];

if (isset($_GET["submit1"])) {
    $searchTerm = '%' . $_GET['search'] . '%';
    $stmt = $link->prepare("SELECT CON_NAME, CON_EMAIL, CON_PHONE, CON_MSG FROM contactus_info WHERE CON_PHONE LIKE ?");
    $stmt->bind_param("s", $searchTerm);
} else {
    $stmt = $link->prepare("SELECT CON_NAME, CON_EMAIL, CON_PHONE, CON_MSG FROM contactus_info");
}

if ($stmt->execute()) {
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $contacts[] = $row;
    }
    echo json_encode($contacts);
} else {
    echo json_encode(["error" => "Failed to fetch contact us information"]);
}

$stmt->close();
$link->close();
exit();
?>
