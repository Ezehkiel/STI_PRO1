<?php
include ("includes/head.php");
include ("utility/utility.php");
include ("databaseLib/requestsDatabase.php");

?>

<div class="container-fluid">
    <form method="post" action="">
        <p><label>Login : </label><input type="text" name="loginNewUser" placeholder="New login" /></p>
        <p><label>Password : </label><input type="password" name="passwordNewUser" /></p>
        <p><label>Administrator : </label><input type="checkbox" name="adminNewUser" /></p>
        <p><button type="submit" name="add_user_form" class="btn btn-primary">Add user</button></p>

        <?php
            if(isset($_POST['add_user_form'])) {
                $login = $_POST['loginNewUser'];
                $password = $_POST['passwordNewUser'];
                $rule = "";

                if(isset($_POST['adminNewUser'])) {
                    $rule = "admin";
                } else {
                    $rule = "collab";
                }

                if(addUser($login, $password, $rule)) {
                    echo "New user added.";
                } else {
                    echo "Error.";
                }
            }
        ?>
    </form>
</div>

<?php

include ("includes/foot.php");
?>
