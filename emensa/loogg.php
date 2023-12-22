
<?php
require_once 'vendor/autoload.php';
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('name');
$log->pushHandler(new StreamHandler('/beispiele/logs.txt', Level::Warning));

// add records to the log
$log->warning('Foo');
$log->error('Bar');

echo "dad";