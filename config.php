<?php
require 'vendor/autoload.php';

$app = new \Slim\Slim();
$app->config(array(
'debug' => true,
'templates.path' => 'views'
));
$db = new PDO('mysql:host=localhost;dbname=domotechnika;charset=utf8','root','');