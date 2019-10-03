<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

include ("includes/head.php");
include ("utility/utility.php");
include ("databaseLib/requestsDatabase.php");

$id = $_GET['id'];
?>

<div class="container-fluid">
    <form method="post" action="">
        <?php
            $user_info = getUser($id);
            //print_r($user_info);

            $checked_admin = "";
            $checked_valid = "";

            if($user_info['admin'] == "administrator") {
                $checked_admin = "checked";
            }

            if($user_info['validite'] == 1) {
                $checked_valid = "checked";
            }

            echo '<p><label>Login : </label><input type="text" name="loginUser" value="'.$user_info['login'].'" readonly/></p>';
            echo '<p><label>Old password : </label><input type="password" name="oldPasswordUser" /></p>';
            echo '<p><label>New password : </label><input type="password" name="newPasswordUser" /></p>';
            echo '<p><label>Confirm password : </label><input type="password" name="passwordUserVerif" /></p>';
            echo '<p><label>Administrator : </label><input type="checkbox" name="newAdminUser" '.$checked_admin.'/></p>';
            echo '<p><label>Validity : </label><input type="checkbox" name="newValidity" '.$checked_valid.'/></p>';
            echo '<p><button type="submit" name="update_user_form" class="btn btn-primary">Modify user</button></p>';

            if(isset($_POST['update_user_form'])) {        
                $newPassword = $user_info['password'];
                $newIsAdmin = $user_info['admin'];
                $newValidity = $user_info['validite'];

                if(isset($_POST['oldPasswordUser']) && $_POST['oldPasswordUser'] == $newPassword) {
                    if(isset($_POST['newPasswordUser']) && isset($_POST['passwordUserVerif']) && $_POST['newPasswordUser'] == $_POST['passwordUserVerif']) {
                        $newPassword = $_POST['newPasswordUser'];
                    }
                }

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

                if(updateUser($newPassword, $newIsAdmin, $newValidity, $id)) {
                    echo "User updated.";
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