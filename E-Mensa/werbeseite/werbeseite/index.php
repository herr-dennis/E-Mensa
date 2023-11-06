
<?php
/**
 *Gerichte.php "Datenbank" der Texte der Gerichte und Bilder
 *Save_User_Dates stellt eine Funktion: save_dates() die Benutzer-E-Mail in einer Textdatei speichert.
 */
include "Gerichte.php";
include "Save_User_Dates.php";
const GET_NAME ="name";
const GET_EMAIL ="email";
const GET_LANG="lang";
$gerichte = take_gerichte();
$email=false;


if(!empty($_POST[GET_NAME])&&!empty($_POST[GET_EMAIL])){
    $name_text = trim($_POST[GET_NAME]);
    $email_text = $_POST[GET_EMAIL];

    if(filter_var($email_text, FILTER_VALIDATE_EMAIL)){
        $email=true;
        save_dates($name_text,$email_text);
    }else{
        $email=false;
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
    <img id="logo" alt="Mensa-Logo">
    <div class="headerlinks">
        <a href="index.html">Ankündigung</a>
        <a href="index.html">Zahlen</a>
        <a href="index.html">Speisen</a>
        <a href="index.html">Wichtig für uns</a>
    </div>
</header>
<hr>

<div id="mensabild">

    <img id="head_bild" src="mensa.jpg" alt="Mensa_Bild">
</div>


<main>

    <h2>Bald gibt es Essen auch online!</h2>
    <div class="text">
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
           foreach ($gerichte as $item){
               echo "<tr>
                           <td>";echo $item['gericht'];
               echo "</td>";
               echo "<td>";
                         echo $item['preis_i']. "€";
                         echo "</td>";

                 echo "<td>";
                         echo $item['preis_e']. "€";
                         echo "</td>";

               echo "</tr>";
               $k = $item['bild'];
               echo "</tr><td colspan='3' class='bilder'> <img src='$k' alt='Bilder Essen'></td></tr>";


              }
        ?>

        <tr>
            <td>...</td>
            <td>...</td>
            <td>...</td>
        </tr>
    </table>

    <h2>E-Mensa in Zahlen</h2>
    <table>

        <tr id="newstab">
            <th> x Besuche</th>
            <th> y Anmeldungen<br>zum Newsletter</th>
            <th> Speisen</th>
        </tr>
        <tr>

            <td>...</td>
            <td>...</td>
            <td>...</td>
        </tr>
    </table>

    <h2 id>Interesse geweckt? Wir informieren Sie! </h2>


    <form id="form1" method="post" action="#form1">

        <label for="name">Ihr Name </label>
        <input type="text" id="name" name="name">

        <?php if($email){
             echo "<label for='email'> Ihre E-Mail</label>";
            echo "<input type='text' id='email' name='email'>";
        }
        else{
            echo "<label for='email'> Ihre E-Mail</label>";
            echo "<input type='text' id='wrong' name='email' value='Falsche Eingabe!'>";
        }
        ?>
        <label for="farbe">Sprache des Newsletters:</label>
        <select id="farbe" name="lang">
            <option value="Deutsch">Deutsch</option>
            <option value="Englisch">Englisch</option>
            <option value="Norwegisch">Norwegisch</option>

        </select>
        <label for="check">Den Datenschutzbestimmungen stimme ich zu:</label>
        <input type="checkbox" required id="check">
        <input type="submit">

        <?php
         if($email){
             echo "<label id='save'> Wunderbar! E-Mail verschickt</label>";
         }

         ?>

    </form>

    <ul>
        <h2>Das ist uns wichtig!</h2>
        <li>Beste frische saisonale Zutaten</li>
        <li>Ausgewogene abwechslungsreiche Gerichte</li>
        <li>Sauberkeit</li>


    </ul>

</main>
<hr>
<footer>
    <p>&copy E-Mensa GmbH</p>
    <p>Namen..</p>
    <p><a href="http://localhost:8080">Impressum</a></p>
</footer>
<hr>
</body>
</html>