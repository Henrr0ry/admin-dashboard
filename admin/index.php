    <?php
        include "config.php";
        if (isset($_POST["name"]) && isset($_POST["passwd"])) {
            $profiles = $conn->query("SELECT name, password FROM profile");
            if ($profiles->num_rows > 0) {
                while($profile = $profiles->fetch_assoc()) {
                    if (strcmp($_POST["name"], $profile["name"]) == 0 && password_verify($_POST["passwd"], $profile["password"])) {
                        //LOG
                        $log = "('" . date("H:i:s d.m.Y") . " - " . $_POST["name"] . " login" . "')";
                        $sql = "INSERT INTO log VALUES $log";
                        $conn->query($sql);

                        //LOGIN
                        $_SESSION['POST'] = $_POST;
                        header('Location: dashboard.php', true, 307);
                        break;
                    }
                }
              }
        }
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title><?= $lang_admin_login ?></title>
        <meta charset="UTF-8">
        <meta http-equiv="Cache-Control" content="no-store" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="admin-style.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    </head>
    <body>
        <p class="sign">2024 © Henrr0ry, version <?= $version ?></p>
        <div class="login">
            <h3><?= $lang_admin_login ?></h3>
            <div>
                <form action="index.php" method="POST">
                    <label for="name"><?= $lang_name?></label> <br>
                    <input name="name" type="text"> <br>

                    <label for="passwd"><?= $lang_password?></label> <br>
                    <input id="passwd" name="passwd" type="password"> <br>

                    <label class="nomargin" for="showpasswd"><input id="showpasswd" type="checkbox" onclick="Show()"><?= $lang_show_password ?></label>

                    <button type="submit"><?= $lang_login ?></button> <br>
                </form>
            </div>
        </div>
    </body>
    <script>
        function Show() {
            var check = document.getElementById("showpasswd");
            var x = document.getElementById("passwd");
            if (check.checked == true) {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</html>
