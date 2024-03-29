<?php
include ("databaseLib/requestsDatabase.php");
include ("utility/utility.php");
session_start();

if (isset($_POST['password']) && isset($_POST['username']) ) {
    if ($_POST['password'] != "" && $_POST['username'] != "" && checkLogin( $_POST['username'], $_POST['password']) && checkIfValid($_POST['username'])) {
        $_SESSION['connecte'] = true;
        $_SESSION['id'] = getId($_POST['username']);
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['isAdmin'] = isAdmin($_SESSION['id']);
    } else {
        $error = true;
    }

}

if (isset($_SESSION['connecte']))
    header('location: home.php');
?>


<!DOCTYPE html>
<html>
<head>
    <title>WebMessenger: login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>WebMessenger</h1>
    <form method="post">
        <div class="form-group">
            <label for="loginField">Login</label>
            <input type="text" class="form-control" id="loginField" name="username">
        </div>
        <div class="form-group">
            <label for="passwordField">Password</label>
            <input type="password" class="form-control" id="passwordField" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <?php
        if($error) {
            echo "Login or password incorrect. Try again.";
        }
    ?>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>

<?php

include("includes/foot.php");

?>

