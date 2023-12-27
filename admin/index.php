<!DOCTYPE html>
<html>
    <head>
        <title>Admin Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="admin-style.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    </head>
    <?php
        include "config.php";
        if (isset($_POST["name"]) && isset($_POST["passwd"])) {
            if (strcmp($_POST["name"], $N) == 0 && password_verify($_POST["passwd"], $P)) {
                $_SESSION['POST'] = $_POST;
                header('Location: dashboard.php', true, 307);
            }
        }
    ?>
    <body>
        <p class="sign">Website by Henrr0ry</p>
        <div class="login">
            <h3>Admin Login</h3>
            <div>
                <form action="index.php" method="POST">
                    <label for="name">Name</label> <br>
                    <input name="name" type="text"> <br>

                    <label for="passwd">Password</label> <br>
                    <input id="passwd" name="passwd" type="password"> <br>

                    <label class="nomargin" for="showpasswd"><input id="showpasswd" type="checkbox" onclick="Show()">Show Password</label>

                    <button type="submit">Login</button> <br>
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