<?php
    //MYSQL DATABASE CONNECTION
    $conn = new mysqli('localhost', 'root', '', 'temp_db');
    if ($conn->connect_error) {
        die("Connection lost: " . $conn->connect_error);
    }
?>
