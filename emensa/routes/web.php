<?php
/**
 * Mapping of paths to controllers.
 * Note, that the path only supports one level of directory depth:
 *     /demo is ok,
 *     /demo/subpage will not work as expected
 */

return array(
    '/emensa/public/'             => "MainPageController@mainPageController",
    '/emensa/public/reg' => 'AnmeldungController@reg',
    '/emensa/public/bewertungen' => 'BewertungController@bewertungen',
    '/emensa/public/meineBewertung' => 'BewertungController@meineBewertung',
    '/emensa/public/anmeldung' => 'AnmeldungController@anmeldung',
    '/emensa/public/profil' => 'ProfilController@profil',
    '/emensa/public/abmelden' => 'AnmeldungController@abmelden',
    '/emensa/public/ver' => 'AnmeldungController@ver',
    "/emensa/public/demo"         => "DemoController@demo",
    '/dbconnect'    => 'DemoController@dbconnect',
    '/debug'        => 'HomeController@debug',
    '/error'        => 'DemoController@error',
    '/requestdata'   => 'DemoController@requestdata',

    // Erstes Beispiel:
    '/m4_6a_queryparameter' => 'ExampleController@m4_6a_queryparameter',
    '/m4' => 'ExampleController@m4_6a_queryparameter',
    '/emensa/public/m4_6a_queryparameter' => 'ExampleController@m4_6a_queryparameter',
    '/emensa/public/m4_7a_queryparameter' => 'ExampleController@m4_7a_queryparameter',
    '/emensa/public/m4_7b_kategorie' => 'ExampleController@m4_7b_kategorie',
    '/emensa/public/m4_7c_gerichte' => 'ExampleController@m4_7c_gerichte',

    '/emensa/public/m4_7d_page' => 'ExampleController@m4_7d_page',

    );