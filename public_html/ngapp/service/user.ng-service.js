app

.service('UserService', function(api) {

  var userApi = api('/api').use('User');
  userApi.extend('getCurrentUser');

  var s = {
    getCurrentUserAsync: function() {
      return userApi.getCurrentUser();
    }
  };

  return s;
})
