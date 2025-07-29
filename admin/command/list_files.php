<?php
include "connect.php";
$directory = "../upload-files";
$fileData = array();

function formatFileSize($size) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $i = 0;
    while ($size >= 1024 && $i < count($units) - 1) {
        $size /= 1024;
        $i++;
    }
    return round($size, 2) . ' ' . $units[$i];
}


if (isset($_POST["name"]) && isset($_POST["passwd"])) {
    $profiles = $conn->query("SELECT name, password FROM profile");
    $conn->close();
    if ($profiles->num_rows > 0) {
        while($profile = $profiles->fetch_assoc()) {
            if (strcmp($_POST["name"], $profile["name"]) == 0 && password_verify($_POST["passwd"], $profile["password"])) {
                
                if (is_dir($directory)) {
                    if ($dh = opendir($directory)) {
                        while (($file = readdir($dh)) !== false) {
                            if ($file != "." && $file != "..") {
                                $filePath = $directory . "/" . $file;
                                $fileSize = filesize($filePath);
                                $formattedSize = formatFileSize($fileSize);

                                $fileData[] = array(
                                    "name" => $file,
                                    "link" => "upload-files/" . $file,
                                    "size" => $formattedSize
                                );
                            }
                        }
                        closedir($dh);
                    }
                }
                header("Content-Type: application/json");
                echo json_encode($fileData);
            }
        }
    }
} else {
    return "";
}
?>
