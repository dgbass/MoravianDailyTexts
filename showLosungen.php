<?php
require_once("DailyTexts.class.php");
date_default_timezone_set('Europe/Berlin');

ini_set('date.timezone', 'UTC');
$today=date('d.m.Y ', time());

$dailyTexts= new DailyTexts($today);
$time = date('H:i:s', time());

echo "Uhrzeit: " . $time . "\n";

echo "Losung fuer den: " . $today . "\n";

echo "Losungstext:\t" . $dailyTexts->getWatchword() . "\n";
echo "Lehrtext:\t" .$dailyTexts->getDoctrine() . "\n";

?>
