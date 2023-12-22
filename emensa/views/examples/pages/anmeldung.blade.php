
@extends('layouts.layout_main_page')
@section('überschrift', 'Ihre E-Mensa hat wieder geöffnet!')
@section('title' ,'Anmeldung')
@section('header')
<img src="img/mensa_logo.jpg" id="logo" alt="Mensa-Logo">
@endsection
<hr>
@section('main-content')

    <form name="ameldung_form" method="post" action="/emensa/public/ver">
    <label for="input_email">E-Mail</label>
    <input type="text"  name="email_input" value="Ihre Email" id="input_email" onfocus="hide_text(this,'Ihre Email')">
    <label for="input_pw">Passwort</label>
    <input type="text" name="pw_input" value="Passwort" id="input_pw" onfocus="hide_text(this, 'Passwort')">
     <input type="submit" value="Einloggen">
    </form>
    @if(!empty($_SESSION['error_msg']))
            <?php $msg = $_SESSION['error_msg']; ?>
        <label id="wrong">{{ $msg }}</label>

    @endif

    <script>
        function hide_text(input, placeholder) {
            if (input.value === placeholder) {
                input.value = "";
            }
        }
    </script>

@endsection

