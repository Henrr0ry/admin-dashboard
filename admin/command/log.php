<?php
include "connect.php";

if (isset($_POST["event"])) {
    $event = $_POST["event"];
    $log = "('" . date("H:i:s d.m.Y") . " - " . $event . "')";

    $sql = "INSERT INTO log VALUES $log";
    $conn->query($sql);
}
$conn->close();
?>