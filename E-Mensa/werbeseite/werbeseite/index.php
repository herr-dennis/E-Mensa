
<?php

/**
 * Praktikum DBWT. Autoren:
 * Dennis, Schwarz, 3557435
 * Przemyslaw, Slusarczyk, 3278806
 */

/**
 *Gerichte.php "Datenbank" der Texte der Gerichte und Bilder
 *Save_User_Dates stellt eine Funktion: save_dates() die Benutzer-E-Mail in einer Textdatei speichert.
 */
include "Bilder.php";
include "Save_User_Dates.php";
include "Zahlen_verwaltung.php";
include "db_handling.php";
const GET_NAME ="name";
const GET_EMAIL ="email";
const GET_LANG="lang";
const GET_Checked ='checkpushed';
/*Attribute zum Überprüfen der Eingaben */
$email=false;
$name_validate = false;
$default = true;

//Abfrage von Gerichten an die DB
$gerichte = take_meals();
//Funktion die ein Array mit Pfaden von Bildern gibt.
$bilder = take_img(count($gerichte)+7);
//Abfrage von allergens an die DB
$allergens = take_allergens();
//Funktion die in der Datei die Besucheranzahl inkrementiert.
set_besucheranzahl();
//Lädt die Besucherzahl aus der DB
$besucher_anzahl = get_besucheranzahl();
//Funktion, die die Zahlen aus der Datei list.
$counts = get_counts();
//Bestimmt die Anzahl der Gerichte aus dem Array.
$anzahl_gerichte = count($gerichte);
//Abfrage von Allergen/Code für die Legende
$code_allergene= take_code_allergens();

/*Blacklist von E-Mails*/
$en_emails=['rcpt.at', 'damnthespam.at','wegwerfmail.de','trashmail.'];
$clientIP = $_SERVER['REMOTE_ADDR'];
echo "Die IP-Adresse des Clients ist: " . $clientIP;

