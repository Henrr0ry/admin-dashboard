<?php
$directory = "../upload-files";
$fileData = array();

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

function formatFileSize($size) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $i = 0;
    while ($size >= 1024 && $i < count($units) - 1) {
        $size /= 1024;
        $i++;
    }
    return round($size, 2) . ' ' . $units[$i];
}

header("Content-Type: application/json");
echo json_encode($fileData);
?>
