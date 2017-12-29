---
layout: base.php
---
  <!-- content -->
  <div id="content" class="app-content box-shadow-z0" role="main">
    <div class="app-header navbar-md white box-shadow">
      <div ui-include="'../views/blocks/header.4.php'"></div>
    </div>
    <div ui-view class="app-body" id="view">

<!-- ############ PAGE START-->
{{> body}}
<!-- ############ PAGE END-->

    </div>
    <div class="dark dk pos-rlt">
      <div class="p-md">
        <div ui-include="'../views/blocks/footer.1.php'"></div>
      </div>
    </div>
  </div>
  <!-- / -->

  <!-- theme switcher -->
  <div id="switcher">
    {{>switcher.php}}
  </div>
  <!-- / -->
