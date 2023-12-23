<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_POST["event"])) {
    $event = $_POST["event"];
    $log = date("H:i:s d.m.Y") . " - " . $event . "\n";

    $filename = "history.log";
    if (!file_exists($filename)) {
        touch($filename);
        chmod($filename, 0777);
    }
    
    $file = fopen($filename, "a");
    fwrite($file, $log);
    fclose($file);
}

$conn->close();
?>