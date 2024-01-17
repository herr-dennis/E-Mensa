@extends('layouts.layout_main_page')
@section('überschrift', 'Ihre E-Mensa hat wieder geöffnet!')
@section('title' ,'Bewertungen')
@section('header')
    <img src="img/mensa_logo.jpg" id="logo" alt="Mensa-Logo">

    <script>
        // JavaScript-Code für den Klick auf das Bild
        document.getElementById('logo').addEventListener('click', function() {
            window.location.href = '/emensa/public/'; // Hier die URL deiner Hauptseite einfügen
        });
    </script>
@endsection
<hr>

@section('main-content')
    @if($auswahl===true)
    <div class="formular" >
        <h2>Neue Bewertung einfügen zum Gericht: {{$userData[0]['name']}}</h2>
        <form method="post" name="formAddBewertung">
            <img id="noBild" src="{{$userData[0]['bildname']}}" alt="">
            <label for="inputTextBewertung">Bewertung:</label>
            <input id="inputTextBewertung" type="text" name="textBewertung" required minlength="5">
            <label for="inputSterneBewertung">Ihre Sterne für das Gericht:</label>
            <input type="number" id="inputSterneBewertung" name="sterneBewertung" min="1" max="5" required>
            <input type="hidden" value="{{$userData[0]['name']}}" name="nameBewertung">
            <button type="submit">Bewertung absenden</button>
        </form>
    </div>
    @endif
    <h2>Die Bewertungen aller Gerichte</h2>
    @foreach($data as $item)

    <table
            @if( $item['highlightRating']) class="glowUp" @endif >

        @if( $item['highlightRating'])
        <tr>
            <td colspan="3">Bestseller! Sehr gutes tolles Gericht!</td>
        </tr>
        @endif
        <tr>
            <td colspan='3' class='bilder'><img id="noBild" src="{{$item['bildname']}}" alt=""> </td>
        </tr>

        <tr>
            <td>
                Name:
            </td>
            <td>
                {{" ".$item['name']}}
            </td>
        </tr>

        <tr>
            <td>
                Bewertungstext:
            </td>
            <td>
                {{" ".$item['bewertungstext']}}
            </td>
        </tr>
        <tr>
            <td>
                Sterne:
            </td>
            <td>
                @for($i = $item['sterne']; $i >0; $i--)

                    <img src="/emensa/public/img/Star-icon.png" alt="Stern Bild">

                @endfor
            </td>
        </tr>
        <tr>
            <td>
                Erfassungsdatum:
            </td>
            <td>
                {{" ".$item['bewertungszeitpunkt']}}
            </td>
        </tr>
    </table>
        @if($admin===true)
            <button onclick="highlightRating({{ $item['bewertungID'] }})">Hervorheben</button>

        @endif

        @endforeach
    <script>
        function highlightRating(bewertungID) {
            window.location.href = '/emensa/public/bewertungen?glowUP=' + encodeURIComponent(bewertungID);
        }
    </script>





@endsection