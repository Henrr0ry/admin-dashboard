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
                <?php if ($profile["files"]) { ?>
                <div class="side">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="20"><?= $lang_files ?></th>
                            </tr>
                            <tr>
                                <th><?= $lang_file_name ?></th>
                                <th><?= $lang_size ?></th>
                                <th class="icon-cell"><img class="refresh" src="admin-image/refresh.png" onclick="loadFiles()" alt="<?= $lang_refresh ?>" title="<?= $lang_refresh ?>" draggable=false></th>
                                <th class="icon-cell"><img src="admin-image/upload.png" onclick='document.getElementById("upload").showModal();' alt="<?= $lang_upload ?>" title="<?= $lang_upload ?>" draggable=false></th>
                            </tr>
                        </thead>
                        <tbody id="fileList">
                        </tbody>
                    </table>
                </div>
                <?php } if ($profile["logs"]) { ?>
                <div class="side">
                    <table>
                        <thead>
                            <tr>
                                <th><?= $lang_history ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <textarea id="log" disabled></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php } if ($profile["analytics"]) { ?>
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th><?= $lang_analytics ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <textareadisabled></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php } if ($profile["tables"]) { ?>
                <h3 class="big"><?= $lang_db ?></h3>
                <?php
                    $tablesQuery = "SHOW TABLES";
                    $tablesResult = $conn->query($tablesQuery);

                    if ($tablesResult->num_rows > 0) {
                        while ($tableRow = $tablesResult->fetch_row()) {
                            $tableName = $tableRow[0];
                            $columnNames= "[";

                            if (str_contains($tableName, "uploads") || str_contains($tableName, "log") || str_contains($tableName, "profile") || str_contains($tableName, "analytics"))
                                continue;

                            echo "<table><thead><tr><th colspan=\"20\">$tableName</th></tr><tr>";
                            $columnsQuery = "SHOW COLUMNS FROM $tableName";
                            $columnsResult = $conn->query($columnsQuery);
                            if ($columnsResult->num_rows > 0) {
                                while ($columnRow = $columnsResult->fetch_assoc()) {
                                    $columnName = $columnRow['Field'];
                                    echo "<th>$columnName</th>";
                                    if ($columnName != "ID")
                                        $columnNames .=  "'" . $columnRow['Field'] . "',";
                                }
                                $columnNames = rtrim($columnNames, ", ");
                            } else {
                                echo "Table not have any column!";
                            }
                            $columnNames .= "]";
                            echo "<th class=\"icon-cell\"><img class=\"refresh\" src=\"admin-image/refresh.png\" onclick=\"loadData('$tableName')\" alt=\"$lang_refresh\" title=\"$lang_refresh\" draggable=false></th>";
                            echo "<th class=\"icon-cell\"><img src=\"admin-image/add.png\" onclick=\"addeditRow('$tableName', $columnNames)\" alt=\"$lang_add\" title=\"$lang_add\" draggable=false></th>";
                            echo "</tr></thead><tbody id=\"$tableName\"></tbody></table>";
                        }
                    } else {
                        echo "Database not have any table!";
                    }
                ?>
                <?php } ?>
            </section>
        </div>
        <dialog id="edit">
            <div class="dialog">
                <h3><?= $lang_edit_data ?></h3>
                <img src="admin-image/close.png" onclick="document.getElementById('edit').close()" alt="<?= $lang_close ?>" title="<?= $lang_close ?>" draggable=false><br>
                <data id="edittable" value=""></data>
                <data id="editid" value=""></data>
                <div id="inputContainer"></div>
                <button onclick="saveRow()" class="savebtn"><?= $lang_save ?></button> <br> <br> <br>
            </div>
        </dialog>
        <dialog id="add">
            <div class="dialog">
                <h3><?= $lang_add_data ?></h3>
                <img src="admin-image/close.png" onclick="document.getElementById('add').close()" alt="<?= $lang_close ?>" title="<?= $lang_close ?>" draggable=false><br>
                <data id="addtable" value=""></data>
                <div id="addContainer"></div>
                <button onclick="addRow()" class="savebtn"><?= $lang_save ?></button> <br> <br> <br>
            </div>
        </dialog>
        <dialog id="delete" >
            <div class="dialog">
                <h3><?= $lang_delete_data ?></h3>
                <button class="savebtn" id="cancelDelete"><?= $lang_no ?></button>
                <button class="savebtn red" id="confirmDelete"><?= $lang_yes ?></button> <br> <br> <br> <br> <br> <br> <br>
            </div>
        </dialog>
        <dialog id="upload">
            <div class="dialog">
                <h3><?= $lang_upload_data ?></h3>
                <img src="admin-image/close.png" onclick="document.getElementById('upload').close()" alt="<?= $lang_close ?>" title="<?= $lang_close ?>" draggable=false><br>
                <div id="dragfile" class="upload" ondragover="allowDrop(event)" ondrop="drop(event)"><img class="upload" src="admin-image/upload.png"><p><input id="file" type="file"></p></div>
                <button class="savebtn" onclick="saveFileToServer()"><?= $lang_upload ?></button> <br> <br> <br>
            </div>
        </dialog>
        <script>
        
        const name = "<?= $profile["name"] ?>";
        
        function loadData(tableName) {
            var tableBody = document.getElementById(tableName);
            tableBody.innerHTML = "";

            var phpdata = new FormData();
            phpdata.append('table', tableName);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "command/get.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);
                    data.forEach(function(row) {
                        var newRow = document.createElement("tr");
                        for (var key in row) {
                            newRow.innerHTML += "<td>" + row[key] + "</td>";
                        }
                        newRow.innerHTML += "<td><img src=\"admin-image\/edit.png\" onclick='editRow(\"" + tableName + "\"," + row.ID + ", " + JSON.stringify(row) + ")' alt=\"edit\" title=\"Edit\" draggable=false></td>";
                        newRow.innerHTML += "<td><img src=\"admin-image\/delete.png\" onclick='deleteRow(\"" + tableName + "\", " + row.ID + ")' alt=\"Delete\" title=\"Delete\" draggable=false></td>";
                        tableBody.appendChild(newRow);
                    });
                }
            };
            xhr.send(phpdata);
        }
        
        function editRow(tableName, id, data) {
            var dialog = document.getElementById("edit");
            document.getElementById("edittable").value = tableName;
            document.getElementById("editid").value = id;
            var inputContainer = document.getElementById('inputContainer');

            inputContainer.innerHTML = "";
            for (const key in data) {
            if (data.hasOwnProperty(key)) {
                const input = document.createElement('input');
                input.type = 'text';
                input.id = `${key}`;
                input.value = data[key];
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

        function saveRow() {
            const inputContainer = document.getElementById('inputContainer');
            const inputs = inputContainer.querySelectorAll('input');

            inputs.forEach(input => {
                if (input.id != "ID") {
                    const id = input.getAttribute('data-id');
                    const value = input.getAttribute('data-value');


                    var phpdata = new FormData();
                    phpdata.append('table', document.getElementById("edittable").value);
                    phpdata.append('id', document.getElementById("editid").value);
                    phpdata.append('name', input.id);
                    phpdata.append('content', input.value);

                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "command/edit.php", true);
                    xhr.send(phpdata);
                }
            });
            setTimeout(() => {
                document.getElementById("edit").close();
                loadData(document.getElementById("edittable").value);
                log("edited table " + document.getElementById("edittable").value + " by " + name);
            }, 500);
        }

        window.onload = function() {
            //loadData("opentable");
        };

        function addeditRow(tableName, data) {
            var dialog = document.getElementById("add");
            document.getElementById("addtable").value = tableName;
            var addContainer = document.getElementById('addContainer');
            addContainer.innerHTML = "";
            for (let i = 0; i < data.length; i++) {
                const input = document.createElement('input');
                input.type = 'text';
                input.id = `${data[i]}`;
                
                const label = document.createElement('label');
                label.textContent = data[i];
                
                addContainer.appendChild(label);
                addContainer.appendChild(input);
                addContainer.appendChild(document.createElement('br'));
                }
            if (tableName == "profile") {
                const input = document.createElement('input');
                input.type = 'text';
                input.id = "password";
                
                const label = document.createElement('label');
                label.textContent = "password";
                
                addContainer.appendChild(label);
                addContainer.appendChild(input);
                addContainer.appendChild(document.createElement('br'));
            }
            dialog.showModal();
        }

        function addRow() {
            const inputContainer = document.getElementById('addContainer');
            const inputs = inputContainer.querySelectorAll('input');
            let names = "(";
            let content = "(";
            inputs.forEach(input => {
                if (input.id != "ID"){
                    const id = input.getAttribute('data-id');
                    const value = input.getAttribute('data-value');
                    names += input.id + ", ";
                    content += "\"" + input.value + "\", ";
                }
            });
            names = names.slice(0, -2);
            content = content.slice(0, -2);
            names += ")";
            content += ")";
            
            var phpdata = new FormData();
            phpdata.append('table', document.getElementById("addtable").value);
            phpdata.append('names', names);
            phpdata.append('content', content);

            console.log(names);
            console.log(content);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "command/add.php", true);
            xhr.send(phpdata);
            setTimeout(() => {
                document.getElementById("add").close();
                loadData(document.getElementById("addtable").value);
                log("adden data to table " + document.getElementById("addtable").value + " " + content + " by " + name);
            }, 500);
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
                        newRow.innerHTML += "<td><img src=\"admin-image\/delete.png\" onclick=\"deleteFileFromServer(\'" + row.name + "\')\" alt=\"Delete\" title=\"Delete\" draggable=false></td>";
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