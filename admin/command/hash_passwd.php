<?php
$passwd = $_POST["passwd"];
$hashed_passwd = password_hash($passwd, PASSWORD_DEFAULT);

echo $hashed_passwd;
?>