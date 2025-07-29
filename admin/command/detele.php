<?php
include "connect.php";

if (isset($_POST["name"]) && isset($_POST["passwd"])) {
    $profiles = $conn->query("SELECT name, password FROM profile");
    if ($profiles->num_rows > 0) {
        while($profile = $profiles->fetch_assoc()) {
            if (strcmp($_POST["name"], $profile["name"]) == 0 && password_verify($_POST["passwd"], $profile["password"])) {
                

                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["table"]) && isset($_POST["id"])) {
                    $table = $_POST["table"];
                    $id = $_POST["id"];

                    $sql = "DELETE FROM $table WHERE ID = $id;";
                    $conn->query($sql);

                    $sql = "SET @count := 0;
                            UPDATE $table SET ID = @count := (@count + 1);
                            ALTER TABLE $table AUTO_INCREMENT = 1;";
                    $conn->multi_query($sql);
                }
                $conn->close();

            }
        }
    }
} else {
    return "";
}
?>