<?php
$conn = new mysqli('localhost', 'root', '', 'pumpa_db');
if ($conn->connect_error) {
    die("Připojení selhalo: " . $conn->connect_error);
}

if (isset($_POST["table"])) {
    $table = $_POST["table"];
    $names = $_POST["names"];
    $content = $_POST["content"];

    $sql = "INSERT INTO $table $names VALUES $content";
    $conn->query($sql);
}
$conn->close();
?>