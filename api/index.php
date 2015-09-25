<?
/* load composer requires */
require 'vendor/autoload.php';

/* we east siiiide */
date_default_timezone_set("America/New_York");

/* Initiate the Slim app */
$app = new \Slim\Slim(
	array(
		'mode' => 'development',
		'debug' => true
	)
);


/* let's just return JSON */
$app->response->headers->set('Content-Type', 'application/json');


/* root directory GET request */ 
$app->get('/', function () {
    echo "Thank you Mario!<br/><br/>But our princess is in another castle!";
});



$app->get('/:name', function ($name) {
    echo "Thank you ".$name."!<br/><br/>But our princess is in another castle!";
});


/* the calendar request */
$app->get('/getEvents/today/', function () use ($app) {

	$request = $app->request();
	$keyword = $request->get('keyword');

	if(isset($keyword)){
		$events = getEvents(date('Y-m-d', time()), $keyword);
	} else {
		$events = getEvents(date('Y-m-d', time()));
	}
	echo $events;

});





/* run it, so routes actually route */
$app->run();





function getEvents($day, $keyword=null){
	
	$this_days_events = array();

	/* thanks to http://www.daimto.com/google-calendar-api-with-php-service-account/ */
 	require_once 'google-api/autoload.php';
	session_start();	 	
	
	$secrets_file = '../.google.serviceaccount.json';
	$secrets = file_get_contents($secrets_file);	 
	$json = json_decode($secrets);

	$client_id = $json->{'client_id'};
	$Email_address = $json->{'client_email'};
	$key = $json->{'private_key'};
		
	$client = new Google_Client();	 	
	$client->setApplicationName("Client_Library_Examples");
	

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
				// echo "-----".$event->getSummary()."<br>";
				
				// only want events for today.
				if($day != date('Y-m-d', strtotime($event->start->dateTime))){
					continue;
				}

				$summary = $event->getSummary();
				
				// if we have a keyword - only look for those events
				if(isset($keyword) && !strpos(strtoupper($summary), strtoupper($keyword))){
					continue;
				}

				$s = $event->start->dateTime;
				$e = $event->end->dateTime;

				if(date('m/d/Y', strtotime($s)) == date('m/d/Y', strtotime($e))){
					$formatted_start = date('h:i A', strtotime($s));
					$formatted_end = date('h:i A', strtotime($e));
				} else {
					$formatted_start = date('m/d/Y h:i A', strtotime($s));
					$formatted_end = date('m/d/Y h:i A', strtotime($e));
				}

			    array_push($this_days_events, 
			    	array(
			    		'summary'   =>$summary,
			    		'start_time'=>$formatted_start,
			    		'end_time'  =>$formatted_end
			    	)
			    );
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

	return json_encode(array("response"=>"success", "events"=>$this_days_events));
}




