/*
 * angular-ui-bootstrap for bootstrap 4
 * http://themeforest.net/user/flatfull/portfolio

 * License: Flatfull
 */

angular.module('ui.bootstrap.tooltip')
.directive('uibTooltipClasses', function() {
  return {
    restrict: 'A',
    link: function(scope, element, attrs) {
      if (scope.placement) {
        var type = angular.isDefined( attrs['uibPopoverPopup'] ) ? 'popover-' : 'tooltip-';
        element.addClass(type+scope.placement);
      }

      if (scope.popupClass) {
        element.addClass(scope.popupClass);
      }

      if (scope.animation()) {
        element.addClass(attrs.tooltipAnimationClass);
      }
    }
  };
});

angular.module("template/accordion/accordion-group.php", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("template/accordion/accordion-group.php",
    "<div class=\"box m-b-xs {{panelClass || 'panel-default'}}\">\n" +
    "  <div class=\"box-header\" ng-keypress=\"toggleOpen($event)\">\n" +
    "    <h4 class=\"panel-title\">\n" +
    "      <a href tabindex=\"0\" class=\"accordion-toggle\" ng-click=\"toggleOpen()\" uib-accordion-transclude=\"heading\"><span ng-class=\"{'text-muted': isDisabled}\">{{heading}}</span></a>\n" +
    "    </h4>\n" +
    "  </div>\n" +
    "  <div class=\"panel-collapse collapse\" uib-collapse=\"!isOpen\">\n" +
    "	  <div class=\"box-body\" ng-transclude></div>\n" +
    "  </div>\n" +
    "</div>\n" +
    "");
}]);

angular.module("template/carousel/slide.php", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("template/carousel/slide.php",
    "<div ng-class=\"{\n" +
    "    'active': active\n" +
    "  }\" class=\"carousel-item item text-center\" ng-transclude></div>\n" +
    "");
}]);

angular.module("template/tooltip/tooltip-html-popup.php", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("template/tooltip/tooltip-html-popup.php",
    "<div\n" +
    "  tooltip-animation-class=\"fade\"\n" +
    "  uib-tooltip-classes\n" +
    "  ng-class=\"{ in: isOpen() }\">\n" +
    "  <div class=\"tooltip-arrow\"></div>\n" +
    "  <div class=\"tooltip-inner\" ng-bind-html=\"contentExp()\"></div>\n" +
    "</div>\n" +
    "");
}]);

angular.module("template/tooltip/tooltip-popup.php", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("template/tooltip/tooltip-popup.php",
    "<div\n" +
    "  tooltip-animation-class=\"fade\"\n" +
    "  uib-tooltip-classes\n" +
    "  ng-class=\"{ in: isOpen() }\">\n" +
    "  <div class=\"tooltip-arrow\"></div>\n" +
    "  <div class=\"tooltip-inner\" ng-bind=\"content\"></div>\n" +
    "</div>\n" +
    "");
}]);

angular.module("template/tooltip/tooltip-template-popup.php", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("template/tooltip/tooltip-template-popup.php",
    "<div\n" +
    "  tooltip-animation-class=\"fade\"\n" +
    "  uib-tooltip-classes\n" +
    "  ng-class=\"{ in: isOpen() }\">\n" +
    "  <div class=\"tooltip-arrow\"></div>\n" +
    "  <div class=\"tooltip-inner\"\n" +
    "    uib-tooltip-template-transclude=\"contentExp()\"\n" +
    "    tooltip-template-transclude-scope=\"originScope()\"></div>\n" +
    "</div>\n" +
    "");
}]);

angular.module("template/popover/popover-html.php", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("template/popover/popover-html.php",
    "<div tooltip-animation-class=\"fade\"\n" +
    "  uib-tooltip-classes\n" +
    "  ng-class=\"{ in: isOpen() }\">\n" +
    "  <div class=\"popover-arrow\"></div>\n" +
    "\n" +
    "  <div class=\"popover-inner\">\n" +
    "      <h3 class=\"popover-title\" ng-bind=\"title\" ng-if=\"title\"></h3>\n" +
    "      <div class=\"popover-content\" ng-bind-html=\"contentExp()\"></div>\n" +
    "  </div>\n" +
    "</div>\n" +
    "");
}]);

angular.module("template/popover/popover-template.php", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("template/popover/popover-template.php",
    "<div tooltip-animation-class=\"fade\"\n" +
    "  uib-tooltip-classes\n" +
    "  ng-class=\"{ in: isOpen() }\">\n" +
    "  <div class=\"popover-arrow\"></div>\n" +
    "\n" +
    "  <div class=\"popover-inner\">\n" +
    "      <h3 class=\"popover-title\" ng-bind=\"title\" ng-if=\"title\"></h3>\n" +
    "      <div class=\"popover-content\"\n" +
    "        uib-tooltip-template-transclude=\"contentExp()\"\n" +
    "        tooltip-template-transclude-scope=\"originScope()\"></div>\n" +
    "  </div>\n" +
    "</div>\n" +
    "");
}]);

angular.module("template/popover/popover.php", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("template/popover/popover.php",
    "<div tooltip-animation-class=\"fade\"\n" +
    "  uib-tooltip-classes\n" +
    "  ng-class=\"{ in: isOpen() }\">\n" +
    "  <div class=\"popover-arrow\"></div>\n" +
    "\n" +
    "  <div class=\"popover-inner\">\n" +
    "      <h3 class=\"popover-title\" ng-bind=\"title\" ng-if=\"title\"></h3>\n" +
    "      <div class=\"popover-content\" ng-bind=\"content\"></div>\n" +
    "  </div>\n" +
    "</div>\n" +
    "");
}]);

angular.module("template/progressbar/bar.php", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("template/progressbar/bar.php",
    "<div class=\"progress-bar\" ng-class=\"type && type\" role=\"progressbar\" aria-valuenow=\"{{value}}\" aria-valuemin=\"0\" aria-valuemax=\"{{max}}\" ng-style=\"{width: (percent < 100 ? percent : 100) + '%'}\" aria-valuetext=\"{{percent | number:0}}%\" aria-labelledby=\"{{::title}}\" style=\"min-width: 0;\" ng-transclude></div>\n" +
    "");
}]);

angular.module("template/progressbar/progressbar.php", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("template/progressbar/progressbar.php",
    "<div class=\"progress\">\n" +
    "  <div class=\"progress-bar\" ng-class=\"type && type\" role=\"progressbar\" aria-valuenow=\"{{value}}\" aria-valuemin=\"0\" aria-valuemax=\"{{max}}\" ng-style=\"{width: (percent < 100 ? percent : 100) + '%'}\" aria-valuetext=\"{{percent | number:0}}%\" aria-labelledby=\"{{::title}}\" style=\"min-width: 0;\" ng-transclude></div>\n" +
    "</div>\n" +
    "");
}]);

angular.module("template/tabs/tab.php", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("template/tabs/tab.php",
    "<li class=\"nav-item\" ng-class=\"{active: active, disabled: disabled}\">\n" +
    "  <a class=\"nav-link\"href ng-click=\"select()\" uib-tab-heading-transclude>{{heading}}</a>\n" +
    "</li>\n" +
    "");
}]);

