module.exports = function(grunt) {
    'use strict';

    // Force use of Unix newlines
    grunt.util.linefeed = '\n';

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        less: {
            development: {
                options: {
                    paths: ['less']
                },
                files: {
                    'css/style.css': 'less/style.less',
                    'css/editor-style.css': 'less/editor-style.less'
                }
            }
        },

        watch: {
          less: {
            files: 'less/**/*.less',
            tasks: 'less'
          }
        }
    });

    require('load-grunt-tasks')(grunt, { scope: 'devDependencies' });
}
