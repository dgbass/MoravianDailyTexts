<?php
set_time_limit(10);
require_once '../src/whatsprot.class.php';
require_once 'DailyTexts.class.php';

//Change to your time zone
date_default_timezone_set('Europe/Berlin');

########## DO NOT COMMIT THIS FILE WITH YOUR CREDENTIALS ###########
///////////////////////CONFIGURATION///////////////////////
//////////////////////////////////////////////////////////
$username = "49173324117";                      // Telephone number including the country code without '+' or '00'.
$password = "iyO1Uim/WBaIRueMj8oAOb2Mh9k=";     // Use registerTool.php or exampleRegister.php to obtain your password
$nickname = "Daniel Glunz";
$debug = false;                                           // Set this to true, to see debug mode.
///////////////////////////////////////////////////////////

function fgets_u($pStdn)
{
	$pArr = array($pStdn);

	if (false === ($num_changed_streams = stream_select($pArr, $write = NULL, $except = NULL, 0))) {
		print("\$ 001 Socket Error : UNABLE TO WATCH STDIN.\n");

		return FALSE;
	} elseif ($num_changed_streams > 0) {
		return trim(fgets($pStdn, 1024));
	}
	return null;
}


function onPresenceAvailable($username, $from)
{
	$dFrom = str_replace(array("@s.whatsapp.net","@g.us"), "", $from);
	echo "<$dFrom is online>\n\n";
}

function onPresenceUnavailable($username, $from, $last)
{
	$dFrom = str_replace(array("@s.whatsapp.net","@g.us"), "", $from);
	echo "<$dFrom is offline>\n\n";
}

echo "[] Logging in as '$nickname' ($username)\n";
//Create the whatsapp object and setup a connection.
$w = new WhatsProt($username, $nickname, $debug);
$w->connect();

// Now loginWithPassword function sends Nickname and (Available) Presence
$w->loginWithPassword($password);

echo "[*] Connected to WhatsApp\n\n";

//get groups
$w->sendGetGroups();
$w->sendGetBroadcastLists();

/*
do the following in a endless loop
due to the fact that we have no 
cronjob or anything similar to
start a job automatically
*/
while(true) {
	/*
	   get Timestamp for today
	 */
	$time = date('H:i', time()); // 10:00
	$today=date('d-m-Y ', time());

	/**
	  only send a message with new daily texts 
	  if time is 08 o clock
	 **/
	if(strcmp($time,"08:00")==0) {

		$dailyTexts= new DailyTexts($today);

		$msg="Losung fuer den " . $today . "\n" 
			. "Watchword: " . $dailyTexts->getWatchword() . "\n"
			. "Doctrine: " .$dailyTexts->getDoctrine() . "\n";

		echo $msg;
		/**
		  Sending message to the group with the daily dext:
		  Where $gId is the group id.
		 **/
		$w->sendMessage($gId, $msg);
		//sleep for 23 hours 
		//sleep(23*60*60);
	}

sleep(59);
$w->sendPing();

}

?>
