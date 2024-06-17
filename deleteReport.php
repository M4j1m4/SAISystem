<?php
if (isset($_GET['id'])){
    $id = $_GET['id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "clbc_inventory";

    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "DELETE FROM sales_report WHERE id=$id";
    $connection->query($sql);
}

header('location: /SAISystem/salesreport.php');
exit;
?>