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

function checkLogin($username, $password){
    static $req = null;
    if($req == null) {
        $req = db_connect()->prepare('SELECT password from users WHERE username = ?');
    }
    $req->execute(array($username));
    $data = $req->fetch(PDO::FETCH_ASSOC);
    return $data['password'] == $password;
}

/**
 * MESSAGE REQUESTS
 */
?>
