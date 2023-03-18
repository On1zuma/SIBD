<?php

class DataController
{
    public function __construct()
    {
    }

    public function listOurTables()
    {
        $table_name = $_SESSION['id']['table'];
        $bdd = new PDO('mysql:host=localhost;dbname=gamedb;charset=utf8;', 'root', '');

        if ($table_name != "*") {
            $tables = explode(", ", $table_name);
        } else {
            $stmt = $bdd->prepare("SHOW TABLES");
            $stmt->execute();
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        }
        return $tables;
    }

    public function checkIfUserCanAccessTable()
    {
        $bdd = new PDO('mysql:host=localhost;dbname=gamedb;charset=utf8;', 'root', '');

        $table_name = $_SESSION['id']['table']; // users tables
        $tableUrl = $_GET['table']; // table set in the url
        $stmt = $bdd->prepare("SHOW TABLES");
        $stmt->execute();
        $tablesBd = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $tableUrlWithSpaces = str_replace('_', ' ', $tableUrl);

        // Check if the table exists in the database
        if (!in_array($tableUrl, $tablesBd)) {
            header('Location: 404.php');
            exit; // stop the script
        }

        // Check if the user has access to the table
        if ($table_name != "*" && !in_array($tableUrl, explode(", ", $table_name))) {
            header('Location: list-table.php');
            exit; // stop the script
        }
        return $tableUrl;
    }

    public function listOfTableName($tableUrl)
    {
        $bdd = new PDO('mysql:host=localhost;dbname=gamedb;charset=utf8;', 'root', '');
        // Get the column names for a table
        $tableName = $tableUrl;
        $stmt = $bdd->query("DESCRIBE $tableName");
        $columns = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $columns[] = $row['Field'];
        }

        // Print the column names
        return $columns;
    }

    public function listOfRowName($tableUrl)
    {
        $bdd = new PDO('mysql:host=localhost;dbname=gamedb;charset=utf8;', 'root', '');
        $tableName = $tableUrl;
        $stmt = $bdd->query("SELECT * FROM $tableName");
        $rows = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rows[] = $row;
        }
        return $rows;
    }
}
