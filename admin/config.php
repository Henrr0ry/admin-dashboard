<?php
    //LOGIN DETAILS
    $display = "Admin";
    $profile = "admin.png";
    $N = "admin";
    $P = "$2y$10$.Zc3/IHeWpR6EIXpin/kX.F7GN6nGhdFyNtp23oSw6JVQBii1D.y6";

    //NO PHP CATCHE
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');

    //MYSQL DATABASE CONNECTION
    $conn = new mysqli('localhost', 'root', '', 'temp_db');
    if ($conn->connect_error) {
        echo "<h1>Connection Error!</h1>";
        die("Connection lost: " . $conn->connect_error);
    }

    //LANGUAGE PACK
    $lang_admin_login = "Admin Login";
    $lang_name = "Name";
    $lang_password = "Password";
    $lang_show_password = "Show password";
    $lang_login = "Login";

    $lang_admin_dashboard = "Admin Dashboard";
    $lang_files_and_logs = "Files and Logs";
    $lang_files = "Files";
    $lang_file_name = "Name";
    $lang_size = "Size";
    $lang_history = "History";

    $lang_db = "MySQL Database";
    $lang_refresh = "Refresh";
    $lang_upload = "Upload";
    $lang_delete = "Delete";
    $lang_edit = "Edit";
    $lang_add = "Add";

    $lang_edit_data = "Edit Data";
    $lang_add_data = "Add data";
    $lang_delete_data = "Do you realy want to delete this data?";
    $lang_no = "No, keep it";
    $lang_yes = "Yes, delete";
    $lang_upload_data = "Upload a file";
    $lang_close = "Close";
    $lang_save = "Save";

    $version = "1.0"
?>
