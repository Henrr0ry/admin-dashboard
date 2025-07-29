<?php
include "connect.php";

if (isset($_POST["name"]) && isset($_POST["passwd"])) {
    $profiles = $conn->query("SELECT name, password FROM profile");
    if ($profiles->num_rows > 0) {
        while($profile = $profiles->fetch_assoc()) {
            if (strcmp($_POST["name"], $profile["name"]) == 0 && password_verify($_POST["passwd"], $profile["password"])) {
                
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

            }
        }
    }
} else {
    return "";
}
?>
