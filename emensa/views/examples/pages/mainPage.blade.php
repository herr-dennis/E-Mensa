@extends('layouts.layout_main_page')
@section('überschrift', 'Ihre E-Mensa hat wieder geöffnet!')


@section('header')
    <img src="img/mensa_logo.jpg" id="logo" alt="Mensa-Logo">
    <div class="headerlinks">
        <a href="#übersicht">Ankündigung</a>
        <a href="#newstab">Zahlen</a>
        <a href="#preistab">Speisen</a>
        <a href="#footer">Wichtig für uns</a>
    </div>
@endsection


@section('main-content')

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


    <div>
        <table id="preistab">
            <tr>
                <th></th>
                <th>Preis intern</th>
                <th>Preis extern</th>
            </tr>

        @foreach ($data as $item)

         <tr>
            <td>{{$item['name']}}
                </td>
                  <td>
                {{$item['preisintern']}}
                  </td>
                <td>
                {{ $item['preisextern']}}
                  </td>

               </tr>

        <tr>
                <td colspan='3' class='bilder'> <img src='{{$bilder[$loop->iteration-1]}}' alt='{{$bilder[0]}}'></td>
                </tr>

        @endforeach
        </table>


    </div>


@endsection


@section('footer')
    <p>&copy E-Mensa GmbH</p>
    <p>Schwarz, Slusarczyk</p>
    <p><a href="http://localhost:8080">Impressum</a></p>
@endsection