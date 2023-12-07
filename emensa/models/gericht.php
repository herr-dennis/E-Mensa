<?php
/**
 * Diese Datei enthält alle SQL Statements für die Tabelle "gerichte"
 */
function db_gericht_select_all()
{
    try {
        $link = connectdb();

        $sql = 'SELECT id, name, beschreibung FROM gericht ORDER BY name';
        $result = mysqli_query($link, $sql);

        $data = mysqli_fetch_all($result, MYSQLI_BOTH);

        mysqli_close($link);
    } catch (Exception $ex) {
        $data = array(
            'id' => '-1',
            'error' => true,
            'name' => 'Datenbankfehler ' . $ex->getCode(),
            'beschreibung' => $ex->getMessage());
    } finally {
        return $data;
    }
}

    function db_select_Kategorie_Gericht(){

        $link = connectdb();
        $sql ='SELECT name , kategorie_id
FROM gericht JOIN
    gericht_hat_kategorie ON gericht.id = gericht_hat_kategorie.gericht_id  GROUP BY name ORDER BY name
';


        $result = mysqli_query($link, $sql);
        $data = array();
        if($result){

            while ($row = mysqli_fetch_assoc($result)) {

                $data[]=$row;
            }

        }
        else{
            echo "Fehler bein der Abfrage in db_select_Kategorie_Gericht()";
        }
        mysqli_close($link);

      return $data;
    }


    function db_select_gericht_preis_intern(){

        $link = connectdb();
        $sql ='SELECT name, preisintern FROM gericht WHERE preisintern >=2 ORDER BY preisintern desc
';


        $result = mysqli_query($link, $sql);
        $data = array();
        if($result){

            while ($row = mysqli_fetch_assoc($result)) {

                $data[]=$row;
            }

        }
        else{
            echo "Fehler bein der Abfrage in db_select_Kategorie_Gericht()";
        }
        mysqli_close($link);

        return $data;
    }

