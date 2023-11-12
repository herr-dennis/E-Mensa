<?php
/**
 * Praktikum DBWT. Autoren:
 * Dennis, Schwarz, 3557435
 * Przemyslaw, Slusarczyk, 3278806
 */



//Round rundet Fließkomma einfach
$time =  round($_SERVER['REQUEST_TIME_FLOAT']);
$ip = $_SERVER['REMOTE_ADDR'];

$daten =['IP'=> $ip,
            'Date' => date("Y-m-d H:i:s", $time)];

$file = fopen("accesslog.txt",'a');
if(!$file){
    die("Fehler beim Laden vom access.txt");
}else{

    foreach ($daten as $value => $item){
        fwrite($file, $value." ".$item."\n");
    }

 fclose("accesslog.txt");
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Access!</title>
</head>
<body>
<h1>Deine Daten sind: <?php echo date("Y-m-d H:i:s", $time); ?></h1>
<h1> Deine IP lautet: <?php echo $ip ?></h1>




</body>
</html>


