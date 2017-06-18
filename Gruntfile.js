/* jshint node:true */
module.exports = function( grunt ) {
	'use strict';

	grunt.initConfig({

		
		// JavaScript linting with JSHint.
		jshint: {
			options: {
				jshintrc: '.jshintrc'
			},
			all: [
				'js/*.js'
			]
		},

		// Minify .js files.
		uglify: {
			options: {
				preserveComments: 'some'
			},
			main: {
				files: [{
					expand: true,
					cwd: 'js/',
					src: [
						'*.js',
						'!*.min.js'
					],
					dest: 'js/',
					ext: '.min.js'
				}]
			}
			
		},

		


		// Watch changes for assets.
		watch: {
			
			js: {
				files: [
					// main js
					'js/*js',
					'!js/*.min.js',

				],
				tasks: ['jshint', 'uglify']
			}
		},

		// Generate POT files.
		makepot: {
			options: {
				type: 'wp-theme',
				domainPath: 'languages',
				potHeaders: {
					'report-msgid-bugs-to': 'https://github.com/alexrighetto/axl-wc-booking-extension/issues',
					'language-team': 'LANGUAGE <EMAIL@ADDRESS>'
				}
			},
			frontend: {
				options: {
					potFilename: 'booking-extension.pot',
					exclude: [
						'storefront/.*' // Exclude deploy directory
					]
				}
			}
		},

		// Check textdomain errors.
		checktextdomain: {
			options:{
				text_domain: 'booking-extension',
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
				]
			},
			files: {
				src:  [
					'**/*.php', // Include all files
					'!node_modules/**' // Exclude node_modules/
				],
				expand: true
			}
		},

		// Creates deploy-able theme
		copy: {
			deploy: {
				src: [
					'**',
					'!.*',
					'!*.md',
					'!.*/**',
					'.htaccess',
					'!Gruntfile.js',
					'!package.json',
					'!node_modules/**',
					'!.DS_Store',
					'!npm-debug.log'
				],
				dest: 'storefront',
				expand: true,
				dot: true
			}
		}});

		

	// Load NPM tasks to be used here
	grunt.loadNpmTasks( 'grunt-contrib-jshint' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-sass' );
	grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-checktextdomain' );
	grunt.loadNpmTasks( 'grunt-contrib-copy' );
	grunt.loadNpmTasks( 'grunt-rtlcss' );
	grunt.loadNpmTasks( 'grunt-postcss' );

	// Register tasks
	grunt.registerTask( 'default', [
		
		'jshint',
		'uglify'
	]);

	

	grunt.registerTask( 'dev', [
		'default',
		'makepot'
	]);

	grunt.registerTask( 'deploy', [
		'copy'
	]);
};// JavaScript Document