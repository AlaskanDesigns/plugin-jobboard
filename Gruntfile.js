'use strict';

module.exports = function(grunt) {
    // Project configuration.
    grunt.initConfig({
        less: {
            dist: {
                options: {
                    yuicompress: true
                },
                files: {
                    'assets/css/styles.css': 'assets/less/styles.less'
                }
            }
        }
    });

    // Actually load this plugin's task(s).
    grunt.loadTasks('tasks');

    grunt.loadNpmTasks('grunt-contrib-less');
};