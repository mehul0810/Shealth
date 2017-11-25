/**
 * Shealth - Gulp Configuration.
 */

var project               = 'Shealth';

var styleSource           = './assets/scss/shealth.scss';
var styleDestination      = './assets/css/';
var sourcemapsDestination = './sourcemaps/';

var jsCustomSource        = './assets/js/custom/*.js';
var jsCustomDestination   = './assets/js';
var jsCustomFile          = 'shealth';

var styleWatchFiles       = './assets/scss/**/*.scss';
var customJSWatchFiles    = './assets/js/custom/*.js';

/**
 * Load required Gulp Plugins for task execution.
 */
var gulp         = require('gulp');

// CSS related plugins of Gulp.
var sass         = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var minifycss    = require('gulp-uglifycss');

// JS related plugins of Gulp.
var concat       = require('gulp-concat');
var uglify       = require('gulp-uglify');

// Utility related plugins of Gulp.
var rename       = require('gulp-rename');
var sourcemaps   = require('gulp-sourcemaps');
var notify       = require('gulp-notify');

/**
 * Compiles SCSS, AutoPrefixes it and Minify CSS.
 */
gulp.task('styles', function () {
	gulp.src( styleSource )
		.pipe( sourcemaps.init() )
		.pipe( sass( {
			errLogToConsole: true,
			outputStyle: 'compact',
			precision: 10
		} ) )
		.pipe( sourcemaps.write( { includeContent: false } ) )
		.pipe( sourcemaps.init( { loadMaps: true } ) )
		.pipe( autoprefixer(
			'last 2 version',
			'> 1%',
			'safari 5',
			'ie 8',
			'ie 9',
			'opera 12.1',
			'ios 6',
			'android 4' ) )

		.pipe( sourcemaps.write ( sourcemapsDestination ) )
		.pipe( gulp.dest( styleDestination ) )


		.pipe( rename( { suffix: '.min' } ) )
		.pipe( minifycss( {
			maxLineLen: 10
		}))
		.pipe( gulp.dest( styleDestination ) )
		.pipe( notify( { message: 'Task: "Style Minification" Completed!', onLast: true } ) )
});

/**
 * Concatenate and uglify custom shealth JS scripts.
 */
gulp.task( 'customJS', function() {
	gulp.src( jsCustomSource )
		.pipe( concat( jsCustomFile + '.js' ) )
		.pipe( gulp.dest( jsCustomDestination ) )
		.pipe( rename( {
			basename: jsCustomFile,
			suffix: '.min'
		}))
		.pipe( uglify() )
		.pipe( gulp.dest( jsCustomDestination ) )
		.pipe( notify( { message: 'Task: "Custom JS Beautification" Completed!', onLast: true } ) );
});

/**
 * Watch Tasks for changes.
 */

gulp.task( 'default', [ 'styles', 'customJS' ], function () {
	gulp.watch( styleWatchFiles, [ 'styles' ] );
	gulp.watch( customJSWatchFiles, [ 'customJS' ] );
});