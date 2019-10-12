<?php
include ("includes/head.php");
include ("utility/utility.php");
include ("databaseLib/requestsDatabase.php");

$mails = fetchMessage($_SESSION['id']);
$deleteOk = true;

// If we ask for a delete, we get the id, delete the message and refresh the page
if (isset($_GET['delete'])){
    $messageToDelete = htmlspecialchars($_GET['delete']);
    $deleteOk = deleteMessage($messageToDelete);

    if($deleteOk){
        header("Refresh:0; url=inbox.php");
    }
}
// If we read a message we take the id and ask to the db to change the state
if(isset($_GET['read'])){
    $messageToRead = htmlspecialchars($_GET['read']);
    setStateMessage($messageToRead, 1);
    header("Refresh:0; url=inbox.php");
}

// If we unread a message we take the id and ask to the db to change the state
if(isset($_GET['unread'])){
    $messageToUnread = htmlspecialchars($_GET['unread']);
    setStateMessage($messageToUnread, 0);
    header("Refresh:0; url=inbox.php");

}

?>
<div class="container-fluid">
    <div class="row">
        <h1 class="col-4"><u>Mailbox</u></h1>
    </div>
    <div class="row">
        <p class="col-1"><a href="./home.php" class="btn btn-secondary">Back</a></p>
    </div>
    <div class="row">
        <?php
        if (!$deleteOk){
            echo "<h4>Unable to delete this message</h4>";
        }
        ?>
        <table class="table">
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
            // Display all messages with action
            foreach ($mails as $mail) {
                echo '<tr' . ($mail['read'] ? ' class="table-active"' : '') . '>';
                echo '<td>' . getUsername($mail['id_sender']) . '</td>';
                echo '<td>' . $mail['object'] . '</td>';
                echo '<td>' . $mail['utc_date'] . '</td>';
                echo '<td>
                        <a title="Reply" href="./newMessage.php?idMessage=' .$mail['id_message'] . '"><i class="fas fa-reply"></i></a> 
                        <a title="Show details" href="./showMessage.php?idMessage=' .$mail['id_message'] . '"><i class="fas fa-plus"></i></a>
                        <a title="Delete message" href="./inbox.php?delete=' . $mail['id_message'] .'"><i class="fas fa-trash-alt"></i></a> 
                        <a title="Mark as read" href="./inbox.php?read=' . $mail['id_message'] .'"><i class="fas fa-envelope-open"></i></a>
                        <a title="Mark as unread" href="./inbox.php?unread=' . $mail['id_message'] .'"><i class="fas fa-envelope"></i></a> </td>';

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
