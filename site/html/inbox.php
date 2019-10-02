<?php
include ("includes/head.php");
include ("utility/utility.php");
include ("databaseLib/requestsDatabase.php");

$mails = fetchMessage($_SESSION['id']);

if (isset($_GET['delete'])){
    $messageToDelete = htmlspecialchars($_GET['delete']);
    $error = deleteMessage($messageToDelete);

    header("Refresh:0; url=inbox.php");
}

?>


<div class="container-fluid">
    <div class="row">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Expediteur</th>
                <th scope="col">Object</th>
                <th scope="col">Date de reception</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($mails as $mail) {
                echo '<tr>';
                echo '<td>' . getUsername($mail['id_expediteur']) . '</td>';
                echo '<td>' . $mail['sujet'] . '</td>';
                echo '<td>' . $mail['date_reception'] . '</td>';
                echo '<td><a href="./newMessage.php?idMessage=' .$mail['id_message'] . '"><i class="fas fa-reply"></i></a> 
                        <i class="fas fa-plus"></i> <a href="./inbox.php?delete=' . $mail['id_message'] .'"><i class="fas fa-trash-alt"></i></a> </td>';

               // echo '<td><a class="button button-action" href="./info_user.php?id=' . $mail['id'] . '"><i class="fas fa-pen"></i></a>  <a class="button button-action" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-times"></i></a> </td>';
                echo '<tr>';
            }
            ?>
            </tbody>
        </table>
    </div>

</div>

<?php

include ("includes/foot.php");
?>
