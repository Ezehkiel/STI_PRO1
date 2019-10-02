<?php
include ("includes/head.php");
include ("utility/utility.php");
include ("databaseLib/requestsDatabase.php");
$users = getAllUser();
$error = false;

if(isset($_GET['idMessage'])){

    $messageId = htmlspecialchars($_GET['idMessage']);
    $message = getMessage($messageId);

}

if (isset($_POST['destinataire']) && isset($_POST['sujet']) && isset($_POST['message'])) {
    if(!empty($_POST['destinataire']) && !empty($_POST['sujet']) && !empty($_POST['message'])){
        addMessage($_SESSION['id'], $_POST['destinataire'], $_POST['sujet'], $_POST['message']);
    }else{
        $error = "Informations are missing";
    }
}
?>

<div class="container-fluid">
        <form method="post">
            <div class="form-group">
                <label for="destinataire">Destinataire</label>
                <select class="form-control" id="destinataire" name="destinataire">
                    <?php
                    foreach ($users as $user){
                        $selected = false;
                        if($user['id_user'] == $message['id_expediteur']){
                            $selected = true;
                        }
                        echo '<option value="' . $user['id_user'] . '" '. ($selected ? 'selected' : '').'>'. $user['login'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="sujet">Objet</label>
                <input type="text" class="form-control" id="sujet" name="sujet" value="<?= ($message ?  "RE: " .$message['sujet'] : "")  ?>">
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" rows="9" name="message"><?php if ($message) {$body = "\n\n\n------------------\n\n"; } else {$body = "";} $textBody = $body . ' ' . $message['message']; echo $textBody;?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
        <?php
        if ($error){
            echo $error;
        }
        ?>
</div>

<?php

include ("includes/foot.php");
?>
