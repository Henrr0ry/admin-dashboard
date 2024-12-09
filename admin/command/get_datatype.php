<?php
include "connect.php";

$tableName = $_POST['table'];

$dataQuery = "SHOW COLUMNS FROM $tableName";
$dataResult = $conn->query($dataQuery);

$data = array();
if ($dataResult->num_rows > 0) {
    while ($row = $dataResult->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);

$conn->close();
?>
