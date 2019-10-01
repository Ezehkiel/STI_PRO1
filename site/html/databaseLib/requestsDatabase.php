<?php

function db_connect(){
    static $myDb = null;

    if ($myDb === null) {
        try {
            $myDB = new PDO('sqlite:/usr/share/nginx/databases/database.sqlite');
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
        $req = db_connect()->prepare('SELECT id from users WHERE username = ?');
    }
    $req->execute(array($username));
    $data = $req->fetch(PDO::FETCH_ASSOC);
    return $data['id'];
}

function checkLogin($username, $password){
    static $req = null;
    if($req == null) {
        $req = db_connect()->prepare('SELECT password from users WHERE username = ?');
    }
    $req->execute(array($username));
    $data = $req->fetch(PDO::FETCH_ASSOC);
    return $data['password'] == $password;
}

function isAdmin($id){

    static $req = null;
    if($req == null){
        $req = db_connect()->prepare('SELECT role FROM users WHERE id = ?');
    }
    $req->execute(array($id));
    $data = $req->fetch(PDO::FETCH_ASSOC);
    return $data['role'] == "admin";

}

function deleteUser($id){

    static $req = null;
    if ($req == null) {
        $req = db_connect()->prepare(
            'DELETE FROM users WHERE id = ? '
        );
    }

    try {
        $req->execute([$id]);
    } catch (Exception $e) {
        return false;
    }

    return true;
}

/**
 * MESSAGE REQUESTS
 */
?>
