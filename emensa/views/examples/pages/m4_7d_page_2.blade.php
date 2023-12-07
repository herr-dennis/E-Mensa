@extends('layouts.m4_7d_layout')



@section('title', 'Page_2')
@section('which_side', 'Page 2!')
<p>Ich wurde mit yield aufgerufen!</p>

@section('sidebar')

    <h2>Wenn ich keine Sidebar wäre, wäre ich ein Footer</h2>

@endsection

@section('main-content')
<ol>
@for($i =0 ; $i < 10; $i++)

    <li>Ich bin die Summe aus x und y = {{$i*3}}</li>
    <li>Ich bin das Produkt aus y und x = {{$i*2}} </li>
@endfor
</ol>
@endsection
