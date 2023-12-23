<?php
$conn = new mysqli('localhost', 'root', '', 'pumpa_db');
if ($conn->connect_error) {
    die("Připojení selhalo: " . $conn->connect_error);
}

$tableName = $_POST['table'];

$dataQuery = "SELECT * FROM $tableName";
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
