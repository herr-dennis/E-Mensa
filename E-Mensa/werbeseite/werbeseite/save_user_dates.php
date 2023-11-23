<?php
/**
 * Praktikum DBWT. Autoren:
 * Dennis, Schwarz, 3557435
 * Przemyslaw, Slusarczyk, 3278806
 */
function save_dates($name_ , $email_, $lang_){

$file = fopen("daten/Benutzerdaten.txt",'a');
    $lang=$lang_;
    $name=$name_;
    $email = $email_;
    $line = $name."/".$email."/".$lang."\n";
    fwrite($file, $line);
    fclose($file);

    set_count_newsletter();
}

?>

