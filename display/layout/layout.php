---
layout: base.php
---
  <!-- aside -->
  <div id="aside" class="app-aside modal fade nav-dropdown">
  	<!-- fluid app aside -->
    <div class="left navside dark dk" layout="column">
  	  <div class="navbar no-radius">
        {{>navbar.brand}}
      </div>
      <div flex class="hide-scroll">
          <nav class="scroll nav-light">
            {{>nav.php}}
          </nav>
      </div>
      <div flex-no-shrink class="b-t">
        {{>aside.top}}
      </div>
    </div>
  </div>
  <!-- / -->
  
  <!-- content -->
  <div id="content" class="app-content box-shadow-z0" role="main">
    <div class="app-header white box-shadow">
        {{>header}}
    </div>
    <div class="app-footer">
      {{>footer}}
    </div>
    <div ui-view class="app-body" id="view">

<!-- ############ PAGE START-->
{{> body}}
<!-- ############ PAGE END-->

    </div>
  </div>
  <!-- / -->

  <!-- theme switcher -->
  <div id="switcher">
    {{>switcher.php}}
  </div>
  <!-- / -->
