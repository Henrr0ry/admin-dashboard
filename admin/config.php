<?php
    //NO PHP CATCHE
    /*header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');*/

    //MYSQL DATABASE CONNECTION
    try {
        $conn = new mysqli('localhost', 'root', '', 'admin_db');
    }
    catch(mysqli_sql_exception $e) {
        die("Database Connection Error, Server Error 500: </br>" . $e);
    }

    //LANGUAGE PACK
    $lang_admin_login = "Admin Login";
    $lang_name = "Name";
    $lang_password = "Password";
    $lang_show_password = "Show password";
    $lang_login = "Login";

    $lang_admin_dashboard = "Admin Dashboard";
    $lang_files = "Files";
    $lang_file_name = "Name";
    $lang_size = "Size";
    $lang_history = "History Log";
    $lang_tables = "Change Tables";
    $lang_users = "Change Profiles";

    $lang_db = "MySQL Database";
    $lang_refresh = "Refresh";
    $lang_upload = "Upload";
    $lang_delete = "Delete";
    $lang_edit = "Edit";
    $lang_add = "Add";
    $lang_table = "Table";

    $lang_edit_data = "Edit Data";
    $lang_add_data = "Add data";
    $lang_delete_data = "Do you realy want to delete this data?";
    $lang_no = "No, keep it";
    $lang_yes = "Yes, delete";
    $lang_upload_data = "Upload a file";
    $lang_close = "Close";
    $lang_save = "Save";

    $version = "1.2";
?>
