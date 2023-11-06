<?php

function take_gerichte () :array{
$arr_gerichte =[];
$file = fopen('gerichte.txt', 'r');

if(!($file)){

    die("Fehler beim Öffnen der Datei.");

}else{

    $line ="";

    while (!feof($file)){
        $line = fgets($file);
        $line=trim($line);
        if (!empty($line)){  // Hatte eine leere Zeile immer im Array, das war die Lösung
        $parts = explode('-',$line,4);
        $arr_gerichte[]=[
            'gericht' => $parts[0],
            'preis_i' => isset($parts[1]) ? $parts[1] : 'Kein Preis intern',
            'preis_e' => isset($parts[2]) ? $parts[2] : 'Kein Preis extern',
            'bild' => isset($parts[3]) ? $parts[3] : 'Kein Bild vorhanden'
        ];
    }
    }

   fclose($file);

}

    return $arr_gerichte;
}

?>