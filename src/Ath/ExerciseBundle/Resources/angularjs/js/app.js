'use strict';


// Declare app level module which depends on filters, and services
angular.module('myApp', [
  'ngRoute',
  'myApp.filters',
  'myApp.services',
  'myApp.directives',
  'myApp.controllers'
]).
config(['$routeProvider', '$interpolateProvider', function($routeProvider, $interpolateProvider) {
  $routeProvider.when('/init', {templateUrl: Routing.generate('ath_exercise_init'), controller: 'InitCtrl'});
  $routeProvider.when('/score', {templateUrl: Routing.generate('ath_exercise_score'), controller: 'ScoreCtrl'});
  $routeProvider.when('/exercise/:exerciseId', {templateUrl: Routing.generate('ath_exercise_blank_view'), controller: 'ExerciseCtrl'});
  $routeProvider.when('/exercise/create/:typeExo', {templateUrl: Routing.generate('ath_exercise_blank_view'), controller: 'ExerciseCreateCtrl'});
  $routeProvider.when('/admin', {templateUrl: Routing.generate('ath_exercise_blank_view'), controller: 'AdminCtrl'});
  $routeProvider.otherwise({redirectTo: '/init'});

  $interpolateProvider.startSymbol('{[{');
  $interpolateProvider.endSymbol('}]}');
}]);

