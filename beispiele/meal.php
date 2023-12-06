<?php

/**
 * Praktikum DBWT. Autoren:
 * Dennis, Schwarz, 3557435
 * Vorname2, Nachname2, Matrikelnummer2
 */
const GET_PARAM_MIN_STARS = 'search_min_stars';
const GET_PARAM_SEARCH_TEXT = 'search_text';
const GET_PARAM_Show_Description = 'show_description';
const GET_PARAM_TOP = "top_flopp";
$htmlLang = 'de';
$max_star =0;

/**
 * List of all allergens.
 */

$translate = [

];

if(!empty($_GET["lang"])) {

    if ($_GET["lang"] == 'de') {
        $file = fopen('./de.txt', 'r');
    } elseif ($_GET["lang"] == "en") {
        $file = fopen('./en.txt', 'r');
    }
}
else{
    $file = fopen('./de.txt', 'r');
}

       if(!$file){
           echo "Fehler beim Öffnen!";
       }else{

           while (!feof($file)){
               $line = fgets($file,1024);
               list($key, $value) = explode(',',$line,2); //explode trennt Strings auf, und speichert die in einen Array!
               if($value!=null){ //Es gab eine Warnung, ohne die Bedingung.
               $translate[trim($key)] = trim($value);} //Assoziatives Array key => value...

           }

       }








$allergens = [
    11 => 'Gluten',
    12 => 'Krebstiere',
    13 => 'Eier',
    14 => 'Fisch',
    17 => 'Milch'
];

$meal = [
    'name' => 'Süßkartoffeltaschen mit Frischkäse und Kräutern gefüllt',
    'description' => 'Die Süßkartoffeln werden vorsichtig aufgeschnitten und der Frischkäse eingefüllt.',
    'price_intern' => 2.90,
    'price_extern' => 3.90,
    'allergens' => [11, 13],
        'amount' => 42             // Number of available meals
    ];

$ratings = [
    [   'text' => 'Die Kartoffel ist einfach klasse. Nur die Fischstäbchen schmecken nach Käse. ',
        'author' => 'Ute U.',
        'stars' => 2 ],
    [   'text' => 'Sehr gut. Immer wieder gerne',
        'author' => 'Gustav G.',
        'stars' => 4 ],
    [   'text' => 'Der Klassiker für den Wochenstart. Frisch wie immer',
        'author' => 'Renate R.',
        'stars' => 4 ],
    [   'text' => 'Kartoffel ist gut. Das Grüne ist mir suspekt.',
        'author' => 'Marta M.',
        'stars' => 3 ]
];
/**
 * Hier wird überprüft, ob wir ein Get_Parameter haben
 * dann min/max an sternen ermittel und in einen Array gespeichert
 */
if(!empty($_GET[GET_PARAM_TOP])){
    $top=[];
    $flop=[];
    $max_star = 0;
    $min_star= 5;

    foreach ($ratings as $value){

        if($value['stars']>=$max_star){
            $max_star=$value["stars"];
        }
        if($value["stars"]<=$min_star){
           $min_star = $value["stars"];
        }
    }

    foreach ($ratings as $i) {
        if ($i['stars'] == $max_star) {
            $top[] = $i['text'];
        }
        if ($i['stars'] == $min_star) {
            $flop[] = $i['text'];
        }

    }
}

