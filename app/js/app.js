var app = angular.module('IsDaveBusy', [
	'ngRoute',
	'appControllers'
]);

app.config(['$routeProvider', function($routeProvider){

	$routeProvider.
	
	when('/', {
		templateUrl: 'app/partials/main.html',
		controller: 'main'
	}).

	when('/who', {
		templateUrl: 'app/partials/who.html',
		controller: 'who'
	}).

	when('/why', {
		templateUrl: 'app/partials/why.html',
		controller: 'why'
	}).

	when('/dance', {
		templateUrl: 'app/partials/dance.html',
		controller: 'dance'
	}).

	otherwise({
		redirectTo: '/'
	});

}]);