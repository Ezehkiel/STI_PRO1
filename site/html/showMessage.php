<?php
include ("includes/head.php");
include ("utility/utility.php");
include ("databaseLib/requestsDatabase.php");

if(isset($_GET['idMessage'])){

    $message = getMessage($_GET['idMessage']);
    if($message['id_expediteur'] != $_SESSION['id'] && $message['id_destinataire'] != $_SESSION['id'] ){
        header('location: inbox.php');
    }
    setStateMessage($_GET['idMessage'], 1);
}
?>

<div class="container-fluid">
    <div class="row">
        <h1 class="col-4"><u>Message detail</u></h1>
    </div>
    <form method="post">
        <div class="row">
            <div class="form-group col-3">
                <h3>Expeditor:</h3>
            </div>
            <div class="form-group col-3">
                <?= getUsername($message['id_expediteur']) ?>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-3">
                <h3>Date:</h3>
            </div>
            <div class="form-group col-3">
                <?= $message['utc_date'] ?>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-3">
                <h3>Object:</h3>
            </div>
            <div class="form-group col-3">
                <?= $message['sujet'] ?>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-3">
                <h3>Body:</h3>
            </div>
            <div class="form-group col-3" style="word-wrap: break-word">
                <?= $message['message'] ?>
            </div>
        </div>
        <div class="row">
            <a class="btn btn-secondary col-1" href="./inbox.php">Back</a>
            <a class="btn btn-primary col-1" href="./newMessage.php?idMessage= <?= $message['id_message'] ?> ">Reply</a>
            <a class="btn btn-danger col-1" href="./inbox.php?delete=<?= $message['id_message'] ?>">Delete</a>
        </div>
    </form>

</div>

<?php

include ("includes/foot.php");
?>