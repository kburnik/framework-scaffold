app

.directive('preventDefault', function() {
  return function(scope, element, attrs) {
    element.on("click", function(event) {
      event.preventDefault();

      if (element.hasClass("disabled") || element.parent().hasClass("disabled"))
        return false;
    });
  };
})

