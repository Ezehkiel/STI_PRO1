<?php
// include some scripts for header and functions
include ("includes/head.php");
include ("utility/utility.php");
include ("databaseLib/requestsDatabase.php");

$information = false;

// when the admin click on "Add" button
if(isset($_POST['add_user_form'])) {
    if(isset($_POST['loginNewUser']) && isset($_POST['passwordNewUser']) && isset($_POST['confirmPasswordNewUser'])) { //check if they exist
        if(!empty($_POST['loginNewUser']) && !empty($_POST['passwordNewUser']) && !empty($_POST['confirmPasswordNewUser'])) { //check if they are not empty
            if($_POST['passwordNewUser'] == $_POST['confirmPasswordNewUser']) { //check if two passwords are the same
                $login = $_POST['loginNewUser'];
                $password = $_POST['passwordNewUser'];
                $rule = "";

                if(isset($_POST['adminNewUser'])) {
                    $rule = "administrator";
                } else {
                    $rule = "collaborator";
                }

                if(addUser($login, $password, $rule)) {
                    $information = "New user added.";
                } else {
                    $information = "Error.";
                }
            } else {
                $information = "The two passwords do not match!";
            }
        } else {
            $information = "Missing informations.";
        }
    }
}

?>

<div class="container-fluid">
    <form method="post">
        <p><label>Login : </label><input type="text" name="loginNewUser" placeholder="New login" /></p>
        <p><label>Password : </label><input type="password" name="passwordNewUser" /></p>
        <p><label>Confirm password : </label><input type="password" name="confirmPasswordNewUser" /></p>
        <p><label>Administrator : </label><input type="checkbox" name="adminNewUser" /></p>
        <p><button type="submit" name="add_user_form" class="btn btn-primary">Add user</button></p>

        <?php
            if($information) {
                echo $information;
            }
        ?>
    </form>
</div>

<?php

include ("includes/foot.php");
?>
