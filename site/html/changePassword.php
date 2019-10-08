<?php
include ("includes/head.php");
include ("utility/utility.php");
include ("databaseLib/requestsDatabase.php");

$id = $_SESSION['id'];

$user_info = getUser($id);

$information = false;

if(isset($_POST['update_password_form'])) { 
    if(isset($_POST['oldPassword']) && isset($_POST['newPassword']) && isset($_POST['newPasswordConfirm'])) { // check if they exist
        // if fields are not empty
        if(!empty($_POST['oldPassword']) && !empty($_POST['newPassword']) && !empty($_POST['newPasswordConfirm'])) {
            // if new password and confirm password match and old input password and old password in database match
            if(($_POST['newPassword'] == $_POST['newPasswordConfirm']) && ($_POST['oldPassword']) == $user_info['password']) {
                $newPassword = $_POST['newPassword'];

                // call the function to execute UPDATE sql in users table
                if(updatePassword($id, $newPassword)) {
                    header('location: logout.php');
                } else {
                    $information = "Error.";
                }
            } else {
                $information = "Passwords do not match.";
            }
        } else {
            $information = "Missing informations.";
        }
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <h1 class="col-4"><u>Change password</u></h1>
    </div>
    <form method="post">
        <p><label>Old password : </label><input type="password" name="oldPassword" /></p>
        <p><label>New password : </label><input type="password" name="newPassword" /></p>
        <p><label>Confirm password : </label><input type="password" name="newPasswordConfirm" /></p>
        <p><button type="submit" name="update_password_form" class="btn btn-primary">Change password</button></p>

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