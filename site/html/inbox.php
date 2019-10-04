<?php
include ("includes/head.php");
include ("utility/utility.php");
include ("databaseLib/requestsDatabase.php");

$mails = fetchMessage($_SESSION['id']);
$deleteOk = true;

if (isset($_GET['delete'])){
    $messageToDelete = htmlspecialchars($_GET['delete']);
    $deleteOk = deleteMessage($messageToDelete);

    if($deleteOk){
        header("Refresh:0; url=inbox.php");
    }
}
if(isset($_GET['read'])){
    $messageToRead = htmlspecialchars($_GET['read']);
    setStateMessage($messageToRead, 1);
    header("Refresh:0; url=inbox.php");
}

if(isset($_GET['unread'])){
    $messageToUnread = htmlspecialchars($_GET['unread']);
    setStateMessage($messageToUnread, 0);
    header("Refresh:0; url=inbox.php");

}

?>


<div class="container-fluid">
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
            foreach ($mails as $mail) {
                echo '<tr' . ($mail['lu'] ? ' class="table-active"' : '') . '>';
                echo '<td>' . getUsername($mail['id_expediteur']) . '</td>';
                echo '<td>' . $mail['sujet'] . '</td>';
                echo '<td>' . $mail['date_reception'] . '</td>';
                echo '<td>
                        <a title="Reply" href="./newMessage.php?idMessage=' .$mail['id_message'] . '"><i class="fas fa-reply"></i></a> 
                        <i class="fas fa-plus"></i> 
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
