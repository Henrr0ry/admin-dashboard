<?php 
        include "config.php";
        if (isset($_POST["name"]) && isset($_POST["passwd"])) {
            $profiles = $conn->query("SELECT * FROM profile");
            if ($profiles->num_rows > 0) {
                while($profile = $profiles->fetch_assoc()) {
                    if (strcmp($_POST["name"], $profile["name"]) == 0 && password_verify($_POST["passwd"], $profile["password"])) {
                        $icon = $profile["icon"];
                        $display_name = $profile["display_name"];
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?= $lang_admin_dashboard ?></title>
        <meta http-equiv="refresh" content="600">
        <meta http-equiv="Cache-Control" content="no-store" />
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="admin-style.css">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    </head>
    <body>
        <p class="sign">2024 © Henrr0ry, version <?= $version ?></p>
        <div class="dashboard">
            <header><?= $lang_admin_dashboard ?></header>
            <div class="log-panel">
                <img src="profile_pic/<?= $icon ?>" class="profile-pic"><h4 class="profile-name"><?= $display_name ?></h4>
                <button class="savebtn red" onclick="logout()">Log Out</button>
            </div>
            <section>
                <?php if ($profile["show_files"]) { ?>
                <div class="side">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="20"><?= $lang_files ?></th>
                            </tr>
                            <tr>
                                <th><?= $lang_file_name ?></th>
                                <th><?= $lang_size ?></th>
                                <th class="icon-cell"><img class="refresh icon noinvert" src="admin-image/refresh.png" onclick="loadFiles()" alt="<?= $lang_refresh ?>" title="<?= $lang_refresh ?>" draggable=false></th>
                                <th class="icon-cell"><img src="admin-image/upload.png" onclick='document.getElementById("upload").showModal();' alt="<?= $lang_upload ?>" title="<?= $lang_upload ?>" class="icon noinvert" draggable=false></th>
                            </tr>
                        </thead>
                        <tbody id="fileList">
                        </tbody>
                    </table>
                </div>
                <?php } if ($profile["show_logs"]) { ?>
                <div class="side">
                    <table>
                        <thead>
                            <tr>
                                <th><?= $lang_history ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fill-bg">
                                    <textarea id="log" disabled></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php } if ($profile["show_console"]) { ?>
                <div class="side">
                    <table>
                        <thead>
                            <tr>
                                <th><?= $lang_console ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fill-bg">
                                    <div class="small">
                                        <button class="btn" onclick="add_command(0)">CREATE TABLE</button>
                                        <button class="btn" onclick="add_command(1)">DROP TABLE</button>
                                        <button class="btn" onclick="add_command(2)">INSERT INTO</button>
                                        <button class="btn" onclick="add_command(3)">UPDATE</button>
                                        <button class="btn" onclick="add_command(4)">DELETE</button>
                                        <button class="btn" onclick="run_sql_command()" style="background: var(--red1)">RUN</button> <br>
                                        <button class="btn" onclick="add_command(5)">SELECT ALL</button>
                                        <button class="btn" onclick="add_command(6)">ALTER</button>
                                        <button class="btn" onclick="add_command(7)">ADD COLLUMN</button>
                                        <button class="btn" onclick="add_command(8)">DROP COLLUMN</button>
                                    </div>
                                    <textarea id="console_input" class="half" placeholder="SQL Commands to run"></textarea> <br>
                                    <textarea id="console_output" class="small" placeholder="SQL Console output"></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <script>
                        var commands = [
                            "CREATE TABLE <table>\n(\nID int AUTO_INCREMENT PRIMARY KEY,\n\n)",
                            "DROP TABLE <table>",
                            "INSERT INTO <table>\n(\n\n)\nVALUES\n(\n\n)",
                            "UPDATE <table>\nSET <column> = <value>\nWHERE",
                            "DELETE FROM <table>",
                            "SELECT * FROM <table>",
                            "ALTER TABLE <table>\nCHANGE\n<collumn>\n<new_collumn>\n<datatype>",
                            "ALTER TABLE <table>\nADD <new_collumn>\n<datatype>",
                            "ALTER TABLE <table>\nDROP <collumn>",
                        ];

                        function add_command(id) {
                            document.getElementById("console_input").value += commands[id];
                        }

                        function run_sql_command() {
                            var command = document.getElementById("console_input").value;

                            var phpdata = new FormData();
                            phpdata.append('name', name);
                            phpdata.append('passwd', "<?= $_POST["passwd"] ?>");
                            phpdata.append('command', command);

                            //console.log(name + " run command: " + command);
                            log(name + " run command: " + command);

                            var xhr = new XMLHttpRequest();
                            xhr.open("POST", "command/command.php", true);
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === 4 && xhr.status === 200) {
                                    var data = xhr.responseText;
                                    document.getElementById("console_output").value = data;
                                }
                            };
                            xhr.send(phpdata);
                        }
                    </script>
                </div>
                <?php } if ($profile["change_users"]) { ?>
                <div class="side">
                    <?php                          
                            // GENERATE PROFILE TABLE
                            $tableName = "profile";
                            $columnNames = "[";
                            $columnTypes = "[";

                            echo "<table class='profile-table'><thead><tr><th colspan=\"20\">$lang_users</th></tr><tr>";
                            $columnsQuery = "SHOW COLUMNS FROM $tableName";
                            $columnsResult = $conn->query($columnsQuery);
                            if ($columnsResult->num_rows > 0) {
                                while ($columnRow = $columnsResult->fetch_assoc()) {
                                    $columnName = $columnRow['Field'];

                                    if ($columnName == "change_users")
                                        echo "<th><img class='icon noinvert' src='admin-image/user.png' alt='change_users' title='$lang_users'></th>";
                                    else if ($columnName == "show_logs")
                                        echo "<th><img class='icon noinvert' src='admin-image/history.png' alt='show_logs' title='$lang_history'></th>";
                                    else if ($columnName == "show_files")
                                        echo "<th><img class='icon noinvert' src='admin-image/folder.png' alt='show_files' title='$lang_files'></th>";
                                    else if ($columnName == "show_console")
                                        echo "<th><img class='icon noinvert' src='admin-image/console.png' alt='show_console' title='$lang_console'></th>";
                                    else if ($columnName == "show_tables")
                                        echo "<th><img class='icon noinvert' src='admin-image/database.png' alt='show_tables' title='$lang_db'></th>";
                                    else if ($columnName != "password" && $columnName != "display_name" && $columnName != "icon") {
                                        echo "<th>$columnName</th>";
                                    }

                                    if ($columnName != "ID") {
                                        $columnNames .=  "'" . $columnRow['Field'] . "',";
                                        $columnTypes .= "'" . $columnRow['Type'] . "',";
                                    }
                                }
                                echo "<th><img onclick=\"\" class='icon noinvert' src='admin-image/database-settings.png' alt='$lang_database_settings' title='$lang_database_settings'></th>";
                                $columnNames = rtrim($columnNames, ", ");
                                $columnTypes = rtrim($columnTypes, ", ");
                            } else {
                                echo "Table not have any column!";
                            }
                            $columnNames .= "]";
                            $columnTypes .= "]";
                            echo "<th class=\"icon-cell\"><img class=\"refresh icon noinvert\" src=\"admin-image/refresh.png\" onclick=\"loadData('$tableName')\" alt=\"$lang_refresh\" title=\"$lang_refresh\" draggable=false></th>";
                            echo "<th class=\"icon-cell\"><img src=\"admin-image/add.png\" onclick=\"addeditRow('$tableName', $columnNames, $columnTypes)\" alt=\"$lang_add\" title=\"$lang_add\" class=\"icon noinvert\" draggable=false></th>";
                            echo "</tr></thead><tbody id=\"$tableName\" types=\"$columnTypes\"></tbody></table>";
                ?>
                </div>
                <?php } if ($profile["show_tables"]) { ?>
                <div class="full-side">
                <h3 class="big"><?= $lang_db ?></h3>
                <?php
                    $tablesQuery = "SHOW TABLES";
                    $tablesResult = $conn->query($tablesQuery);


                    $permissionQuery = "SELECT * FROM table_access WHERE profile_id = " . $profile['ID'];
                    $permissionResult = $conn->query($permissionQuery);

                    $is_god = false;
                    $access_arr = array();

                    if ($permissionResult->num_rows > 0) 
                    {
                        while ($columnRow = $permissionResult->fetch_assoc()) 
                        {
                            $is_god = $columnRow["is_god"];
                            $access_arr = json_decode($columnRow["access_arr"]);
                        }
                    }

                    if ($tablesResult->num_rows > 0) {
                        while ($tableRow = $tablesResult->fetch_row()) {
                            $tableName = $tableRow[0];
                            $columnNames = "[";
                            $columnTypes = "[";

                            if (str_contains($tableName, "uploads") || str_contains($tableName, "log") || str_contains($tableName, "profile") || str_contains($tableName, "table_access"))
                                continue;

                            if (!$is_god) 
                            {
                                if (!in_array($tableName, $access_arr))
                                    continue;
                            }

                            echo "<table><thead><tr><th colspan=\"20\">$tableName</th></tr><tr>";
                            $columnsQuery = "SHOW COLUMNS FROM $tableName";
                            $columnsResult = $conn->query($columnsQuery);
                            if ($columnsResult->num_rows > 0) {
                                while ($columnRow = $columnsResult->fetch_assoc()) {
                                    $columnName = $columnRow['Field'];
                                    echo "<th>$columnName</th>";
                                    if ($columnName != "ID") {
                                        $columnNames .=  "'" . $columnRow['Field'] . "',";
                                        $columnTypes .= "'" . $columnRow['Type'] . "',";
                                    }
                                }
                                $columnNames = rtrim($columnNames, ", ");
                                $columnTypes = rtrim($columnTypes, ", ");
                            } else {
                                echo "Table not have any column!";
                            }
                            $columnNames .= "]";
                            $columnTypes .= "]";
                            echo "<th class=\"icon-cell\"><img class=\"refresh icon noinvert\" src=\"admin-image/refresh.png\" onclick=\"loadData('$tableName')\" alt=\"$lang_refresh\" title=\"$lang_refresh\" draggable=false></th>";
                            echo "<th class=\"icon-cell\"><img src=\"admin-image/add.png\" onclick=\"addeditRow('$tableName', $columnNames, $columnTypes)\" alt=\"$lang_add\" title=\"$lang_add\" class=\"icon noinvert\" draggable=false></th>";
                            echo "</tr></thead><tbody id=\"$tableName\" types=\"$columnTypes\"></tbody></table>";
                        }
                    } else {
                        echo "Database not have any table!";
                    }
                ?>
                <?php } ?>
                </div>
            </section>
        </div>
        <dialog id="edit">
            <div class="dialog dialogSmall">
                <h3><?= $lang_edit_data ?></h3>
                <img src="admin-image/close.png" onclick="document.getElementById('edit').close()" alt="<?= $lang_close ?>" title="<?= $lang_close ?>" class="icon" draggable=false><br>
                <data id="edittable" value=""></data>
                <data id="editid" value=""></data>
                <div id="inputContainer"></div>
                <button onclick="saveRow()" class="savebtn"><?= $lang_save ?></button>
            </div>
        </dialog>
        <dialog id="add">
            <div class="dialog dialogSmall">
                <h3><?= $lang_add_data ?></h3>
                <img src="admin-image/close.png" onclick="document.getElementById('add').close()" alt="<?= $lang_close ?>" title="<?= $lang_close ?>" class="icon" draggable=false><br>
                <data id="addtable" value=""></data>
                <div id="addContainer"></div>
                <button onclick="addRow()" class="savebtn"><?= $lang_save ?></button>
            </div>
        </dialog>
        <dialog id="delete" >
            <div class="dialog dialogBig">
                <h3><?= $lang_delete_data ?></h3>
                <button class="savebtn" id="cancelDelete"><?= $lang_no ?></button>
                <button class="savebtn red" id="confirmDelete"><?= $lang_yes ?></button>
            </div>
        </dialog>
        <dialog id="upload">
            <div class="dialog dialogBig">
                <h3><?= $lang_upload_data ?></h3>
                <img src="admin-image/close.png" onclick="document.getElementById('upload').close()" alt="<?= $lang_close ?>" title="<?= $lang_close ?>" class="icon" draggable=false><br>
                <div id="dragfile" class="upload" ondragover="allowDrop(event)" ondrop="drop(event)"><img class="upload" src="admin-image/upload.png"><p><input id="file" type="file"></p></div>
                <button class="savebtn" onclick="saveFileToServer()"><?= $lang_upload ?></button>
            </div>
        </dialog>

        <script>
        const name = "<?= $profile["name"] ?>";
        
        async function loadData(tableName) {
            const tableBody = document.getElementById(tableName);
            tableBody.innerHTML = "";
            const types = tableBody.getAttribute("types");
            const typesText = types.replaceAll("'", "\"");

            const phpdata = new FormData();
            phpdata.append('table', tableName);

            const response = await fetch("command/get.php", {
                method: "POST",
                body: phpdata
            });

            if (!response.ok) {
                console.error("Chyba při načítání dat");
                return;
            }

            const data = await response.json();

            for (const row of data) {
                const newRow = document.createElement("tr");
                let permissionData = "";

                for (const key in row) {
                    if (tableName === "profile" && (key === "password" || key === "display_name" || key === "icon"))
                        continue;

                    if (tableName === "profile" && key === "ID") {
                        permissionData = await get_permissions(row[key]);
                    }

                    let cellText = row[key];
                    if (typeof cellText === "string" && cellText.length > 50) {
                        cellText = cellText.substring(0, 50) + "...";
                    }
                    newRow.innerHTML += `<td>${cellText}</td>`;
                }

                //console.log(permissionData);
                if (permissionData != "")
                    newRow.innerHTML += `<td><img src="admin-image/edit.png" onclick='editRow("table_access", 0, ${permissionData})' alt="edit" title="Edit" class="icon" draggable=false></td>`;
                newRow.innerHTML += `<td><img src="admin-image/edit.png" onclick='editRow("${tableName}", ${row.ID}, ${JSON.stringify(row)}, ${typesText})' alt="edit" title="Edit" class="icon" draggable=false></td>`;
                newRow.innerHTML += `<td><img src="admin-image/delete.png" onclick='deleteRow("${tableName}", ${row.ID})' alt="Delete" title="Delete" class="icon" draggable=false></td>`;
                tableBody.appendChild(newRow);
            }
        }

        function get_permissions(profile_id) {
            return new Promise((resolve, reject) => {
                var phpdata = new FormData();
                phpdata.append('profile_id', profile_id);

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "command/get_access.php", true);
                xhr.onload = function () {
                    if (xhr.status == 200) {
                        resolve(xhr.responseText);
                    } else {
                        reject(new Error("HTTP Chyba: " + xhr.status));
                    }
                }
                xhr.send(phpdata);
            });
        }

        
        function editRow(tableName, id, data, types=[]) {
            var dialog = document.getElementById("edit");
            document.getElementById("edittable").value = tableName;
            document.getElementById("editid").value = id;
            var inputContainer = document.getElementById('inputContainer');

            inputContainer.innerHTML = "";

            var i = -1;
            for (const key in data) {
            if (data.hasOwnProperty(key)) {
                const input = document.createElement('input');

                if (i > -1) {
                    if (types[i].includes("varchar")) {
                        input.type = 'text';
                    } else if (types[i].includes("tinyint")) {
                        input.type = 'checkbox';
                    } else if (types[i].includes("int")) {
                        input.type = 'number';
                    } else if (types[i].includes("date")) {
                        input.type = 'date';
                    } else if (types[i].includes("longblob")) {
                        input.type = 'text';
                        input.disabled = true;
                    } else {
                        input.type = 'text';
                    }
                } else {
                    input.type = 'text';
                }
                i++;

                input.id = `${key}`;
                if (!(tableName == "profile" && key == "password"))
                    input.value = data[key];
                else
                    input.value = "";
                if (input.type == "checkbox") {
                    if (data[key] == "1")
                        input.checked = true;
                }
                if (key === 'ID') {
                    input.disabled = true;
                }
                const label = document.createElement('label');
                label.textContent = key;
                
                inputContainer.appendChild(label);
                inputContainer.appendChild(input);
                inputContainer.appendChild(document.createElement('br'));
                }
            }
            dialog.showModal();
        }

        function openConfirmationDialog() {
            const dialog = document.getElementById("delete");
            dialog.showModal();

            return new Promise((resolve) => {
                document.getElementById("confirmDelete").addEventListener("click", () => {
                dialog.close();
                resolve(true);
                });

                document.getElementById("cancelDelete").addEventListener("click", () => {
                dialog.close();
                resolve(false);
                });
            });
        }

        async function deleteRow(tableName, id) {
            var confirmed = await openConfirmationDialog();

            if (confirmed) {
                var phpdata = new FormData();
                phpdata.append('table', tableName);
                phpdata.append('id', id);

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "command/detele.php", true);
                xhr.send(phpdata);
                setTimeout(() => {
                    loadData(tableName);
                    log("deleted data in table " + tableName + " by " + name);
                }, 500);
            }
        }

        async function saveRow() {
            const inputContainer = document.getElementById('inputContainer');
            const inputs = inputContainer.querySelectorAll('input');
            var access_arr = '[';
            var access_arr2 = '[';

            for (var input of inputs) {
                if (input.id != "ID" && document.getElementById("edittable").value != "table_access") {
                    const id = input.getAttribute('data-id');
                    const value = input.getAttribute('data-value');

                    if ( !(document.getElementById("edittable").value == "profile" && input.id == "password" && (input.value == "" || input.value == null)))
                    {
                        var phpdata = new FormData();
                        phpdata.append('table', document.getElementById("edittable").value);
                        phpdata.append('id', document.getElementById("editid").value);
                        phpdata.append('name', input.id);
                        if (input.getAttribute('type') == "checkbox") {
                            phpdata.append('content', input.checked == true ? "1" : "0");
                        } else 
                        if (document.getElementById("edittable").value == "profile" && input.id == "password")
                        {
                            var hashed_string = await hash_passwd(input.value);
                            phpdata.append('content', hashed_string);
                        }
                        else {
                            phpdata.append('content', input.value);
                        }

                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "command/edit.php", true);
                        xhr.send(phpdata);
                    }
                }
                if (document.getElementById("edittable").value == "table_access") {
                    access_arr += '"' + input.id + '", ';
                    if (input.type == "text")
                        access_arr2 += '"' + input.value + '", ';
                    else
                        access_arr2 += '"' + (input.checked == true ? "1" : "0") + '", ';
                }
            }

            if (document.getElementById("edittable").value == "table_access") {
                var phpdata = new FormData();

                access_arr = access_arr.slice(0, -2) + ']';
                access_arr2 = access_arr2.slice(0, -2) + ']';

                console.log(access_arr);
                console.log(access_arr2);

                phpdata.append('id_arr', access_arr);
                phpdata.append('value_arr', access_arr2);
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "command/set_access.php", true);
                xhr.send(phpdata);
            }

            setTimeout(() => {
                document.getElementById("edit").close();
                if (document.getElementById("edittable").value != "table_access")
                    loadData(document.getElementById("edittable").value);
                log("edited table " + document.getElementById("edittable").value + " by " + name);
            }, 500);
        }

        /*window.onload = function() {
            //loadData("opentable");
        };*/

        function addeditRow(tableName, data, types) {
            var dialog = document.getElementById("add");
            document.getElementById("addtable").value = tableName;
            var addContainer = document.getElementById('addContainer');
            addContainer.innerHTML = "";
            for (let i = 0; i < data.length; i++) {
                const input = document.createElement('input');
                
                if (types[i].includes("tinyint")) {
                    input.type = 'checkbox';
                } else if (types[i].includes("int")) {
                    input.type = 'number';
                } else if (types[i].includes("date")) {
                    input.type = 'date';
                } else if (types[i].includes("longblob")) {
                    input.type = 'file';
                } else {
                    input.type = 'text';
                }

                input.id = `${data[i]}`;
                
                const label = document.createElement('label');
                label.textContent = data[i];
                
                addContainer.appendChild(label);
                addContainer.appendChild(input);
                addContainer.appendChild(document.createElement('br'));
                }
            dialog.showModal();
        }

        async function addRow() {
            const inputContainer = document.getElementById('addContainer');
            const inputs = inputContainer.querySelectorAll('input');
            let names = "(";
            let content = "(";
            for (const input of inputs) {
                if (input.id != "ID"){
                    const id = input.getAttribute('data-id');
                    const value = input.getAttribute('data-value');
                    names += input.id + ", ";

                    if (input.getAttribute('type') == "checkbox") {
                        content += "\"" + (input.checked == true ? "1" : "0")+ "\", ";
                    } else if (input.getAttribute('type') == 'file') {
                        var file1 = input.files[0];
                        const base64 = await getBase64FromFile(file1);
                        content += "\"" + base64 + "\", ";
                    } else 
                    if (input.id == "password" && document.getElementById("addtable").value == "profile")
                    {
                        var hashed_string = await hash_passwd(input.value);
                        content += "\"" + hashed_string + "\", ";
                    } else {
                        content += "\"" + input.value + "\", ";
                    }
                }
            };
            names = names.slice(0, -2);
            content = content.slice(0, -2);
            names += ")";
            content += ")";
            
            var phpdata = new FormData();
            phpdata.append('table', document.getElementById("addtable").value);
            phpdata.append('names', names);
            phpdata.append('content', content);

            //console.log(names);
            //console.log(content);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "command/add.php", true);
            xhr.send(phpdata);
            setTimeout(() => {
                document.getElementById("add").close();
                loadData(document.getElementById("addtable").value);
                log("adden data to table " + document.getElementById("addtable").value + " by " + name);
            }, 500);
        }
        //GET BASE64
        function getBase64FromFile(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onloadend = () => {
                    const base64 = reader.result;
                    resolve(base64);
                };
                reader.onerror = reject;
                reader.readAsDataURL(file);
            });
        }

        //get hash string
        function hash_passwd(passwd) {
            return new Promise((resolve, reject) => {
                var phpdata = new FormData();
                phpdata.append('passwd', passwd);

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "command/hash_passwd.php", true);
                xhr.onload = function () {
                    if (xhr.status == 200) {
                        resolve(xhr.responseText);
                    } else {
                        reject(new Error("HTTP Chyba: " + xhr.status));
                    }
                }
                xhr.send(phpdata);
            });
        }

        //LOAD LOG
        function loadLog() {
            setTimeout(() => {
                var tableBody = document.getElementById('log');
                tableBody.value = "";

                var phpdata = new FormData();
                phpdata.append('table', 'log');

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "command/get.php", true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var data = JSON.parse(xhr.responseText);
                        data.forEach(function(row) {
                            tableBody.value += row["log"] + "\n";
                        });
                    }
                };
                xhr.send(phpdata);
            }, 100);
        }

        function log(event) {
            var phpdata = new FormData();
            phpdata.append('event', event);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "command/log.php", true);
            xhr.send(phpdata);
            loadLog();
        }
        //FILE EXPLORER
        function loadFiles() {
            var tableBody = document.getElementById("fileList");
            tableBody.innerHTML = "";

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "command/list_files.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);
                    data.forEach(function(row) {
                        var newRow = document.createElement("tr");
                        newRow.innerHTML = "<td><a target=\"_blank\"href=\"" + row.link + "\">" + row.name + "</a></td><td>" + row.size + "</td>";
                        newRow.innerHTML += "<td></td>";
                        newRow.innerHTML += "<td><img src=\"admin-image\/delete.png\" onclick=\"deleteFileFromServer(\'" + row.name + "\')\" alt=\"Delete\" title=\"Delete\" class=\"icon\" draggable=false></td>";
                        tableBody.appendChild(newRow);
                    });
                }
            };
            xhr.send();
        }
        //FILE UPLOAD
        function allowDrop(event) {
            event.preventDefault();
            document.getElementById("dragfile").style = "background: #ccc";
        }

        function drop(event) {
            event.preventDefault();
            document.getElementById("dragfile").style = "background: #eee";

            const files = event.dataTransfer.files; 

            if (files.length > 0) {
                const file = files[0];
                const fileInput = document.getElementById("file");
                fileInput.files = files;
                };
            }

        function saveFileToServer() {
            var phpdata = new FormData();
            phpdata.append("fileToUpload", document.getElementById('file').files[0]);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "command/change_file.php", true);
            xhr.send(phpdata);

            setTimeout(() => {
                document.getElementById("upload").close();
                log("uploded file " + document.getElementById('file').files[0].name + " by " + name);
                loadFiles();
            }, 500);
        }
        
        async function deleteFileFromServer(fileName) {
            var confirmed = await openConfirmationDialog();

            if (confirmed) {
                var phpdata = new FormData();
                phpdata.append("deleteFile", fileName); 

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "command/change_file.php", true);
                xhr.send(phpdata);

                setTimeout(() => {
                    document.getElementById("upload").close();
                    log("deleted file " + fileName + " by " + name);
                    loadFiles();
                }, 500);
            }
        }

        window.onload = function() {
            loadLog();
            loadFiles();
        };

        function logout() {

            log(name + " logout");

            const xhttp = new XMLHttpRequest();
            xhttp.open("POST", "demo_phpfile.php");
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("");
            document.location = 'dashboard.php';
        }
        </script>
        <button id="dark-btn" class="dark-btn">
            <img id="light-on" src="admin-image/light-mode.png" draggable=false>
            <img id="dark-on" src="admin-image/dark-mode.png" draggable=false>
        </button>
        <script src="dark-mode.js"></script>
    </body>
</html>
<?php    
        break;
                }
            }
        }
    }
    else {
        header('Location: index.php', true, 307);
    }
    $conn->close();
?>