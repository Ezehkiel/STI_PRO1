<?php
include ("includes/head.php");
include ("utility/utility.php");

if (isset($_GET['id'])) {

    $id = htmlspecialchars($_GET['id']);
} else {
    header('location: clients.php');
}
?>


<?php

include ("includes/foot.php");
?>
