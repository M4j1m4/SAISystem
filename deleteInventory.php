<?php
if (isset($_GET['id'])){
    $id = $_GET['id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "clbc_inventory";

    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "DELETE FROM inventory_data WHERE id=$id";
    $connection->query($sql);
}

header('location: /SAISystem/home.php');
exit;
?>