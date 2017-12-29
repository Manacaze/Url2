  <!-- aside -->
  <div id="aside" class="app-aside box-shadow-z3 modal fade lg nav-expand" ng-class="{'folded': app.setting.folded}">
  	<div class="left navside white dk" layout="column">
      <div class="navbar navbar-md {{app.setting.theme.primary}} no-radius box-shadow-z4">
        <div ui-include="'../views/blocks/navbar.brand.white.php'"></div>
      </div>
      <div flex class="hide-scroll">
        <nav class="scroll">
          <div ui-include="'../views/blocks/aside.top.4.php'"></div>
          <div ui-include="'../views/blocks/nav.php'"></div>
        </nav>
      </div>
      <div flex-no-shrink>
        <div ui-include="'../views/blocks/aside.bottom.1.php'"></div>
      </div>
    </div>
  </div>
  <!-- / aside -->
  
  <!-- content -->
  <div id="content" class="app-content box-shadow-z3" role="main">
    <div class="app-header {{app.setting.theme.primary}} box-shadow-z4 navbar-md">
        <div ui-include="'../views/blocks/header.php'"></div>
    </div>
    <div class="app-footer">
      <div ui-include="'../views/blocks/footer.php'"></div>
    </div>
    <div ui-view class="app-body" id="view"></div>
  </div>
  <!-- / -->

  <!-- theme switcher -->
  <div id="switcher">
    <div ui-include="'../views/blocks/switcher.php'"></div>
  </div>
  <!-- / -->
