<?php
/**
 * Praktikum DBWT. Autoren:
 * Dennis, Schwarz, 3557435
 * Przemyslaw, Slusarczyk, 3278806
 */

$GET_SUCHWORT = 'suchwort';
$suche=false;
$file = fopen("en_show.txt", 'r');
$über= [];
if(!$file){
    die("en_show.txt kann nicht geöffnet werden");
}
else{
    $suchwort = $_GET[$GET_SUCHWORT];

    while (!feof($file)){

        $line = fgets($file);

        if(str_contains($line, $suchwort)){

            $suche=true;
            $über= explode($line,';',2);
            break;
        }


    }


}



?>




<!DOCTYPE html>
<html lang="de">
    <head>
        <title>Suche</title>
        <meta charset="UTF-8">
    </head>

    <body>

        <main>
            <form action="#" method="get">
            <label for="suchwort">Suchwort:</label>
            <input type="text" id="suchwort" name="suchwort"><br>
                <input type="submit" value="Finde mein Wort">
            </form>

            <?php if($suche===true){

                echo "<p> Suche erfolgreich! $suchwort wurde gefunden!</p>";
                echo "<p> var_dump($über)$über[1]</p>";

            } ?>
        </main>
    </body>

</html>
