module.exports = function (grunt) {
    grunt.initConfig({

  	    //cssmin: minifierar css:en
       cssmin: {
          minify: {
            options: {
              keepSpecialComments: 0 // ta bort alla kommentarer
            },
            files: [
              {
                expand: true,
                cwd: 'css/', //hämta css från css/ mappen
                src: ['*.css', '!*.min.css'], //minifiera alla css filer förutom dom redan minifierade
                dest: 'css/', //destination mapp för minifierade css-filer
                ext: '.min.css'// lägg på extenstion .min.css
              }
            ]
          }
        },
        // Watch: kollar efter sparning av specifierade filer och kör sina 'tasks' därefter 
        watch: {
            less: {
                files: ["css/*.less"],
                tasks: ["less", "cssmin"]
            }
        },

        // less:
        less: {
            main: {
                files: {
                  'css/main.css':'css/main.less'
                }
            }
        }
    });

	// Ladda in alla plugins
    grunt.loadNpmTasks("grunt-contrib-watch");
    grunt.loadNpmTasks("grunt-contrib-less");
    grunt.loadNpmTasks("grunt-contrib-cssmin");

    // registrerade tasks på default kommer att köra på commandot 'grunt'
    grunt.registerTask("default", ["less", "cssmin"]);

};
