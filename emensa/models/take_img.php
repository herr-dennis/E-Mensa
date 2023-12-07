
<?php

function take_img($anzahl_bilder): array
{
$bild = [];
$file_path = 'img_url.txt';

if (!file_exists($file_path)) {
die("Die Datei '$file_path' existiert nicht.");
}

$file = fopen($file_path, 'r');

if (!$file) {
die("Fehler beim Öffnen der Datei.");
} else {
// Lese die Datei, bis die gewünschte Anzahl an Bildern erreicht ist
for ($i = 0; $i < $anzahl_bilder; $i++) {
if (feof($file)) {
// Zurück zum Anfang der Datei, wenn das Ende erreicht ist
fseek($file, 0);
}

$line = fgets($file);
$line = trim($line);

if (!empty($line)) {
$bild[] = $line;
}
}
}

fclose($file);

return $bild;
}

?>
