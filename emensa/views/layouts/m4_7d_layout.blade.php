
<!DOCTYPE html>
<html lang="de">
<head>
    <style>
        td{
            border: 2px solid grey;
            padding: 5px;
        }

        main{

            border: 2px dotted red;
        }

        .sidebar{
            width: 20%;
            border: 2px solid green;
            margin-top: 10%;
        }


    </style>
    <title>App Name - @yield('title')</title>
</head>
<body>
@yield('which_side')
<main>
@section('main-content')
@show
<div class="sidebar" >
@section('sidebar')
    Master sidebar.
@show
</div>
<div class="container">
    @yield('content')
</div>
</main>

<footer>
    @section('footer')
    <p>&copy; Ich bin ein Fuß</p>
    @show
</footer>
</body>
</html>