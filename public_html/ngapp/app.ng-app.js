var app = angular.module(
    "app" ,
    ['ngRoute', 'ngAnimate', 'ui.bootstrap', 'ui.bootstrap.typeahead', 'ui',
     'angularFileUpload'],
    function($routeProvider , $locationProvider) {

  $routeProvider
    .otherwise({
      redirectTo: '/'
    });

});
