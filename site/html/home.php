<?php
include ("includes/head.php");
include ("utility/utility.php");
include ("databaseLib/requestsDatabase.php");

$numberOfMessage = numberUnreadMessage($_SESSION['id']);
?>
<div class="row">
    <div>
        <h3>Welcome on the home page. <br/>You have <?= $numberOfMessage ?> unread message</h3>
    </div>
</div>


<?php

include ("includes/foot.php");
?>
