<?php
    include ("utility/utility.php");
    include ("databaseLib/requestsDatabase.php");
    
    if(!isAdmin($_SESSION['id'])) {
        header('location: home.php');
    } else {
        $id = $_GET['id'];

        if(deleteUser($id)) {
            header('location: admin.php');
        } else {
            echo "Error";
        }
    } 
?>