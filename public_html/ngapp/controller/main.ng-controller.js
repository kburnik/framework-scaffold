app

.controller("MainController",
    function(UserService, $rootScope, $scope, $location) {

  $rootScope.user == null
  $rootScope.ready = false;

  $rootScope.handleUnauthorizedAccess = function(details) {
    $rootScope.$emit('error', details);
    $location.path("#/");
  }

  UserService.getCurrentUserAsync()
    .ready(function(user) {
      $rootScope.user = user;
    })
    .then(function(){
      $rootScope.ready = true;
    })
})
