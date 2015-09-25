<?php
date_default_timezone_set("America/New_York");

 require_once 'google-api/autoload.php';
   session_start();	 	
/************************************************	
 The following 3 values an be found in the setting	
 for the application you created on Google 	 	
 Developers console.	 	 Developers console.
 The Key file should be placed in a location	 
 that is not accessible from the web. outside of 
 web root.	 
 	 	 
 In order to access your GA account you must	
 Add the Email address as a user at the 	
 ACCOUNT Level in the GA admin. 	 	
 ************************************************/
$client_id = '909207320465-6ecpb9dpskf89i0talb2c1vijldaobe2.apps.googleusercontent.com';
$Email_address = '909207320465-6ecpb9dpskf89i0talb2c1vijldaobe2@developer.gserviceaccount.com';	 
$key_file_location = '../.google.serviceaccount.json';	 	
	
$client = new Google_Client();	 	
$client->setApplicationName("Client_Library_Examples");
$secrets = file_get_contents($key_file_location);	 
$json = json_decode($secrets);
$key = $json->{'private_key'};

// separate additional scopes with a comma	 
$scopes ="https://www.googleapis.com/auth/calendar.readonly"; 	
$cred = new Google_Auth_AssertionCredentials(	 
	$Email_address,	 	 
	array($scopes),	 	
	$key	 	 
	);	 	


$client->setAssertionCredentials($cred);
if($client->getAuth()->isAccessTokenExpired()) {	 	

	try {
  		$client->getAuth()->refreshTokenWithAssertion($cred);
	} catch (Exception $e) {
  		var_dump($e->getMessage());
	} 	

}	 	

$service = new Google_Service_Calendar($client);    

?>

<html><body>

<?php

$events_today = array();


try{
	$calendarList  = $service->calendarList->listCalendarList();
} catch (Exception $e){
	var_dump($e->getMessage());
}

while(true) {

	foreach ($calendarList->getItems() as $calendarListEntry) {

			/* calendar id/ email address - in this case just mine */
			// echo $calendarListEntry->getSummary()."<br>\n";

			// get events 
			$events = $service->events->listEvents($calendarListEntry->id);

			foreach ($events->getItems() as $event) {
				
				$start = $event->start->dateTime;
				date('m/d/Y h:i A', strtotime($start));


			    // echo "-----".$event->getSummary()."<br>";
			}
		}
		$pageToken = $calendarList->getNextPageToken();
		if ($pageToken) {
			$optParams = array('pageToken' => $pageToken);
			$calendarList = $service->calendarList->listCalendarList($optParams);
		} else {
			break;
		}
	}

?>