<?php
$conn = new mysqli('localhost', 'root', '', 'pumpa_db');
if ($conn->connect_error) {
    die("Připojení selhalo: " . $conn->connect_error);
}

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