<?php
/**
 * Praktikum DBWT. Autoren:
 * Dennis, Schwarz, 3557435
 * Przemyslaw, Slusarczyk, 3278806
 */
/**
 * @return string[] gibt einen Array zurück dort sind die gespeicherten Zahlen
 * aus der Datei zahlen.txt drin,
 * Die Funktion liest die Zahlen aus der Datei.
 */
function get_counts(): array
{
    $zahlen=['besucher'=>'0','gerichte'=>'0','newsletter'=>'0'];
    $besucher ="0";
    $file = fopen("daten/zahlen.txt", 'r');
    if(!$file){
        die("Fehler beim Öffnen von daten.txt");
    }
    else{

        while (!feof($file)){
            $line = fgets($file);
            if(!empty($line)){
            $parts = explode('=', $line,2);

                if (count($parts) === 2) {
                    $key = trim($parts[0]);
                    $value = trim($parts[1]);

                    if ($key === 'besucher') {
                        $zahlen['besucher'] = intval($value);
                    } elseif ($key === 'gerichte') {
                        $zahlen['gerichte'] = intval($value);
                    } elseif ($key === 'newsletter') {
                        $zahlen['newsletter'] = intval($value);
                    }
                }



        }}

        fclose($file);
    }
    return $zahlen;
}

/**
 * Inkrementiert in der Datei zahlen.txt die Besucher.
 */
function set_count_besucher(){

    /**
    * $lines = file () -> liest Datei aus und schreibe jede Zeile als Array eintrag
     */
    $lines = file("daten/zahlen.txt");
    $newLines = [];

    foreach ($lines as $line) {
        /**
        * strpos überprüft ob "besucher" in der Line ist und gibt die Position zurück
         */

        if (strpos($line, "besucher=") === 0) {
            $parts = explode("=", $line);
            if (count($parts) === 2) {
                $count = intval($parts[1]);
                $count++;
                $line = "besucher=$count\n";
            }
        }
        $newLines[] = $line;
    }
     /**
      * implode "Zieht die Teilstücke wieder zusammen und schreibt sie in die Datei
      * Ohne Trennzeichen also ""
     */
    file_put_contents("daten/zahlen.txt", implode("", $newLines));

}

/**
 * Inkrementiert in der Datei zahlen.txt die Anzahl der Newsletter.
 */
function set_count_newsletter(){

    /**
     * $lines = file () -> liest Datei aus und schreibe jede Zeile als Array eintrag
     */
    $lines = file("daten/zahlen.txt");
    $newLines = [];

    foreach ($lines as $line) {
        /**
         * strpos überprüft ob "besucher" in der Line ist und gibt die Position zurück
         */

        if (strpos($line, "newsletter=") === 0) {
            $parts = explode("=", $line);
            if (count($parts) === 2) {
                $count = intval($parts[1]);
                $count++;
                $line = "newsletter=$count\n";
            }
        }
        $newLines[] = $line;
    }
    /**
     * implode "Zieht die Teilstücke wieder zusammen und schreibt sie in die Datei
     * Ohne Trennzeichen also ""
     */
    file_put_contents("daten/zahlen.txt", implode("", $newLines));

}



