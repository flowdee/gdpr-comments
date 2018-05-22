/*global module:false*/
module.exports = function (grunt) {

    // Load multiple grunt tasks using globbing patterns
    require('load-grunt-tasks')(grunt);

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        less: {
            admin: {
                options: {
                    cleancss: false
                },
                src: [
                    'assets/src/less/admin.less'
                ],
                dest: 'assets/css/admin.css'
            },
            admin_min: {
                options: {
                    cleancss: true,
                    compress: true
                },
                src: [
                    'assets/src/less/admin.less'
                ],
                dest: 'assets/css/admin.min.css'
            },
            styles: {
                options: {
                    cleancss: false
                },
                src: [
                    'assets/src/less/styles.less'
                ],
                dest: 'assets/css/styles.css'
            },
            styles_min: {
                options: {
                    cleancss: true,
                    compress: true
                },
                src: [
                    'assets/src/less/styles.less'
                ],
                dest: 'assets/css/styles.min.css'
            }
        },
        uglify: {
            admin: {
                options: {
                    beautify: true
                },
                src: [
                    'assets/src/js/admin.js'
                ],
                dest: 'assets/js/admin.js'
            },
            admin_min: {
                src: [
                    'assets/src/js/admin.js'
                ],
                dest: 'assets/js/admin.min.js'
            },
            scripts: {
                options: {
                    beautify: true
                },
                src: [
                    'assets/src/js/scripts.js'
                ],
                dest: 'assets/js/scripts.js'
            },
            scripts_min: {
                src: [
                    'assets/src/js/scripts.js'
                ],
                dest: 'assets/js/scripts.min.js'
            }
        },
        autoprefixer: {
            options: {
                browsers: [
                    'Android 2.3',
                    'Android >= 4',
                    'Chrome >= 20',
                    'Firefox >= 24',
                    'Explorer >= 8',
                    'iOS >= 6',
                    'Opera >= 12',
                    'Safari >= 6'
                ]
            },
            min: {
                options: {
                    cascade: false
                },
                expand: true,
                flatten: true,
                src: 'assets/css/*.css',
                dest: 'assets/css/'
            }
        },
        watch: {
            less: {
                files: 'assets/src/**/*.less',
                tasks: 'less'
            },
            uglify: {
                files: 'assets/src/**/*.js',
                tasks: 'uglify'
            }
        },
        checktextdomain: {
            options: {
                text_domain: '<%= pkg.pot.textdomain %>',
                keywords: [
                    '__:1,2d',
                    '_e:1,2d',
                    '_x:1,2c,3d',
                    'esc_html__:1,2d',
                    'esc_html_e:1,2d',
                    'esc_html_x:1,2c,3d',
                    'esc_attr__:1,2d',
                    'esc_attr_e:1,2d',
                    'esc_attr_x:1,2c,3d',
                    '_ex:1,2c,3d',
                    '_n:1,2,4d',
                    '_nx:1,2,4c,5d',
                    '_n_noop:1,2,3d',
                    '_nx_noop:1,2,3c,4d',
                    ' __ngettext:1,2,3d',
                    '__ngettext_noop:1,2,3d',
                    '_c:1,2d',
                    '_nc:1,2,4c,5d'
                ]
            },
            files: {
                expand: true,
                src: [
                    'plugin/gdpr-comments/**/*.php', // Include all files
                    '!plugin/gdpr-comments/includes/libs/**' // Exclude libs folder/
                ]
            }
        },
    });

    // Default task.
    grunt.registerTask('dist-css', ['less', 'autoprefixer']);
    grunt.registerTask('default', ['less', 'uglify', 'autoprefixer']);

    grunt.registerTask('translations', ['checktextdomain']);

    grunt.registerTask( 'build', [ 'checktextdomain', 'less', 'uglify', 'autoprefixer' ] );
};