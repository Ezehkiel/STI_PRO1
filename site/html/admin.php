<?php
include ("includes/head.php");
include ("utility/utility.php");
include ("databaseLib/requestsDatabase.php");

$users = getAllUsers();
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
                foreach ($users as $user) {
                    echo '<tr>';
                    echo '<td>' . $user['login'] . '</td>';
                    echo '<td>' . $user['admin'] . '</td>';
                    echo '<td><i class="fas fa-' . ($user['validite'] ? 'check' : 'time') . '"></td>';
                    echo '<td><a class="button button-action" href="./info_user.php?id=' . $user['id'] . '"><i class="fas fa-pen"></i></a>  <a class="button button-action" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-times"></i></a> </td>';
                    echo '<tr>';
                }
                ?>
                </tbody>
            </table>
<!--        </form>-->
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this user ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<?php

include ("includes/foot.php");
?>
