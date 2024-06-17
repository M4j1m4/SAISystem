<?php
if (isset($_GET['id'])){
    $id = $_GET['id'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "clbc_users";

    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "DELETE FROM guest WHERE id=$id";
    $connection->query($sql);
}

header('location: /SAISystem/users.php');
exit;
?>