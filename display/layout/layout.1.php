---
layout: base.php
---
  <!-- aside -->
  <div id="aside" class="app-aside modal fade nav-expand">
    <div class="left navside black dk" layout="column">
      <div class="navbar no-radius">
        {{>navbar.brand}}
      </div>
      <div flex-no-shrink>
        <div ui-include="'../views/blocks/aside.top.2.php'"></div>
      </div>
      <div flex class="hide-scroll">
        <nav class="scroll nav-stacked nav-active-{{app.setting.theme.primary}}">
          {{>nav.php}}
        </nav>
      </div>
      <div flex-no-shrink>
        <div ui-include="'../views/blocks/aside.bottom.0.php'"></div>
      </div>
    </div>
  </div>
  <!-- / aside -->
  
  <!-- content -->
  <div id="content" class="app-content box-shadow-z1" role="main">
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
  <!-- / content -->

  <!-- theme switcher -->
  <div id="switcher">
    {{>switcher.php}}
  </div>
  <!-- / -->
