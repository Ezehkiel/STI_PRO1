<?php
function checkIfAdmin($id) {
    if(!isAdmin($id)) {
        header('location: home.php');
    }
}

function printVar($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}