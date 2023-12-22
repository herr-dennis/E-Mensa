@extends('layouts.layout_main_page')
@section('überschrift', 'Ihr Profil')
@section('title' ,'Profil')
@section('header')
    <img src="img/mensa_logo.jpg" id="logo" alt="Mensa-Logo">
@endsection
<hr>
@section('main-content')


    <p>Ihre Daten:</p>
     <table>
             @foreach($daten as $item)
                 @foreach($item as $key => $value)
                     <tr>
                         <td>
                             {{ucfirst($key)}}
                         </td>
                         <td>
                             {{$value}}
                         </td>
                     </tr>
                 @endforeach
             @endforeach

     </table>

     <button name="back" onclick="back_()">Zurück</button>
    <script>
        function back_(){
            window.location.href = "/emensa/public/";
        }

    </script>


@endsection