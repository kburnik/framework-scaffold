app

.directive('keyboardShortcut', function (MousetrapService) {
  return function(scope, element, attrs) {

  MousetrapService.bindGlobal(attrs.keyboardShortcut, function(e) {
    if (attrs.disabled) {
      console.warn("Shortcut key function prevented. Element disabled.");
      e.preventDefault();

      return;
    }

    element.trigger("click");
    e.preventDefault();
  });

  };
})