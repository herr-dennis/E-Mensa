<?php
/**
 * Praktikum DBWT. Autoren:
 * Dennis, Schwarz, 3557435
 * Vorname2, Nachname2, Matrikelnummer2
 */
const GET_ADD_1 = "wert1";
const GET_ADD_2 = "wert2";
include "m2_5a_standardparameter.php";
$case = false;

if(!empty($_GET[GET_ADD_1])&&!empty($_GET[GET_ADD_2])) {
    $tmp1 = $_GET[GET_ADD_1];
    $tmp2 = $_GET[GET_ADD_2];

    $proof_int1 = filter_var($tmp1, FILTER_VALIDATE_INT);
    $proof_int2 = filter_var($tmp2, FILTER_VALIDATE_INT);
    $t =0;

    if ($proof_int1 && $proof_int2) {
        $case = true;   // Alles in Ordnung, können berechnen
        (int)$i = $tmp1;
        (int)$j = $tmp2;

        if (!empty($_GET["add"])) {
            $t = add($i, $j);
        } elseif (!empty($_GET["mult"])) {

            $t = mult($tmp2, $tmp1);
        }

    }
}
?>


<!DOCTYPE html>
<html lang="de">
<head>
 <title>Addieren!</title>

    <style>

        main{


        }
        form {
            display: flex;
           flex-direction: column;
            width: 20%;
            border: 2px solid grey;
        }

    </style>

</head>
<body>

<main>
    <label for="addForm">Addieren wir mal!</label>
    <form id="addForm" method="get" action="m2_5c_addform.php">
        <label for="ersteZahl">Erste Zahl</label>
        <input id="ersteZahl" type="text" name="wert1"><br>
        <label for="zweiteZahl">Zweite Zahl</label>
        <input id="zweiteZahl" type="text" name="wert2" ><br>
        <input type="submit" value="Addieren!" name="add">
        <input type="submit" value="Multiplizieren!" name="mult">
    </form>
    <?php
       if($case){
           echo  "<p>Wow! Das Ergebnis lautet: $t</p>";
       }else echo  "<p> Na! Bitte Zahlen eingeben!</p>";

    ?>
</main>


</body>











</html>




