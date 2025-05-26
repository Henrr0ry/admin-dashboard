<?php
    //MYSQL DATABASE CONNECTION
    $conn = new mysqli('localhost', 'root', '', 'admin_db');
    if ($conn->connect_error) {
        die("Connection lost: " . $conn->connect_error);
    }
?>
