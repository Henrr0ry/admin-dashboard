<?php
include "connect.php";

try {

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"]) && isset($_POST["passwd"]) && isset($_POST["command"])) {
    $profiles = $conn->query("SELECT name, password FROM profile");
    if ($profiles->num_rows > 0) {
        while($profile = $profiles->fetch_assoc()) {
            if (strcmp($_POST["name"], $profile["name"]) == 0 && password_verify($_POST["passwd"], $profile["password"])) {

                    $sql = $_POST["command"];
                    $dataResult = $conn->query($sql);

                    if ($dataResult instanceof mysqli_result) {
                        print_sql_result_as_table($dataResult);
                    } elseif ($dataResult === true) {
                        echo "Query OK, " . $conn->affected_rows . " rows affected\n";
                    } else {
                        echo "SQL Error: " . $conn->error . "\n";
                    }
                
            }
        }
    }
}
$conn->close();
}
catch(Exception $e) {
    echo "SQL Syntax Error";
}


function print_sql_result_as_table(mysqli_result $result): void {
    // Získání názvů sloupců
    $fields = $result->fetch_fields();
    $headers = [];
    $widths = [];

    foreach ($fields as $field) {
        $headers[] = $field->name;
        $widths[] = strlen($field->name);
    }

    // Získání všech řádků a výpočet max šířky sloupců
    $rows = [];
    while ($row = $result->fetch_row()) {
        $rows[] = $row;
        foreach ($row as $i => $value) {
            $valueLength = strlen((string)$value);
            if ($valueLength > $widths[$i]) {
                $widths[$i] = $valueLength;
            }
        }
    }

    // Funkce pro tisk oddělovací čáry
    $print_separator = function () use ($widths) {
        echo "+";
        foreach ($widths as $w) {
            echo str_repeat("-", $w + 2) . "+";
        }
        echo "\n";
    };

    // Tisk hlavičky
    $print_separator();
    echo "|";
    foreach ($headers as $i => $header) {
        echo " " . str_pad($header, $widths[$i]) . " |";
    }
    echo "\n";
    $print_separator();

    // Tisk dat
    foreach ($rows as $row) {
        echo "|";
        foreach ($row as $i => $value) {
            echo " " . str_pad((string)$value, $widths[$i]) . " |";
        }
        echo "\n";
    }

    // Konec tabulky
    $print_separator();
}

?>