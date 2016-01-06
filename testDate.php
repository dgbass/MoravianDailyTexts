<?php
require_once("DailyTexts.class.php");
date_default_timezone_set('Europe/Berlin');

ini_set('date.timezone', 'UTC');
$today=date('d.m.Y ', time());

$dailyTexts= new DailyTexts($today);
echo "Losung fuer den: " . $today . "\n";

echo "Losungstext: " . $dailyTexts->getWatchword() . "\n";
echo "Lehrtext: " .$dailyTexts->getDoctrine() . "\n";

?>
