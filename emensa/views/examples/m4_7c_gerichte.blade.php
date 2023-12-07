<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Der Name</title>
</head>
<body>

<hr>
@if(!empty($data))

    <p>Preise sind absteigenden sortiert!</p>
    <table>
    @foreach($data as $value)
        <tr>
        @if($loop->even)
            <td>
            {{ $value['name'] }}
                </td>
            <td>
                {{ $value['preisintern'] }}
            </td>
            @else
            <td>
            <b>{{ $value['name'] }}</b>
                </td>
            <td>
                <b>{{ $value['preisintern'] }}</b>
            </td>
        @endif
        </tr>
    @endforeach
    </table>
<hr>
@else
<p>Es sind keine Gerichte vorhanden!</p>
@endif

</body>
</html>


