
<!-- ############ LAYOUT START-->

<!-- aside -->
<div id="aside" class="app-aside box-shadow-z3 modal fade lg nav-expand">
    <div class="left navside white dk" layout="column">
        <div class="navbar navbar-md blue-800 no-radius box-shadow-z4">
            <!-- brand -->
            <a class="navbar-brand" href="<?=principal?>">
                <img src="assets/images/2.png" alt="." class="">
                <span class="hidden-folded inline">System</span>
            </a>
            <!-- / brand -->
        </div>
        <div flex class="hide-scroll">
            <nav class="scroll">
                <?php include 'views/blocks/aside.top.3.php'; ?>

                <ul class="nav" ui-nav>
                    <li class="nav-header hidden-folded">
                        <small class="text-muted">Main</small>
                    </li>

                    <li>
                        <a href="<?=principal?>">
                  <span class="nav-icon">
                    <i class="material-icons">&#xe3fc;
                      <span ui-include="'assets/images/i_0.svg'"></span>
                    </i>
                  </span>
                            <span class="nav-text">Painel Inicial</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div flex-no-shrink>
            <a href="<?=principal?>logout">
                <div ui-include="'views/blocks/aside.bottom.1.php'"></div>
            </a>
        </div>
    </div>
</div>
<!-- / aside -->

<!-- content -->
<div id="content" class="app-content box-shadow-z3" role="main">
    <div class="app-header blue-800 box-shadow-z4 navbar-md">
        <div class="navbar">
            <a data-toggle="collapse" data-target="#navbar-4" class="navbar-item pull-right hidden-md-up m-a-0 m-l">
                <i class="material-icons">&#xe5d2;</i>
            </a>
            <!-- Open side - Naviation on mobile -->
            <a data-toggle="modal" data-target="#aside" class="navbar-item pull-left hidden-lg-up">
                <i class="material-icons">&#xe5d2;</i>
            </a>
            <!-- / -->
            <!-- nabar right -->
            <ul class="nav navbar-nav pull-right">
                <!--<li class="nav-item dropdown">
            <a href class="nav-link" data-toggle="dropdown">
              <i class="material-icons">&#xe7f5;</i>
              <span class="label up p-a-0 warn"></span>
            </a>
             <?php //include "views/blocks/dropdown.notification.php"; ?>
          </li>-->
                <li class="nav-item dropdown">
                    <a href class="nav-link dropdown-toggle clear" data-toggle="dropdown">
              <span class="avatar w-32">
                <img src="assets/images/usuarios/avatarHomem.jpg" alt="..." >
                <i class="busy b-white right"></i>
              </span>
                    </a>
                    <?php include "views/blocks/dropdown.user.php";?>
                </li>
            </ul>
            <!-- / navbar right -->
            <!-- navbar collapse -->
            <div class="collapse navbar-toggleable-sm" id="navbar-4">
                <!-- link and dropdown -->
                <!-- / link and dropdown -->
            </div>
            <!-- / navbar collapse -->
        </div>

    </div>
    <div class="app-footer">
        <div class="p-a text-xs">
            <div class="pull-right text-muted">
                &copy; Copyright <strong>System</strong> <span class="hidden-xs-down">- Direitos Reservados</span>
                <a ui-scroll-to="content"><i class="fa fa-long-arrow-up p-x-sm"></i></a>
            </div>
            <div class="nav">
                <a class="nav-link" href="">Sobre</a>
                <span class="text-muted">-</span>
                <a class="nav-link label blue-800" href="#">Ver o Site</a>
            </div>
        </div>
    </div>
    <div class="app-body" id="view">
