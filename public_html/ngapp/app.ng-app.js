var app = angular.module(
    "myapp" ,
    ['ngRoute', 'ngAnimate', 'ui.bootstrap', 'ui.bootstrap.typeahead', 'ui',
     'angularFileUpload'],
    function($routeProvider , $locationProvider) {

  $routeProvider
    .otherwise({
      redirectTo: '/'
    });

});
