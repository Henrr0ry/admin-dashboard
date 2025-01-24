<?php
$directory = "../upload-files/";

if ($_SERVER["REQUEST_METHOD"] == "POST" && is_dir($directory) && isset($_FILES["fileToUpload"])) {
    $targetFile = $directory . basename($_FILES["fileToUpload"]["name"]); // Path to save file
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
        echo "File was succesfully uploaded!";
    } else {
        echo "Error when uploading file!";
    }
}
 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteFile"])) {
    $filename = $directory . $_POST["deleteFile"];
    if (file_exists($filename)) {
        if (unlink($filename)) {
            echo "File was succesfully deleted!";
        } else {
            echo "Error when deleting file!";
        }
    } else {
        echo "Error - File doesn't exist!";
    }
}
?>