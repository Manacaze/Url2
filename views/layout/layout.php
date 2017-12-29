  <!-- aside -->
  <div id="aside" class="app-aside modal fade nav-dropdown" ng-class="{'folded': app.setting.folded}">
  	<!-- fluid app aside -->
    <div class="left navside dark dk" layout="column">
  	  <div class="navbar no-radius">
        <div ui-include="'../views/blocks/navbar.brand.php'"></div>
      </div>
      <div flex class="hide-scroll">
          <nav class="scroll nav-light">
            <div ui-include="'../views/blocks/nav.php'"></div>
          </nav>
      </div>
      <div flex-no-shrink class="b-t">
        <div ui-include="'../views/blocks/aside.top.0.php'"></div>
      </div>
    </div>
    
  <!--ie9 (if you want support the vertical scroll in ie9, use the below code.)
    <div class="left navside dark dk">
      <div class="row-col">
        <div class="navbar no-radius">
          <div ui-include="'../views/blocks/navbar.brand.php'"></div>
        </div>
        <div class="row-row">
          <div class="row-body scrollable hover">
            <div class="row-inner">
              <nav class="nav-light">
                <div ui-include="'../views/blocks/nav.php'"></div>
              </nav>
            </div>
          </div>
        </div>
        <div class="b-t">
          <div ui-include="'../views/blocks/aside.top.0.php'"></div>
        </div>
      </div>
    </div>
  -->

  </div>
  <!-- / -->
  
  <!-- content -->
  <div id="content" class="app-content box-shadow-z0" role="main">
    <div class="app-header white box-shadow">
        <div ui-include="'../views/blocks/header.php'"></div>
    </div>
    <div class="app-footer" ng-class="{'hide': $state.current.data.hideFooter}">
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
