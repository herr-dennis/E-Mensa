<?php

function crfs_token(){

    // Überprüfe, ob das CSRF-Token vorhanden und korrekt ist
    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        return true;
    } else {
        return false;
    }
$nichtMehrGefählich =  mysqli_real_escape_string("GEFÄHRLICH!");

}
 session_start();


