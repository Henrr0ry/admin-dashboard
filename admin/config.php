<?php
    //LOGIN DETAILS
    $display = "Admin";
    $profile = "admin.png";
    $N = "admin";
    $P = "$2y$10$.Zc3/IHeWpR6EIXpin/kX.F7GN6nGhdFyNtp23oSw6JVQBii1D.y6";

    //NO PHP CATCHE
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');

    //MYSQL DATABASE CONNECTION
    $conn = new mysqli('localhost', 'root', '', 'pumpa_db');
    if ($conn->connect_error) {
        echo "<h1>Connection Error!</h1>";
        die("Connection lost: " . $conn->connect_error);
    }
?>