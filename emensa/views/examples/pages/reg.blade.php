@extends('layouts.layout_main_page')
@section('überschrift', 'Ihre E-Mensa hat wieder geöffnet!')
@section('title' ,'Reg')
@section('header')
    <img src="img/mensa_logo.jpg" id="logo" alt="Mensa-Logo">

    <script>
        // JavaScript-Code für den Klick auf das Bild
        document.getElementById('logo').addEventListener('click', function() {
            window.location.href = '/emensa/public/'; // Hier die URL deiner Hauptseite einfügen
        });
    </script>
@endsection

@section('main-content')
    <hr>
    <h2>Registrierung</h2>

    <form method="post" >

        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>
        </div>

        <div>
            <label for="email">E-Mail:</label>
            <input type="email" name="email" id="email"  required>
        </div>

        <div>
            <label for="password">Passwort:</label>
            <input type="password" name="password" id="password" required>
        </div>

        <div>
            <label for="password_confirmation">Passwort bestätigen:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <button type="submit">Registrieren</button>
    </form>
@endsection
