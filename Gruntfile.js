'use strict';
module.exports = function (grunt) {

  grunt.initConfig({
    compass: {
      css: {
        options: {
          sassDir: 'assets/sass',
          cssDir: 'assets/css',
          environment: 'production',
          relativeAssets: true
        }
      },
      cssDev: {
        options: {
          environment: 'development',
          debugInfo: true,
          noLineComments: false,
          sassDir: 'assets/sass',
          cssDir: 'assets/css',
          outputStyle: 'expanded',
          relativeAssets: true,
          sourcemap: true
        }
      }
    },
    watch: {
      src: {
        files: ['assets/sass/*.scss'],
          tasks: ['compass']
      }
    },
    coffee: {
      js: {
        options: {
          bare: true,
          join: true
        },
        files: {
          'assets/js/public.js': 'assets/coffee/public.coffee',
          'assets/js/admin.js': 'assets/coffee/admin.coffee',
          'assets/js/settings.js': 'assets/coffee/settings.coffee'
        }
      },
      jsDev: {
        options: {
          bare: true,
          join: true,
          sourceMap: true
        },
        files: {}
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-compass');
  grunt.registerTask('default', ['compass']);

}
