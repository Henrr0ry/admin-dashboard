<?php
$directory = "../upload-files/";

if ($_SERVER["REQUEST_METHOD"] == "POST" && is_dir($directory) && isset($_FILES["fileToUpload"])) {
    $targetFile = $directory . basename($_FILES["fileToUpload"]["name"]); // Cesta k uložení souboru
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
        echo "Soubor byl úspěšně nahrán.";
    } else {
        echo "Chyba při nahrávání souboru.";
    }
}
 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteFile"])) {
    $filename = $directory . $_POST["deleteFile"];
    if (file_exists($filename)) {
        if (unlink($filename)) {
            echo "Soubor byl úspěšně odstraněn.";
        } else {
            echo "Chyba při odstraňování souboru.";
        }
    } else {
        echo "Soubor neexistuje.";
    }
}
?>