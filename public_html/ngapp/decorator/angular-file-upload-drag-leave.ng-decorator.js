(function () {
  'use strict';
  app.config(function ($provide) {
    $provide.decorator('nvFileOverDirective', function ($delegate) {
      var directive = $delegate[0],
        link = directive.link;

      directive.compile = function () {
        return function (scope, element, attrs) {
          var overClass = attrs.overClass || 'nv-file-over';
          link.apply(this, arguments);
          element.on('dragleave', function () {
            $(this).removeClass(overClass);
          });
        };
      };

      return $delegate;
    });
  });
})();