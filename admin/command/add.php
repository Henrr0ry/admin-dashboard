<?php
include "connect.php";

if (isset($_POST["table"])) {
    $table = $_POST["table"];
    $names = $_POST["names"];
    $content = $_POST["content"];

    $sql = "INSERT INTO $table $names VALUES $content";
    $conn->query($sql);
}
$conn->close();
?>