$showRatings = [];
if (!empty($_GET[GET_PARAM_SEARCH_TEXT])) {  // Kein Wert im Array, nur Schlüssel
    $searchTerm = $_GET[GET_PARAM_SEARCH_TEXT];
    foreach ($ratings as $rating) {
        if (stripos($rating['text'], $searchTerm) !== false) {
            $showRatings[] = $rating;  //Hier wird showrating befüllt

        }
    }
} else if (!empty($_GET[GET_PARAM_MIN_STARS])) {
    $minStars = $_GET[GET_PARAM_MIN_STARS];
    foreach ($ratings as $rating) {
        if ($rating['stars'] >= $minStars) {
            $showRatings[] = $rating; //Hier wird showrating befüllt
        }
    }
} else {
    $showRatings = $ratings;
}

 function calcMeanStars(array $ratings) : float {
    $sum = 1;
    foreach ($ratings as $rating) {
        $sum += $rating['stars'];
    }
    $sum = $sum /count($ratings);
    return $sum;
}

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8"/>
    <title><?php echo $translate['Gericht']?>: <?php echo $meal['name']; ?></title>
    <style>
        * {
            font-family: Arial, serif;
        }
        .rating {
            color: darkgray;
        }
    </style>
</head>
<body>
<h1><?php echo $translate['Gericht'].':'?> <?php echo $meal['name']." ".number_format((double)$meal['price_extern'],2)."&euro;"; ?></h1>

<p><?php


if (empty($_GET['show_description'])) {
    echo "{$meal['description']}";
}
 else{
     echo  "Hall";
 }
?>
</p>

<ul>
    <h3><?php echo $translate['Allergen']?></h3>
    <?php
    foreach ($allergens as $allergen){
        echo  "<li>$allergen </li>";}
    ?>

</ul>

<h1><?php echo $translate['Bewertungen'].":"?> (<?php echo $translate['Insgesamt']?> <?php echo calcMeanStars($ratings); ?>)</h1>
<form method="get">
    <label for="search_text">Filter:</label>
    <input id="search_text" type="text" name="search_text" value="<?php echo isset($_GET['search_text']) ? htmlspecialchars($_GET['search_text']) : ''; ?>"">
    <input type="submit" value="<?php echo $translate['Suchen']?>"><br>
    <label for = "show_description"> <?php echo $translate['Beschreibung']?></label>
     <input id =show_description type="checkbox" name="show_description" value="0"><br>
    <label for="top_flopp">Alle Top-Bewertungen anzeigen:</label>
    <select id="top_flopp" name="top_flopp">
        <option value="top">Top Gerichte</option>
        <option value="flopp">Flop Gerichte</option>
        <option value="">Alle Gerichte</option>
    </select>


</form>
<table class="rating">
    <thead>
    <tr>
        <td><?php echo $translate['Text']?></td>
        <td><?php echo $translate['Sterne']?></td>
        <td><?php echo $translate['Autoren']?></td>
    </tr>
    </thead>
    <tbody>
    <?php
    if(empty($_GET[GET_PARAM_TOP])){
    foreach ($showRatings as $rating) {
        echo "<tr><td class='rating_text'>{$rating['text']}</td>
                      <td class='rating_stars'>{$rating['stars']}</td>
                       <td class='rating_stars'> {$rating['author']}</td>
                  </tr>";
    }}
    elseif(!empty($_GET[GET_PARAM_TOP])){

        if($_GET[GET_PARAM_TOP] == 'flopp'){
                foreach ($flop as $item){
                    echo "<tr>
                     <td>"; for($i=0; $i<$min_star; $i++){
                               echo "<img src='Star-icon.png' alt='Stern'>";}
                        echo "</td>
                      <td>$item</td>
                    
                      </tr>";

                }
        }
        elseif($_GET[GET_PARAM_TOP] == 'top'){
            foreach ($top as $item){
            echo "<tr>
                     <td>";
                               for($j =0; $j < $max_star; $j++){
                                   echo "<img src='Star-icon.png' alt='Sterne'>";
                               }

                     echo "</td>
                      <td>$item</td>
                    
                      </tr>";}
        }
    }



    ?>
    </tbody>
</table>

  <footer>

      <p> <?php echo $translate['Sprache'].":"?></p>
      <ul>

          <li> <a href="meal.php?lang=de" > Deutsch </a></li>
          <li> <a href="meal.php?lang=en"> Englisch</a></li>

      </ul>

  </footer>

</body>
</html>
