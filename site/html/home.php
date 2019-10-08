<?php
include ("includes/head.php");
include ("utility/utility.php");
include ("databaseLib/requestsDatabase.php");

$numberOfMessage = numberUnreadMessage($_SESSION['id']);
?>

Welcome on the home page
You have <?= $numberOfMessage ?> unread message

<?php

include ("includes/foot.php");
?>
