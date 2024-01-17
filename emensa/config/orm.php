<?php
use Illuminate\Database\Capsule\Manager;

$capsule = new Manager;
$capsule->addConnection([
    "driver" => "mysql",
    "host" => "localhost",
    "database" => "emensawerbeseite",
    "username" => "root",
    "password" => "ihesp"
]);
$capsule->setAsGlobal();
$capsule->bootEloquent();