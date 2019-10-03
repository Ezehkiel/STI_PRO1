<?php
include ("includes/head.php");
include ("utility/utility.php");
include ("databaseLib/requestsDatabase.php");

$users = getAllUsers(); //get all users in database
?>

<div class="container-fluid">
    <form method="post" action="addUser.php">
        <p><button type="submit" name="add_user" class="btn btn-primary">Add user</button></p>
    </form>
    <div class="row">
<!--        <form method="post">-->
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Login</th>
                    <th scope="col">Role</th>
                    <th scope="col">Is active</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                // display all users
                foreach ($users as $user) {
                    echo '<tr>';
                    echo '<td>' . $user['login'] . '</td>';
                    echo '<td>' . $user['admin'] . '</td>';
                    echo '<td><i class="fas fa-' . ($user['validite'] ? 'check' : 'time') . '"></td>';

                    // to avoid display actions buttons for connected user
                    if($user['id_user'] != $_SESSION['id']) {
                        echo '<td><a class="button button-action" href="./modifyUser.php?id=' . $user['id_user'] . '"><i class="fas fa-pen"></i></a>  <a class="button button-action"  href="./deleteUser.php?id=' . $user['id_user'] . '"><i class="fas fa-times"></i></a> </td>';
                    }
            
                    echo '<tr>';
                }
                ?>
                </tbody>
            </table>
<!--        </form>-->
    </div>
</div>

<!--<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete user</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this user ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Delete user</button>
            </div>
        </div>
    </div>
</div>-->

<?php

include ("includes/foot.php");
?>
