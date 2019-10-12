<?php

/**
 * @return PDO return the connection on the database
 */
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

/**
 * Fetch all users
 * @return array with all users
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

/**
 * Get the id of a user with his username
 * @param $username of the user
 * @return mixed the id
 */
function getId($username){
    static $req = null;
    if($req == null) {
        $req = db_connect()->prepare('SELECT id_user from users WHERE login = ?');
    }
    $req->execute(array($username));
    $data = $req->fetch(PDO::FETCH_ASSOC);
    return $data['id_user'];
}

/**
 * Get the user of a user
 * @param $id of the user
 * @return mixed the username linked to the id
 */
function getUsername($id){
    static $req = null;
    if($req == null) {
        $req = db_connect()->prepare('SELECT login from users WHERE id_user = ?');
    }
    $req->execute(array($id));
    $data = $req->fetch(PDO::FETCH_ASSOC);
    return $data['login'];
}

/**
 * We test if the password given is equals to the one in the database
 * @param $username of the user
 * @param $password of the user
 * @return bool true if the password given match
 */
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

/**
 * We check if the user is valid
 * @param $username the username of the user
 * @return bool true is the user is valid
 */
function checkIfValid($username) {
    static $req = null;
    if($req == null) {
        $req = db_connect()->prepare('SELECT isValid from users WHERE login = ?');
    }
    $req->execute(array($username));
    $data = $req->fetch(PDO::FETCH_ASSOC);
    return $data['isValid'] == 1;
}

/**
 * We check if the user is an administrator
 * @param $id of the user
 * @return bool true if the user is an admin
 */
function isAdmin($id){

    static $req = null;
    if($req == null){
        $req = db_connect()->prepare('SELECT isAdmin FROM users WHERE id_user = ?');
    }
    $req->execute(array($id));
    $data = $req->fetch(PDO::FETCH_ASSOC);
    return $data['isAdmin'] == "administrator";

}

/**
 * Delete a user
 * @param $id of the user that we want to delete
 * @return bool true if the delete goes well
 */
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
        return false;
    }

    return true;
}

/**
 * We add a user
 * @param $login the login of the user
 * @param $password the password of the user
 * @param $rule the role of the user
 * @return bool true if the user is added
 */
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

/**
 * Get a user
 * @param $id the id of the user
 * @return mixed the user with all his info
 */
function getUser($id) {
    static $req = null;
    if($req == null){
        $req = db_connect()->prepare('SELECT * FROM users WHERE id_user = ?');
    }

    try {
        $req->execute(array($id));
        return $req->fetch(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
        echo $e->getMessage();
    }
}

/**
 * Update a user
 * @param $password new password
 * @param $admin is the user an administrator
 * @param $validity is the user valid
 * @param $id the id of the user
 * @return bool true if the update goes well
 */
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

/**
 * Change the password of a user
 * @param $id of the user
 * @param $newPassword the new password
 * @return bool true if the update goes well
 */
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

/**
 * We check if a login is free of not
 * @param $login the login to test
 * @return bool true if the login is available
 */
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

/**
 * WE add a new message in the database
 * @param $date the date of the message
 * @param $senderId id of the sender
 * @param $recipientId if of the recipient
 * @param $object the obect of the message
 * @param $message the message
 * @return bool true if the insert goes well
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

/**
 * We fetch one message with his id
 * @param $id if the message
 * @return mixed the message link by the id
 */
function getMessage($id){

    static $req = null;
    if($req == null) {
        $req = db_connect()->prepare('SELECT id_message, id_sender, id_recipient, object, message, read, date_receipt AS utc_date from messages WHERE id_message = ?');
    }
    $req->execute(array($id));
    return $req->fetch(PDO::FETCH_ASSOC);

}

/**
 * Get all messages
 * @param $id of the user that is the recipient
 * @return array with all the messages
 */
function fetchMessage($id){

    static $req = null;
    if($req == null){
        $req = db_connect()->prepare('SELECT id_message, id_sender, id_recipient, object, message, read, date_receipt AS utc_date FROM messages WHERE id_recipient = ? ORDER BY date_receipt DESC');
    }
    $req->execute(array($id));
    return $req->fetchAll(PDO::FETCH_ASSOC);

}

/**
 * Delete a message
 * @param $id of the message to delete
 * @return bool true if the delete goes well
 */
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

/**
 * We set if the message is read od unread. If the state is 1 the message will be read and if
 * the state is 0 the message will be unread
 * @param $id the id of the message
 * @param $state
 * @return bool true if the update goes well
 */
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

/**
 * Give the number of messages unread
 * @param $id of the user that is recipient
 * @return mixed
 */
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
