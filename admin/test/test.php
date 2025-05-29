<?php
include "command/connect.php";
echo "hello";

$dataQuery = "SELECT data FROM test2";
$dataResult = $conn->query($dataQuery);

foreach ($dataResult as $row) {
    echo '<img src="' . $row['data'] . '"><br>';
}

?>