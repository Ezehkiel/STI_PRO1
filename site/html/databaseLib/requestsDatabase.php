<?php

function db_connect(){
    static $myDb = null;

    if ($myDb === null) {

        try {
            $myDB = new PDO('sqlite:/usr/share/nginx/databases/sti_project.sqlite');
            $myDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die("Impossible d'ouvrir la base de donnée: " . $e->getMessage());
        }
    }

    return $myDB;
}


/**
 * USERS REQUESTS
 */
function getAllUsers(){

    static $req = null;
    if ($req == null) {
        $req = db_connect()->query(
            'SELECT * from users'
        );
    }

    return $req->fetchAll(PDO::FETCH_ASSOC);
}

function getId($username){
    static $req = null;
    if($req == null) {
        $req = db_connect()->prepare('SELECT id_user from users WHERE login = ?');
    }
    $req->execute(array($username));
    $data = $req->fetch(PDO::FETCH_ASSOC);
    return $data['id_user'];
}

function getUsername($id){
    static $req = null;
    if($req == null) {
        $req = db_connect()->prepare('SELECT login from users WHERE id_user = ?');
    }
    $req->execute(array($id));
    $data = $req->fetch(PDO::FETCH_ASSOC);
    return $data['login'];
}

function checkLogin($username, $password){
    static $req = null;
    if($req == null) {
        $req = db_connect()->prepare('SELECT password from users WHERE login = ?');
    }
    $req->execute(array($username));
    $data = $req->fetch(PDO::FETCH_ASSOC);
    //return true;
    return $data['password'] == $password;
}

function checkIfValid($username) {
    static $req = null;
    if($req == null) {
        $req = db_connect()->prepare('SELECT isValid from users WHERE login = ?');
    }
    $req->execute(array($username));
    $data = $req->fetch(PDO::FETCH_ASSOC);
    return $data['isValid'] == 1;
}

function isAdmin($id){

    static $req = null;
    if($req == null){
        $req = db_connect()->prepare('SELECT isAdmin FROM users WHERE id_user = ?');
    }
    $req->execute(array($id));
    $data = $req->fetch(PDO::FETCH_ASSOC);
    return $data['isAdmin'] == "administrator";

}

function deleteUser($id){

    static $req = null;
    if ($req == null) {
        $req = db_connect()->prepare(
            'DELETE FROM users WHERE id_user = ?'
        );
    }

    try {
        $req->execute([$id]);
    } catch (Exception $e) {
        //return false;
        echo $e->getMessage();
    }

    return true;
}

function addUser($login, $password, $rule) {
    static $req = null;

    if($req == null) {
        $req = db_connect()->prepare('INSERT INTO users (login, password, isAdmin) VALUES(?, ?, ?)');
    }
    
    try {
        $req->execute(array($login, $password, $rule));
    } catch(Exception $e) {
        return false;
    }

    return true;
}

function getUser($id) {
    static $req = null;
    if($req == null){
        $req = db_connect()->prepare('SELECT * FROM users WHERE id_user = ?');
    }

    try {
        $req->execute(array($id));
        $data = $req->fetch(PDO::FETCH_ASSOC);
        return $data;
    } catch(Exception $e) {
        echo $e->getMessage();
    }
}

function updateUser($password, $admin, $validity, $id) {
    static $req = null;
    
    if($req == null) {
        $req = db_connect()->prepare('UPDATE users SET password = ?, isAdmin = ?, isValid = ? WHERE id_user = ?');
    }
    
    try {
        $req->execute(array($password, $admin, $validity, $id));
    } catch(Exception $e) {
        return false;
    }

    return true;
}

function updatePassword($id, $newPassword) {
    static $req = null;
    
    if($req == null) {
        $req = db_connect()->prepare('UPDATE users SET password = ? WHERE id_user = ?');
    }
    
    try {
        $req->execute(array($newPassword, $id));
    } catch(Exception $e) {
        return false;
    }

    return true;
}

function checkLoginAvailable($login) {
    static $req = null;
    if($req == null){
        $req = db_connect()->prepare('SELECT login FROM users WHERE login = ?');
    }

    try {
        $req->execute(array($login));
        $data = $req->fetch(PDO::FETCH_ASSOC);

        if(empty($data)) {
            return true;
        } else {
            return false;
        }
    } catch(Exception $e) {
        echo $e->getMessage();
    }
}

/**
 * MESSAGE REQUESTS
 */

function addMessage($date, $senderId, $recipientId, $object, $message){

    static $req = null;

    if($req == null){
        $req = db_connect()->prepare('INSERT INTO messages (date_receipt, id_sender, id_recipient, object, message) VALUES (?,?,?,?,?)');
    }
    if (empty($date) || empty($senderId) || empty($recipientId) || empty($object) || empty($message)) {
        return false;
    }

    try {
        $req->execute([$date, $senderId, $recipientId, $object, $message]);
    } catch (Exception $e) {
        return false;
    }

    return true;

}

function getMessage($id){

    static $req = null;
    if($req == null) {
        $req = db_connect()->prepare('SELECT id_message, id_sender, id_recipient, object, message, read, date_receipt AS utc_date from messages WHERE id_message = ?');
    }
    $req->execute(array($id));
    return $req->fetch(PDO::FETCH_ASSOC);

}

function fetchMessage($id){

    static $req = null;
    if($req == null){
        $req = db_connect()->prepare('SELECT id_message, id_sender, id_recipient, object, message, read, date_receipt AS utc_date FROM messages WHERE id_recipient = ? ORDER BY date_receipt DESC');
    }
    $req->execute(array($id));
    return $req->fetchAll(PDO::FETCH_ASSOC);

}

function deleteMessage($id){

    static $req = null;
    if ($req == null) {
        $req = db_connect()->prepare(
            'DELETE FROM messages WHERE id_message = ?'
        );
    }

    try {
        $req->execute([$id]);
    } catch (Exception $e) {
        return false;
    }

    return true;

}

function setStateMessage($id, $state){

    static $req = null;
    if ($req == null) {
        $req = db_connect()->prepare(
            'UPDATE messages SET read = ? WHERE id_message = ?'
        );
    }

    if (empty($id)) {
        return false;
    }

    try {
        $req->execute([$state, $id]);
    } catch (Exception $e) {
        print_r($e);
        return false;
    }

    return true;
}

function numberUnreadMessage($id){

    static $req = null;
    if($req == null){
        $req = db_connect()->prepare('SELECT COUNT(*) as nb FROM messages WHERE id_recipient = ? and read = 0');
    }
    $req->execute(array($id));
    $data = $req->fetch(PDO::FETCH_ASSOC);
    return $data['nb'];

}
?>
