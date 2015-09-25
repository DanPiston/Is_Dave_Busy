var appControllers = angular.module('appControllers', ['ui.bootstrap']);



/**
 *	who - controller
 *		static description
 *
 */
appControllers.controller('who', ['$scope', '$http', function($scope, $http){


}]);



/**
 *	why - controller
 *		static description
 *
 */
appControllers.controller('why', ['$scope', '$http', function($scope, $http){


}]);


/**
 *	main - controller
 *		just view the basic results
 *
 */
appControllers.controller('main', ['$scope', '$http', function($scope, $http){

	$scope.status = "Loading Calendar Data...";

	$scope.events = {};


	$http.get('api/getEvents/today').
		// http://www.html5rocks.com/en/tutorials/es6/promises/
  		then(function(response) {
    		// this callback will be called asynchronously -when the response is available
    		$scope.status = "Request Complete.";

    		// console.log(response.data.events);
    		var eventCount = response.data.events.length;
    		$scope.status += " " + eventCount + " event(s) found for today.";
    		$scope.events = response.data.events;

  		}, function(response) {
    		// called asynchronously if an error occurs - or server returns response with an error status.
    		$scope.status = "Thank you Mario! But our princess is in another castle!";
  		})
  		.finally(function(){
  			$scope.loadDone = true;
  		});

}]);



/**
 *	main - controller
 *		just view the basic results
 *
 */
appControllers.controller('dance', ['$scope', '$http', function($scope, $http){

	$scope.status = "Loading Dance Data...";

	$scope.events = {};


	$http.get('api/getEvents/today?keyword=dance').
		// http://www.html5rocks.com/en/tutorials/es6/promises/
  		then(function(response) {
    		// this callback will be called asynchronously -when the response is available
    		$scope.status = "Request Complete.";

    		// console.log(response.data.events);
    		var eventCount = response.data.events.length;
    		$scope.status += " " + eventCount + " Super Fun Time DANCE event(s) found for today.";
    		$scope.events = response.data.events;

  		}, function(response) {
    		// called asynchronously if an error occurs - or server returns response with an error status.
    		$scope.status = "Thank you Mario! But our princess is in another castle!";
  		})
  		.finally(function(){
  			$scope.loadDone = true;
  		});

}]);