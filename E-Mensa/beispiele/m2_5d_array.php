<?php
/**
 * Praktikum DBWT. Autoren:
 * Dennis, Schwarz, 3557435
 * Vorname2, Nachname2, Matrikelnummer2
 */
$famousMeals = [
    1 => ['name' => 'Currywurst mit Pommes',
        'winner' => [2001, 2003, 2007, 2010, 2020]],
    2 => ['name' => 'Hähnchencrossies mit Paprikareis',
        'winner' => [2002, 2004, 2008]],
    3 => ['name' => 'Spaghetti Bolognese',
        'winner' => [2011, 2012, 2017]],
    4 => ['name' => 'Jägerschnitzel mit Pommes',
        'winner' => [2019]]];// Achtung hier ein Array draus gemacht! Sonst würde ich per if() fragen ob es den Wert 2019 hat
  $years=[];
  $years=pull_years($famousMeals);
  $years= sort_b($years);
  $years=calc_years($years);

function sort_b($array) :array
{
    $result = $array;
    $length = count($result);

    for ($i = 0; $i < $length - 1; $i++) {
        for ($k = 0; $k < $length - 1 - $i; $k++) {
            if ($result[$k] > $result[$k + 1]) {
                $temp = $result[$k];
                $result[$k] = $result[$k + 1];
                $result[$k + 1] = $temp;
            }
        }
    }

    return $result;


   }

    function pull_years ($array) :array{
        $result = [];
          foreach ($array as $value){
              foreach ($value as $item){
                  if(is_array($item)){
                      for($k = count($item)-1; $k>=0; $k--){

                          $result[]=$item[$k];
                      }
                  }
              }

          }

         return $result;
    }

    function calc_years($array) :array {
        $result = [];
        $max = max($array); // Maximaler Wert im gegebenen Array

        // Ein Array von 2000 bis zum maximalen Wert erstellen
        $allYears = range(2000, $max);

        // Unterschied zwischen allen Jahren und den Jahren im gegebenen Array
        $missingYears = array_diff($allYears, $array);

        // Die fehlenden Jahre hinzufügen
        $result = array_values($missingYears);

        return $result;



}


; ?>


<!DOCTYPE html>
    <html lang="de">
    <head>
        <title>Array</title>
        <meta charset=UFT-8">
        <style>
            .list{
                margin-top: 5px;

            }

        </style>
    </head>

    <body>

    <main>

            <?php
            echo "<ol>";

              foreach ($famousMeals as $item){  // items-> das erste Array nach dem Key

                  foreach ($item as $value)    //  laufen mit item durch die ersten Arrays

                  if(!is_array($value)){                             // Value ist der Wert in item
                  echo "<li class='list'>$value</li>";}

                  if(isset($value) && is_array($value)) {
                     for( $i=count($value)-1; $i>=0; $i--) {
                         echo "<td>$value[$i]</td>";
                         if ($i != 0) {
                             echo ", ";
                         }
                     }}

              }

             echo "</ol>";


              echo "<p> In diesen Jahren gab es keinen Gewinner:</p>";
              echo "<ul>";

                foreach ($years as $item){
                echo "<li>$item</li><br>";
            }
            ?>

    </main>

    </body>









    </html>
