<?php
include "connect.php";

if (isset($_POST['profile_id'])) {
    $profileId = $_POST['profile_id'];

    $accessQuery = "SHOW TABLES";
    $accessResult = $conn->query($accessQuery);
    $data = '{ "ID":"' . $profileId . '", ';
    $dataTypes = array();
    $illigalTables = ["log", "table_access", "profile"];
    $is_god = false;
    $access = array();;

    $dataQuery = "SELECT * FROM table_access WHERE profile_id = $profileId";
    $dataResult = $conn->query($dataQuery);

    if ($dataResult->num_rows > 0) {
        while ($row = $dataResult->fetch_assoc()) {
            if($row["is_god"] == true)
                $is_god = true;
            
            $access = json_decode($row["access_arr"]);
        }
    }


    if ($accessResult->num_rows > 0) {
        while ($row = $accessResult->fetch_assoc()) {
            if ( !in_array($row["Tables_in_admin_db"], $illigalTables)) {
                if ($is_god == true) {
                    $data .= ' "' . $row["Tables_in_admin_db"] . '": "1", ';
                } else if (in_array($row["Tables_in_admin_db"], $access)) {
                    $data .= ' "' . $row["Tables_in_admin_db"] . '": "1", ';
                }
                else {
                    $data .= ' "' . $row["Tables_in_admin_db"] . '": "0", ';
                }
                    $dataTypes[] = "tinyint(1)";
            }
        }
    }
    $data = rtrim($data, ", ");
    $data .= "} ";

    echo $data . ', ' . json_encode($dataTypes);
}
$conn->close();
?>
