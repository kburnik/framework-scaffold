// Original author: hsubu
// http://plnkr.co/edit/WcLUuXMpd6djYmvVBBIN?p=preview

app

.directive('confirmAction', ['$q', 'dialogModal', function($q, dialogModal) {
  return {
    link: function (scope, element, attrs) {
      // ngClick won't wait for our modal confirmation window to resolve,
      // so we will grab the other values in the ngClick attribute, which
      // will continue after the modal resolves.
      // modify the confirmAction() action so we don't perform it again
      // looks for either confirmAction() or confirmAction('are you sure?')
      var ngClick = attrs.ngClick.replace('confirmAction()', 'true')
        .replace('confirmAction(', 'confirmAction(true,');

      // setup a confirmation action on the scope
      scope.confirmAction = function(msg) {
        // if the msg was set to true, then return it (this is a workaround to make our dialog work)
        if (msg===true) {
          return true;
        }
        // msg can be passed directly to confirmAction('are you sure?') in ng-click
        // or through the confirm-click attribute on the <a confirm-click="Are you sure?"></a>
        msg = msg || attrs.confirmAction || 'Are you sure?';
        var title = attrs.confirmActionTitle || "";
        var okButton = attrs.confirmActionOk || "Ok";
        var cancelButton = attrs.confirmActionCancel || "Cancel";
        // open a dialog modal, and then continue ngClick actions if it's confirmed
        dialogModal(msg, title, okButton, cancelButton).result.then(function() {
          scope.$eval(ngClick);
        });
        // return false to stop the current ng-click flow and wait for our modal answer
        return false;
      };
    }
  }
}])
