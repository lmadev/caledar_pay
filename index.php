<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use Lma\Calendar;
use Lma\CreateCsv;

require_once './vendor/autoload.php';

$calendar = new Calendar();
$csv = new CreateCsv($calendar);

$calendar->init();
$csv->create();