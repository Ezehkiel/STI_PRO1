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
    return $data['admin'] == "admin";

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

function addUser($login, $password, $rule) {
    static $req = null;

    if($req == null) {
        $req = db_connect()->prepare('INSERT INTO users (login, password, admin, validite) VALUES(?, ?, ?, ?)');
    }
    
    try {
        $req->execute(array($login, $password, $rule, 1));
    } catch(Exception $e) {
        //return false;
        echo $e->getMessage();
    }

    return true;
}

/**
 * MESSAGE REQUESTS
 */
?>
