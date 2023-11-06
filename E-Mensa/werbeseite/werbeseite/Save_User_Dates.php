<?php


function save_dates($name_ , $email_){

$file = fopen("Benutzerdaten.txt",'a');
if(!empty($_POST[GET_NAME])&&!empty($_POST[GET_EMAIL])){
    $name=$name_;
    $email = $email_;
    $line = $name."/".$email."\n";
    fwrite($file, $line);
    fclose($file);
}

}

?>

