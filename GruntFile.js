module.exports = function(grunt) {

    grunt.initConfig({
        bower: grunt.file.readJSON('bower.json'),
        clean: {
            dist: ['dist/*'],
            html: ['html/*.html'],
            tmp : ['.tmp','**/.DS_store']
        },
        copy: {
            dist: {
                files: [
                    {expand: true, cwd: 'angular/', src: '**', dest: 'dist/angular/'},
                    {expand: true, cwd: 'html/', src: '**', dest: 'dist/html/'},
                    {expand: true, cwd: 'assets/', src: ['**', '!**/scss/**'], dest: 'dist/assets/'},
                    {expand: true, cwd: 'libs/', src: '**', dest: 'dist/libs/'},
                    {src: 'index.php', dest: 'dist/index.php'}
                ]
            },
            js: {
                files: [
                    {src: 'dist/scripts/app.angular.js', dest : 'dist/angular/scripts/app.angular.js'},
                    {src: 'dist/scripts/app.php.js', dest : 'dist/html/scripts/app.php.js'}
                ]
            },
            libs:{
                files: '<%= bower.copy %>'
            }
        },
        htmlmin: {
            dist: {
                options: { removeComments: true, collapseWhitespace: true },
                files: [
                    { expand: true, cwd: 'views/', src: ['*.html', '**/*.html'], dest: 'dist/views/' }
                ]
            }
        },
        watch: {
            sass: {
              files: ['assets/scss/*.scss'],
              tasks: ['sass'],
            }
        },
        sass: {
            dist: {
                files: [
                    {'assets/styles/app.css': ['assets/scss/app.scss']},
                    {'assets/styles/app.rtl.css': ['assets/scss/app.rtl.scss']},
                    {'assets/bootstrap-rtl/dist/bootstrap-rtl.css': ['assets/bootstrap-rtl/scss/bootstrap-rtl.scss']}
                ]
            }
        },
        useminPrepare: {
            html: ['angular/index.php','angular/index.rtl.php','html/*.html']
        },
        usemin: {
            html: ['dist/angular/index.php','dist/angular/index.rtl.php','dist/html/*.html']
        },
        bump: {
            options: {
                files: ['package.json'],
                commit: true,
                commitMessage: 'Release v%VERSION%',
                commitFiles: ['-a'],
                createTag: true,
                tagName: 'v%VERSION%',
                tagMessage: 'Version %VERSION%',
                push: true,
                pushTo: 'origin',
                gitDescribeOptions: '--tags --always --abbrev=1 --dirty=-d'
            }
        },
        assemble: {
          options: {
            layoutdir: 'html/layout/',
            partials: ['views/blocks/**/*.html' ],
            data: ['html/scripts/data.json'],
            flatten: true
          },
          page: {
            options: {
              layout: 'layout.php'
            },
            src: [
                'views/**/*.html',
                '!views/blocks/**',
                '!views/layout/**',
                '!views/misc/**',
                '!views/**/ng.*.html',
                '!views/**/tpl.*.html',
            ],
            dest: 'html/'
          },
          layout0: {
            options: {
              layout: 'layout.0.php'
            },
            src: [
                'views/dashboard/dashboard.0.php',
            ],
            dest: 'html/'
          },
          layout1: {
            options: {
              layout: 'layout.1.php'
            },
            src: [
                'views/dashboard/dashboard.1.php',
            ],
            dest: 'html/'
          },
          layout2: {
            options: {
              layout: 'layout.2.php'
            },
            src: [
                'views/dashboard/dashboard.2.php',
            ],
            dest: 'html/'
          },
          layout3: {
            options: {
              layout: 'layout.3.php'
            },
            src: [
                'views/dashboard/dashboard.3.php',
            ],
            dest: 'html/'
          },
          layout4: {
            options: {
              layout: 'layout.4.php'
            },
            src: [
                'views/dashboard/dashboard.4.php',
            ],
            dest: 'html/'
          },
          layout5: {
            options: {
              layout: 'layout.5.php'
            },
            src: [
                'views/dashboard/dashboard.5.php',
            ],
            dest: 'html/'
          },
          misc: {
            options: {
              layout: 'base.php'
            },
            src: [
                'views/misc/*.html'
            ],
            dest: 'html/'
          }
        }
    });

    grunt.loadNpmTasks('grunt-usemin');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-htmlmin');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-bump');
    grunt.loadNpmTasks('grunt-assemble');

    grunt.registerTask('build', [
        'clean:dist',
        'copy',
        'sass',
        'useminPrepare',
        'concat:generated',
        'cssmin:generated',
        'uglify:generated',
        'usemin',
        'htmlmin',
        'clean:tmp',
        'copy:js'
    ]);

    grunt.registerTask('release', [
        'bump'
    ]);

    grunt.registerTask('html', [
        'clean:html',
        'assemble'
    ]);
};
