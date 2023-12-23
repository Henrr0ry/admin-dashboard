<?php
$conn = new mysqli('localhost', 'root', '', 'pumpa_db');
if ($conn->connect_error) {
    die("Připojení selhalo: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["table"]) && isset($_POST["id"])) {
    $table = $_POST["table"];
    $id = $_POST["id"];

    $sql = "DELETE FROM $table WHERE ID = $id;";
    $conn->query($sql);

    $sql = "SET @count := 0;
            UPDATE $table SET ID = @count := (@count + 1);
            ALTER TABLE $table AUTO_INCREMENT = 1;";
    $conn->multi_query($sql);
}
$conn->close();
?>