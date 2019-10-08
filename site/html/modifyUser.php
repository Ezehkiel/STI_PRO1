<?php
include ("includes/head.php");
include ("utility/utility.php");
include ("databaseLib/requestsDatabase.php");

checkIfAdmin($_SESSION['id']);

$id = $_GET['id']; //get id in URL

$user_info = getUser($id); //get user

$checked_admin = "";
$checked_valid = "";

// to for the checkboxes
if($user_info['admin'] == "administrator") {
    $checked_admin = "checked";
}

if($user_info['validite'] == 1) {
    $checked_valid = "checked";
}

$information = false;
$execute_update = false;

// when admin click on update button
if(isset($_POST['update_user_form'])) { 
    if(isset($_POST['newPasswordUser']) && isset($_POST['passwordUserVerif'])) { // check if they exist
       
        // check if checkboxes are checked
        if(isset($_POST['newAdminUser'])) {
            $newIsAdmin = "administrator";
        } else {
            $newIsAdmin = "collaborator";
        }
    
        if(isset($_POST['newValidity'])) {
            $newValidity = 1;
        } else {
            $newValidity = 0;
        }
        
        // if password fields are not empty
        if(!empty($_POST['newPasswordUser']) && !empty($_POST['passwordUserVerif'])) {
            // if new password is not equal to actual password
            if($_POST['newPasswordUser'] != $user_info['password']) {
                // if new password and confirm password match and old input password and old password in database match
                if(($_POST['newPasswordUser'] == $_POST['passwordUserVerif'])) {
                    $newPassword = $_POST['newPasswordUser'];

                    $execute_update = true;
                } else {
                    $information = "Passwords do not match.";
                }
            } else {
                $information = "New password cannot be the actually one.";
            }
        } else {
            $newPassword = $user_info['password'];

            $execute_update = true;
        }

        // call the function to execute UPDATE sql in users table
        if($execute_update) {
            if(updateUser($newPassword, $newIsAdmin, $newValidity, $id)) {
                $information = "User updated.";
            } else {
                $information = "Error.";
            }
        }
    }
}
?>

<div class="container-fluid">
    <form method="post">
        <p><label>Login : </label><input type="text" name="loginUser" value="<?=$user_info['login'];?>" readonly/></p>
        <p><label>New password : </label><input type="password" name="newPasswordUser" /></p>
        <p><label>Confirm password : </label><input type="password" name="passwordUserVerif" /></p>
        <p><label>Administrator : </label><input type="checkbox" name="newAdminUser" <?=$checked_admin;?>/></p>
        <p><label>Validity : </label><input type="checkbox" name="newValidity" <?=$checked_valid;?>/></p>
        <p><button type="submit" name="update_user_form" class="btn btn-primary">Modify user</button></p>

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