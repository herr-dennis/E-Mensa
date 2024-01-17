@extends('layouts.layout_main_page')
@section('überschrift', 'Ihre Bewertungen')
@section('title' ,'Meine Bewertungen')
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
    <p><b>Hallo {{$_SESSION['name']}},</b></p>
    <p>Diese Gerichte haben Sie bewertet! Vielen Dank</p>
    @foreach($data as $item)

        <table >

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
        <button onclick="redirectToMeineBewertung('{{ $item['bewertungszeitpunkt'] }}')" name="{{$item['bewertungszeitpunkt']}}}">Löschen</button>

        <script>
            function redirectToMeineBewertung(name) {
                window.location.href = '/emensa/public/meineBewertung?name=' + encodeURIComponent(name);
            }
        </script>
    @endforeach

@endsection