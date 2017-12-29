  <!-- aside -->
  <div id="aside" class="app-aside modal fade folded md show-text nav-dropdown" ng-class="{'folded': app.setting.folded}">
    <div class="left navside black dk" layout="column">
      <div class="navbar no-radius">
        <div ui-include="'../views/blocks/navbar.brand.php'"></div>
      </div>
      <div flex class="hide-scroll">
          <nav class="scroll nav-active-{{app.setting.theme.primary}}">
            <div ui-include="'../views/blocks/nav.php'"></div>
          </nav>
      </div>
      <div flex-no-shrink>
        <div ui-include="'../views/blocks/aside.top.1.php'"></div>
      </div>
    </div>
  </div>
  <!-- / aside -->
  
  <!-- content -->
  <div id="content" class="app-content box-shadow-z3" role="main">
    <div class="app-header white box-shadow">
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
