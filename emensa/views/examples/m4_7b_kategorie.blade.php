<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Der Name</title>
</head>
<body>

<hr>
<ul>
    <p>Gerichte sind aufsteigenden sortiert!</p>

    @foreach($data as $value)
        @if($loop->even)
            <li>{{ $value['name']."   Kategorie:  ".$value['kategorie_id'] }}</li>
        @else
            <li><b>{{ $value['name']."   Kategorie:  ".$value['kategorie_id'] }}</b></li>
        @endif
    @endforeach
</ul>
<hr>

</body>
</html>

