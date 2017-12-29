/**
 * @ngdoc function
 * @name app.config:uiRouter
 * @description
 * # Config
 * Config for the router
 */
(function() {
    'use strict';
    angular
      .module('app')
      .run(runBlock)
      .config(config);

      runBlock.$inject = ['$rootScope', '$state', '$stateParams'];
      function runBlock($rootScope,   $state,   $stateParams) {
          $rootScope.$state = $state;
          $rootScope.$stateParams = $stateParams;        
      }

      config.$inject =  ['$stateProvider', '$urlRouterProvider', 'MODULE_CONFIG'];
      function config( $stateProvider,   $urlRouterProvider,   MODULE_CONFIG ) {
        
        var p = getParams('layout'),
            l = p ? p + '.' : '',
            layout = '../views/layout/layout.'+l+'html',
            dashboard = '../views/dashboard/dashboard.'+l+'html';

        $urlRouterProvider
          .otherwise('/app/dashboard');
        $stateProvider
          .state('app', {
            abstract: true,
            url: '/app',
            views: {
              '': {
                templateUrl: layout
              }
            }
          })
            .state('app.dashboard', {
              url: '/dashboard',
              templateUrl: dashboard,
              data : { title: 'Dashboard' },
              controller: "ChartCtrl",
              resolve: load(['scripts/controllers/chart.js'])
            })

            // applications

            .state('app.contact', {
              url: '/contact',
              templateUrl: 'apps/contact/main.php',
              data : { title: 'Contacts', hideFooter: true },
              controller: 'ContactCtrl',
              resolve: load('apps/contact/contact.js')
            })

            .state('app.calendar', {
              url: '/calendar',
              templateUrl: 'apps/calendar/main.php',
              data : { title: 'Calendar' },
              controller: 'FullcalendarCtrl',
              resolve: load(['moment','fullcalendar','ui.calendar','apps/calendar/calendar.js'])
            })

            .state('app.todo', {
              url: '/todo',
              templateUrl: 'apps/todo/todo.php',
              data : { title: 'Todo' },
              controller: 'TodoCtrl',
              resolve: load('apps/todo/todo.js')
            })
            .state('app.todo.list', {
                url: '/{fold}'
            })

            .state('app.note', {
              url: '/note',
              templateUrl: 'apps/note/main.php',
              data : { title: 'Note', hideFooter: true }
            })
            .state('app.note.list', {
              url: '/list',
              templateUrl: 'apps/note/list.php',
              data : { title: 'Note'},
              controller: 'NoteCtrl',
              resolve: load(['apps/note/note.js', 'moment'])
            })
            .state('app.note.item', {
              url: '/{id}',
              views: {
                '': {
                  templateUrl: 'apps/note/item.php',
                  controller: 'NoteItemCtrl',
                  resolve: load(['apps/note/note.js', 'moment'])
                }
              },
              data : { title: 'Note' }
            })

            // ui router
            .state('app.layout', {
              url: '/layout',
              template: '<div ui-view></div>'
            })
              .state('app.layout.header', {
                url: '/header',
                templateUrl: '../views/ui/headers.php',
                data : { title: 'Headers' }
              })
              .state('app.layout.aside', {
                url: '/aside',
                templateUrl: '../views/ui/asides.php',
                data : { title: 'Asides' }
              })
              .state('app.layout.footer', {
                url: '/footer',
                templateUrl: '../views/ui/footers.php',
                data : { title: 'Footers' }
              })

            .state('app.inbox', {
                url: '/inbox',
                templateUrl: 'apps/inbox/main.php',
                data : { title: 'Inbox'},
                controller: 'MainCtrl',
                resolve: load( ['apps/inbox/inbox.js','moment'] )
            })
            .state('app.inbox.list', {
                url: '/inbox/{fold}',
                templateUrl: 'apps/inbox/list.php',
                controller: 'ListCtrl'
            })
            .state('app.inbox.item', {
                url: '/{id:[0-9]{1,4}}',
                templateUrl: 'apps/inbox/item.php',
                controller: 'DetailCtrl'
            })
            .state('app.inbox.compose', {
                url: '/compose',
                templateUrl: 'apps/inbox/new.php',
                controller: 'NewCtrl',
                resolve: load( ['summernote', 'ui.select'] )
            })

            // widget router
            .state('app.widget', {
              url: '/widget',
              templateUrl: '../views/ui/widget.php',
              data : { title: 'Widgets' }
            })

            // ui router
            .state('app.ui', {
              url: '/ui',
              template: '<div ui-view></div>'
            })
              .state('app.ui.arrow', {
                url: '/arrow',
                templateUrl: '../views/ui/arrow.php',
                data : { title: 'Arrows' }
              })
              .state('app.ui.box', {
                url: '/box',
                templateUrl: '../views/ui/box.php',
                data : { title: 'Box' }
              })
              .state('app.ui.label', {
                url: '/label',
                templateUrl: '../views/ui/label.php',
                data : { title: 'Labels' }
              })
              .state('app.ui.button', {
                url: '/button',
                templateUrl: '../views/ui/button.php',
                data : { title: 'Buttons' }
              })
              .state('app.ui.color', {
                url: '/color',
                templateUrl: '../views/ui/color.php',
                data : { title: 'Colors' }
              })
              .state('app.ui.dropdown', {
                url: '/dropdown',
                templateUrl: '../views/ui/dropdown.php',
                data : { title: 'Dropdowns' }
              })
              .state('app.ui.grid', {
                url: '/grid',
                templateUrl: '../views/ui/grid.php',
                data : { title: 'Grids' }
              })
              .state('app.ui.icon', {
                url: '/icons',
                templateUrl: '../views/ui/icon.php',
                data : { title: 'Icons' }
              })
              .state('app.ui.list', {
                url: '/list',
                templateUrl: '../views/ui/list.php',
                data : { title: 'Lists' }
              })
              .state('app.ui.modal', {
                url: '/modal',
                templateUrl: '../views/ui/modal.php',
                data : { title: 'Modals' }
              })
              .state('app.ui.nav', {
                url: '/nav',
                templateUrl: '../views/ui/nav.php',
                data : { title: 'Navs' }
              })
              .state('app.ui.progress', {
                url: '/progress',
                templateUrl: '../views/ui/progress.php',
                data : { title: 'Progress' }
              })
              .state('app.ui.social', {
                url: '/social',
                templateUrl: '../views/ui/social.php',
                data : { title: 'Social' }
              })
              .state('app.ui.sortable', {
                url: '/sortable',
                templateUrl: '../views/ui/sortable.php',
                data : { title: 'Sortable' }
              })
              .state('app.ui.streamline', {
                url: '/streamline',
                templateUrl: '../views/ui/streamline.php',
                data : { title: 'Streamlines' }
              })
              .state('app.ui.timeline', {
                url: '/timeline',
                templateUrl: '../views/ui/timeline.php',
                data : { title: 'Timelines' }
              })
              .state('app.ui.angularstrap', {
                url: '/angularstrap',
                templateUrl: '../views/ui/ng.angularstrap.php',
                data : { title: 'AngularStrap' },
                resolve: load(['mgcrea.ngStrap','scripts/controllers/angularstrap.js'])
              })
              .state('app.ui.bootstrap', {
                url: '/bootstrap',
                templateUrl: '../views/ui/ng.bootstrap.php',
                data : { title: 'UI Bootstrap' },
                resolve: load(['ui.bootstrap','scripts/controllers/bootstrap.js'])
              })
              .state('app.googlemap', {
                url: '/googlemap',
                templateUrl: '../views/ui/ng.google.php',
                data : { title: 'Gmap', hideFooter: true },
                controller: 'GoogleMapCtrl',
                //resolve: load(['ui.map', 'scripts/controllers/googlemap.js'], function(){ })
                resolve: load(['ui.map', 'scripts/controllers/load-google-maps.js', 'scripts/controllers/googlemap.js'], function(){ return loadGoogleMaps(); })
              })
              .state('app.ui.vectormap', {
                url: '/vectormap',
                templateUrl: '../views/ui/map.vector.php',
                data : { title: 'Vector Map' },
                controller: 'ChartCtrl',
                resolve: load('scripts/controllers/chart.js')
              })

            // form routers
            .state('app.form', {
              url: '/form',
              template: '<div ui-view></div>'
            })
              .state('app.form.layout', {
                url: '/layout',
                templateUrl: '../views/form/form.layout.php',
                data : { title: 'Layouts' }
              })
              .state('app.form.element', {
                url: '/element',
                templateUrl: '../views/form/form.element.php',
                data : { title: 'Elements' }
              })              
              .state('app.form.validation', {
                url: '/validation',
                templateUrl: '../views/form/ng.validation.php',
                data : { title: 'Validations' }
              })
              .state('app.form.select', {
                url: '/select',
                templateUrl: '../views/form/ng.select.php',
                data : { title: 'Selects' },
                controller: 'SelectCtrl',
                resolve: load(['ui.select','scripts/controllers/select.js'])
              })
              .state('app.form.editor', {
                url: '/editor',
                templateUrl: '../views/form/ng.editor.php',
                data : { title: 'Editor' },
                controller: 'EditorCtrl',
                resolve: load(['summernote','scripts/controllers/editor.js'])
              })
              .state('app.form.slider', {
                url: '/slider',
                templateUrl: '../views/form/ng.slider.php',
                data : { title: 'Slider' },
                controller: 'SliderCtrl',
                resolve: load(['vr.directives.slider','scripts/controllers/slider.js'])
              })
              .state('app.form.tree', {
                url: '/tree',
                templateUrl: '../views/form/ng.tree.php',
                data : { title: 'Tree' },
                controller: 'TreeCtrl',
                resolve: load(['angularBootstrapNavTree','scripts/controllers/tree.js'])
              })
              .state('app.form.file-upload', {
                url: '/file-upload',
                templateUrl: '../views/form/ng.file-upload.php',
                data : { title: 'File upload' },
                controller: 'UploadCtrl',
                resolve: load(['angularFileUpload', 'scripts/controllers/upload.js'])
              })
              .state('app.form.image-crop', {
                url: '/image-crop',
                templateUrl: '../views/form/ng.image-crop.php',
                data : { title: 'Image Crop' },
                controller: 'ImgCropCtrl',
                resolve: load(['ngImgCrop','scripts/controllers/imgcrop.js'])
              })
              .state('app.form.editable', {
                url: '/editable',
                templateUrl: '../views/form/ng.xeditable.php',
                data : { title: 'Xeditable' },
                controller: 'XeditableCtrl',
                resolve: load(['xeditable','scripts/controllers/xeditable.js'])
              })

            // table routers
            .state('app.table', {
              url: '/table',
              template: '<div ui-view></div>'
            })
              .state('app.table.static', {
                url: '/static',
                templateUrl: '../views/table/static.php',
                data : { title: 'Static' }
              })
              .state('app.table.datatable', {
                url: '/datatable',
                data : { title: 'Datatable' },
                templateUrl: '../views/table/datatable.php'
              })
              .state('app.table.footable', {
                url: '/footable',
                data : { title: 'Footable' },
                templateUrl: '../views/table/footable.php'
              })
              .state('app.table.smart', {
                url: '/smart',
                templateUrl: '../views/table/ng.smart.php',
                data : { title: 'Smart' },
                controller: 'TableCtrl',
                resolve: load(['smart-table', 'scripts/controllers/table.js'])
              })
              .state('app.table.uigrid', {
                url: '/uigrid',
                templateUrl: '../views/table/ng.uigrid.php',
                data : { title: 'UI Grid' },
                controller: "UiGridCtrl",
                resolve: load(['ui.grid', 'scripts/controllers/uigrid.js'])
              })
              .state('app.table.editable', {
                url: '/editable',
                templateUrl: '../views/table/ng.editable.php',
                data : { title: 'Editable' },
                controller: 'XeditableCtrl',
                resolve: load(['xeditable','scripts/controllers/xeditable.js'])
              })

            // chart
            .state('app.chart', {
              url: '/chart',
              templateUrl: '../views/chart/chart.php',
              data : { title: 'Charts' },
              controller: "ChartCtrl",
              resolve: load('scripts/controllers/chart.js')
            })
            .state('app.echarts', {
              url: '/echarts',
              template: '<div ui-view></div>'
            })
            .state('app.echarts.line', {
              url: '/line',
              templateUrl: '../views/chart/echarts-line.php',
              data : { title: 'Echarts Line' }
            })
            .state('app.echarts.bar', {
              url: '/bar',
              templateUrl: '../views/chart/echarts-bar.php',
              data : { title: 'Echarts Bar' }
            })
            .state('app.echarts.pie', {
              url: '/pie',
              templateUrl: '../views/chart/echarts-pie.php',
              data : { title: 'Echarts Pie' }
            })
            .state('app.echarts.scatter', {
              url: '/scatter',
              templateUrl: '../views/chart/echarts-scatter.php',
              data : { title: 'Echarts Scatter' }
            })
            .state('app.echarts.rc', {
              url: '/rc',
              templateUrl: '../views/chart/echarts-radar-chord.php',
              data : { title: 'Radar & Chord' }
            })
            .state('app.echarts.gf', {
              url: '/gf',
              templateUrl: '../views/chart/echarts-gauge-funnel.php',
              data : { title: 'Gauge & Funnel' }
            })
            .state('app.echarts.map', {
              url: '/map',
              templateUrl: '../views/chart/echarts-map.php',
              data : { title: 'Map' }
            })

          .state('app.page', {
            url: '/page',
            template: '<div ui-view></div>'
          })
            .state('app.page.profile', {
              url: '/profile',
              templateUrl: '../views/page/profile.php',
              data : { title: 'Profile' }
            })
            .state('app.page.setting', {
              url: '/setting',
              templateUrl: '../views/page/setting.php',
              data : { title: 'Setting' }
            })
            .state('app.page.search', {
              url: '/search',
              templateUrl: '../views/page/search.php',
              data : { title: 'Search' }
            })
            .state('app.page.faq', {
              url: '/faq',
              templateUrl: '../views/page/faq.php',
              data : { title: 'FAQ' }
            })
            .state('app.page.gallery', {
              url: '/gallery',
              templateUrl: '../views/page/gallery.php',
              data : { title: 'Gallery' }
            })
            .state('app.page.invoice', {
              url: '/invoice',
              templateUrl: '../views/page/invoice.php',
              data : { title: 'Invoice' }
            })
            .state('app.page.price', {
              url: '/price',
              templateUrl: '../views/page/price.php',
              data : { title: 'Price' }
            })
            .state('app.page.blank', {
              url: '/blank',
              templateUrl: '../views/page/blank.php',
              data : { title: 'Blank' }
            })
            .state('app.docs', {
              url: '/docs',
              templateUrl: '../views/page/docs.php',
              data : { title: 'Documents' }
            })
            .state('404', {
              url: '/404',
              templateUrl: '../views/misc/404.php'
            })
            .state('505', {
              url: '/505',
              templateUrl: '../views/misc/505.php'
            })
            .state('access', {
              url: '/access',
              template: '<div class="dark bg-auto w-full"><div ui-view class="fade-in-right-big smooth pos-rlt"></div></div>'
            })
            .state('access.signin', {
              url: '/signin',
              templateUrl: '../views/misc/signin.php'
            })
            .state('access.signup', {
              url: '/signup',
              templateUrl: '../views/misc/signup.php'
            })
            .state('access.forgot-password', {
              url: '/forgot-password',
              templateUrl: '../views/misc/forgot-password.php'
            })
            .state('access.lockme', {
              url: '/lockme',
              templateUrl: '../views/misc/lockme.php'
            })
          ;

        function load(srcs, callback) {
          return {
              deps: ['$ocLazyLoad', '$q',
                function( $ocLazyLoad, $q ){
                  var deferred = $q.defer();
                  var promise  = false;
                  srcs = angular.isArray(srcs) ? srcs : srcs.split(/\s+/);
                  if(!promise){
                    promise = deferred.promise;
                  }
                  angular.forEach(srcs, function(src) {
                    promise = promise.then( function(){
                      angular.forEach(MODULE_CONFIG, function(module) {
                        if( module.name == src){
                          src = module.module ? module.name : module.files;
                        }
                      });
                      return $ocLazyLoad.load(src);
                    } );
                  });
                  deferred.resolve();
                  return callback ? promise.then(function(){ return callback(); }) : promise;
              }]
          }
        }

        function getParams(name) {
            name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
            var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
                results = regex.exec(location.search);
            return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
        }
      }
})();
