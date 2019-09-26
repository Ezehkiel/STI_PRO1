<?php
include("includes/head.php");
include ("databaseLib/requestsDatabase.php");
include ("utility/utility.php");

if (isset($_POST['password']) && isset($_POST['username']) ) {
    if ($_POST['password'] != "" && $_POST['username'] != "" && checkLogin( $_POST['username'], $_POST['password'])) {
        $_SESSION['connecte'] = true;
    } else {
        echo "Invalide password or username";
    }

}

if (isset($_SESSION['connecte']))
    header('location: home.php');
?>

Welcome on this site. This is the first version of the login page.
<div>
    <form action="login.php" method="post">
        <div>
            <label for="usernameField">Username:</label>
            <input id="usernameField" type="text" name="username">
            <label for="passwordField">Password:</label>
            <input id="passwordField" type="password" name="password"/>
        </div>
        <div>
            <button type="submit">Se connecter</button>
        </div>
    </form>
</div>

<?php

include("includes/foot.php");

?>

