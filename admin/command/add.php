<?php
include "connect.php";

if (isset($_POST["name"]) && isset($_POST["passwd"])) {
    $profiles = $conn->query("SELECT name, password FROM profile");
    if ($profiles->num_rows > 0) {
        while($profile = $profiles->fetch_assoc()) {
            if (strcmp($_POST["name"], $profile["name"]) == 0 && password_verify($_POST["passwd"], $profile["password"])) {
                

                if (isset($_POST["table"])) {
                    $table = $_POST["table"];
                    $names = $_POST["names"];
                    $content = $_POST["content"];

                    $sql = "INSERT INTO $table $names VALUES $content";
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