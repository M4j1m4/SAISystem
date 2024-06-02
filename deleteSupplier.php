<?php
if (isset($_GET['id'])){
    $id = $_GET['id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "clbc_suppliers";

    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "DELETE FROM supplier_data WHERE id=$id";
    $connection->query($sql);
}

header('location: /SAISystem/supplier.php');
exit;
?>