<?php
include "connect.php";

if (isset($_POST["name"]) && isset($_POST["passwd"])) {
    $profiles = $conn->query("SELECT name, password FROM profile");
    if ($profiles->num_rows > 0) {
        while($profile = $profiles->fetch_assoc()) {
            if (strcmp($_POST["name"], $profile["name"]) == 0 && password_verify($_POST["passwd"], $profile["password"])) {
                
                if (isset($_POST["id_arr"])) {
                    $id_arr = json_decode($_POST["id_arr"]);
                    $value_arr = json_decode($_POST["value_arr"]);

                    $table_arr = '[';
                    $profile_id = (int)$value_arr[0];

                    for ($i = 1; $i < count($id_arr); $i++) 
                    {
                        if ($value_arr[$i] == 1)
                        {
                            $table_arr .= '"' . $id_arr[$i] . '", ';
                        }
                    }
                    $table_arr = rtrim($table_arr, ', ');
                    $table_arr .= ']';

                    $getsql = "SELECT * FROM table_access WHERE ID = $profile_id";
                    $sqlResult = $conn->query($getsql);
                    if ($sqlResult->num_rows == 0) 
                    {
                        $createSql = "INSERT INTO table_access (profile_id, access_arr, is_god) VALUES ($profile_id, '', 0)";
                        $conn->query($createSql);
                    }

                    $sql = "UPDATE table_access SET access_arr = '$table_arr' WHERE profile_id = $profile_id";
                    $conn->query($sql);
                }
                    $conn->close();
                }
        }
    }
} else {
    return "";
}
?>