if(!empty($_POST[GET_Checked])) {
    if ($_GET['pushed'] = 'Datensenden') {
        if (!empty($_POST[GET_NAME])) {
            $name_text = trim($_POST[GET_NAME]);
            $lang_text = $_POST[GET_LANG];
            if (strlen($name_text != 0)) {
                $name_validate = true;
                $default = false;
            }
        }
        if (!empty($_POST[GET_EMAIL])) {
            $email_text = $_POST[GET_EMAIL];
            if (filter_var($email_text, FILTER_VALIDATE_EMAIL)) {

                $email = true;
                $default = false;
                foreach ($en_emails as $item) {
                    if (str_contains($email_text, $item)) {
                        $email = false;
                    }
                }

            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Ihre E-Mensa</title>

    <link rel="stylesheet" type="text/css" href="index.css">

</head>
<body>

<header id="header">
    <img src="img/mensa_logo.jpg" id="logo" alt="Mensa-Logo">
    <div class="headerlinks">
        <a href="#übersicht">Ankündigung</a>
        <a href="#newstab">Zahlen</a>
        <a href="#preistab">Speisen</a>
        <a href="#footer">Wichtig für uns</a>
    </div>
</header>
<hr>



<main>


    <div id="mensabild">

        <img id="head_bild" src="img/mensa.jpg" alt="Mensa_Bild">
    </div>




    <h2>Bald gibt es Essen auch online!</h2>
    <div class="text" id="übersicht">
        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum
        sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies
        nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel,
        aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum
        felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate
        eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante,
        dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum.
        Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam
        rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque
        sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt
        tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros
        faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat,
        leo eget bibendum sodales, augue velit cursus nunc,
    </div>
    <h2>Köstlichkeiten die Sie erwarten!</h2>

    <table id="preistab">
        <tr>
            <th></th>
            <th>Preis intern</th>
            <th>Preis extern</th>
        </tr>

        <?php
        $temp_bild=0;
           foreach ($gerichte as $item){

               echo "<tr>
                           <td>";echo $item['name'];
               echo "</td>";
               echo "<td>";
                         echo $item['preisintern']. "€";
                         echo "</td>";

                 echo "<td>";
                         echo $item['preisextern']. "€";
                         echo "</td>";

               echo "</tr>";
               $temp_bild= $temp_bild+1;
               echo "</tr><td colspan='3' class='bilder'> <img src='$bilder[$temp_bild]' alt='Bilder Essen'></td></tr>";
               foreach ($allergens as $j){
               if($j['name']===$item['name']){
                   $allergen = $j['allergen_codes'];
                   break;
               }}
               echo  "<tr> <td colspan='3'>Allergene: $allergen </td></tr>";


              }
        ?>

        <tr>
           <th colspan="3">Legende Allergene:</th>

         <tr>

                <?php
                $halbeAnzahl = ceil(count($code_allergene) / 2);
                $gesplittet = array_chunk($code_allergene, $halbeAnzahl);

                $erstesArray = $gesplittet[0];
                $zweiterArray = $gesplittet[1];
                echo " <td class='allergens' >";
                foreach ($erstesArray as $value => $item){
                    echo $item['code']."  ".$item['name'];
                     if($value != array_key_last($erstesArray)){
                         echo "<br>";
                     }
                }
                echo "</td>";

                echo " <td class='allergens'  colspan='2'>";
                foreach ($zweiterArray as $value => $item){
                    echo $item['code']." ".$item['name']."<br>";

                }
                echo "</td>";



                ?>



        </tr>
    </table>

    <h2>E-Mensa in Zahlen</h2>
    <table>

        <tr id="newstab">

            <th> Besucher</th>
            <th> Anmeldungen<br>zum Newsletter</th>
            <th> Gerichte</th>
        </tr>
        <tr>

            <td class="zahlen"><?php echo $besucher_anzahl ?></td>
            <td class="zahlen"><?php echo $counts['newsletter']?></td>
            <td class="zahlen"><?php echo $anzahl_gerichte?></td>
        </tr>
    </table>

    <h2 id>Interesse geweckt? Wir informieren Sie! </h2>


    <form id="form1" method="post" action="#form1">
        <label for =name>Namen eingeben</label>
        <input type='text' id='name' name='name'>
        <label for='email'> Ihre E-Mail</label>
        <input type='text' id='email' name='email'>

        <label for="farbe">Sprache des Newsletters:</label>
        <select id="farbe" name="lang">
            <option value="Deutsch">Deutsch</option>
            <option value="Englisch">Englisch</option>
            <option value="Norwegisch">Norwegisch</option>

        </select>
        <label for="check">Den Datenschutzbestimmungen stimme ich zu:</label>
        <input type="checkbox" required id="check" name="checkpushed" value="checked">
        <input type="submit" name="pushed" value="Datensenden" >

        <?php
        if(!$default){
         if($email&&$name_validate){

             echo "<label id='save'> Wunderbar! E-Mail verschickt</label>";
             save_dates($name_text, $email_text, $lang_text);
         }
         if(!$email&&!$name_validate){

             echo "<label id='wrong'> Ungültiger Name und Email!</label>";
         }
         elseif (!$email){
             echo "<label id='wrong'> Email nicht gültig!</label>";
         }
         elseif (!$name_validate){
             echo "<label id='wrong'> Name nicht gültig</label>";
         }}


         ?>

    </form>

    <ul>
        <li><h2>Das ist uns wichtig!</h2></li>
        <li>Beste frische saisonale Zutaten</li>
        <li>Ausgewogene abwechslungsreiche Gerichte</li>
        <li>Sauberkeit</li>


    </ul>

</main>
<hr>
<footer id="footer">
    <p>&copy E-Mensa GmbH</p>
    <p>Schwarz, Slusarczyk</p>
    <p><a href="http://localhost:8080">Impressum</a></p>
</footer>
<hr>
</body>
</html>