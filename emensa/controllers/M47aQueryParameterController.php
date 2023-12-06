<?php

class M47aQueryParameterController
{
    public function show($request)
    {
        $name = $request->input('name', 'default'); // 'default' als Standardwert, falls kein Parameter übergeben wurde
        return view('examples.m4_7a_queryparameter', ['name' => $name]);
    }
}