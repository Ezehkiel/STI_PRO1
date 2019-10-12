<?php
include ("includes/head.php");
include ("utility/utility.php");
include ("databaseLib/requestsDatabase.php");
$users = getAllUsers();
$error = false;

// When we respond to a message we git the id of the message
if(isset($_GET['idMessage'])){

    $messageId = htmlspecialchars($_GET['idMessage']);
    $message = getMessage($messageId);
    setStateMessage($messageId, 1);

}

if (isset($_POST['destinataire']) && isset($_POST['object']) && isset($_POST['message'])) {
    if(!empty($_POST['destinataire']) && !empty($_POST['object']) && !empty($_POST['message'])){ //Check if all field are inform
        if(!addMessage(date("Y-m-d H:i:s"), $_SESSION['id'], $_POST['destinataire'], $_POST['object'], $_POST['message'])){ // Add message to db
            $statusMessage = "<h4>An error occurred, your message can't be delivered</h4>";
        }else{
            $statusMessage = "<h4>Your message have been send</h4>";
        }
    }else{
        $statusMessage = "<h4>Informations are missing</h4>";
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <h1 class="col-4"><u>New message</u></h1>
    </div>
        <form method="post">
            <div class="form-group">
                <label for="destinataire">Destinataire</label>
                <select class="form-control" id="destinataire" name="destinataire">
                    <?php
                    // We create the list of user. If it's a response we select the sender of the initial message
                    foreach ($users as $user){
                        $selected = false;
                        if($user['id_user'] == $message['id_sender']){
                            $selected = true;
                        }
                        echo '<option value="' . $user['id_user'] . '" '. ($selected ? 'selected' : '').'>'. $user['login'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="object">Objet</label>
                <input type="text" class="form-control" id="object" name="object" value="<?= ($message ?  "RE: " .$message['object'] : "")  ?>">
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" rows="9" name="message"><?php if ($message) {$body = "\n\n\n------------Previous message------------\n\n"; } else {$body = "";} $textBody = $body . ' ' . $message['message']; echo $textBody;?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
            <a href="./home.php" class="btn btn-secondary">Back</a>
        </form>
        <?php
        if ($statusMessage){
            echo $statusMessage;
        }
        ?>
</div>

<?php

include ("includes/foot.php");
?>
