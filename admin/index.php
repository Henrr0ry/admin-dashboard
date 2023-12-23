<!DOCTYPE html>
<html>
    <head>
        <title>Avanz Group s.r.o - Admin</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="admin-style.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    </head>
    <?php
        $N = "admin";
        $P = "$2y$10$.Zc3/IHeWpR6EIXpin/kX.F7GN6nGhdFyNtp23oSw6JVQBii1D.y6";

        if (isset($_POST["name"]) && isset($_POST["passwd"])) {
            if (strcmp($_POST["name"], $N) == 0 && password_verify($_POST["passwd"], $P)) {
                $_SESSION['POST'] = $_POST;
                header('Location: dashboard.php', true, 307);
            }
        }
    ?>
    <?php
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
?>

    <body>
        <p class="sign">Website by Henrr0ry</p>
        <div class="login">
            <h3>Admin Přihlášení</h3>
            <div>
                <form action="index.php" method="POST">
                    <label for="name">Jméno</label> <br>
                    <input name="name" type="text"> <br>

                    <label for="passwd">Heslo</label> <br>
                    <input id="passwd" name="passwd" type="password"> <br>

                    <label class="nomargin" for="showpasswd"><input id="showpasswd" type="checkbox" onclick="Show()">Zobrazit heslo</label>

                    <button type="submit">Přihlásit se</button> <br>
                </form>
            </div>
        </div>
    </body>
    <script>
        function Show() {
            var x = document.getElementById("passwd");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</html>