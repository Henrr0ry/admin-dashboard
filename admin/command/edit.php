<?php
include "connect.php";

if (isset($_POST["name"]) && isset($_POST["passwd"])) {
    $profiles = $conn->query("SELECT name, password FROM profile");
    if ($profiles->num_rows > 0) {
        while($profile = $profiles->fetch_assoc()) {
            if (strcmp($_POST["name"], $profile["name"]) == 0 && password_verify($_POST["passwd"], $profile["password"])) {
                
                if (isset($_POST["table"])) {
                    $table = $_POST["table"];
                    $id = $_POST["id"];
                    $lname = $_POST["lname"];
                    $content = $_POST["content"];

                    $sql = "UPDATE $table SET $lname = '$content' WHERE ID = $id";
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