<?php
use Illuminate\Database\Capsule\Manager;

$capsule = new Manager;
$capsule->addConnection([
    "driver" => "mysql",
    "host" => "localhost",
    "database" => "emensawerbeseite",
    "username" => "root",
    "password" => "123"
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();