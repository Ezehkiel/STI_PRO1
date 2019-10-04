<?php

function db_connect(){
    static $myDb = null;

    if ($myDb === null) {
        try {
            $myDB = new PDO('sqlite:/usr/share/nginx/databases/sti_project1');
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

function checkLogin($username, $password){
    static $req = null;
    if($req == null) {
        $req = db_connect()->prepare('SELECT password from users WHERE login = ?');
    }
    $req->execute(array($username));
    $data = $req->fetch(PDO::FETCH_ASSOC);
    return $data['password'] == $password;
}

function isAdmin($id){

    static $req = null;
    if($req == null){
        $req = db_connect()->prepare('SELECT admin FROM users WHERE id_user = ?');
    }
    $req->execute(array($id));
    $data = $req->fetch(PDO::FETCH_ASSOC);
    return $data['admin'] == "administrator";

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
        $req = db_connect()->prepare('INSERT INTO users (login, password, admin) VALUES(?, ?, ?)');
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
        $req = db_connect()->prepare('UPDATE users SET password = ?, admin = ?, validite = ? WHERE id_user = ?');
    }
    
    try {
        $req->execute(array($password, $admin, $validity, $id));
    } catch(Exception $e) {
        return false;
    }

    return true;
}

/**
 * MESSAGE REQUESTS
 */

function addMessage($senderId, $recipientId, $object, $message){

    static $req = null;

    if($req == null){
        $req = db_connect()->prepare('INSERT INTO messages (id_expediteur, id_destinataire, sujet, message) VALUES (?,?,?,?)');
    }
    if (empty($senderId) || empty($recipientId) || empty($object) || empty($message)) {
        return false;
    }

    try {
        $req->execute([$senderId, $recipientId, $object, $message]);
    } catch (Exception $e) {
        echo $e;
        return false;
    }

    return true;

}

function fetchMessage($id){

    static $req = null;
    if($req == null){
        $req = db_connect()->prepare('SELECT * FROM messages WHERE id_destinataire = ?');
    }
    $req->execute(array($id));
    return $req->fetchAll(PDO::FETCH_ASSOC);

}
?>
