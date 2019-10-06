<?php
    include ("utility/utility.php");
    include ("databaseLib/requestsDatabase.php");

    $id = $_GET['id'];

    if(deleteUser($id)) {
        header('location: admin.php');
    } else {
        echo "Error";
    }
?>