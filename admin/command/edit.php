<?php
include "connect.php";

if (isset($_POST["table"])) {
    $table = $_POST["table"];
    $id = $_POST["id"];
    $name = $_POST["name"];
    $content = $_POST["content"];

    $sql = "UPDATE $table SET $name = '$content' WHERE ID = $id";
    $conn->query($sql);
}
$conn->close();
?>