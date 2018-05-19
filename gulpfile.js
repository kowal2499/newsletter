var gulp = require('gulp');
var sass = require('gulp-sass');
var jshint = require('gulp-jshint');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var notify = require('gulp-notify');
var plumber = require('gulp-plumber');
var autoprefixer = require('gulp-autoprefixer');
var rev = require('gulp-rev-append');


var cssAssets = [
    './resources/styles/vendor/**/*.css',
    './resources/styles/custom/custom.css'
];

var jsAssets = [
    './resources/js/vendor/jquery-3.3.1.js',
    './resources/js/vendor/bootstrap.min.js',
    './resources/js/vendor/ie10-viewport-bug-workaround.min.js',
    './resources/js/custom/*.js',
    // 'node_modules/quill/dist/quill.js'
]

gulp.task('sass', function() {
    gulp.src('./resources/styles/custom/*.scss')
        .pipe(sass({
            outputStyle: 'compressed'
        }))
        .on('error', notify.onError("Error: <%= error.message %>"))
        .pipe(autoprefixer())
        .pipe(plumber())
        .pipe(gulp.dest('./resources/styles/custom'));
});

gulp.task('bundleCSS', function() {
    gulp.src(cssAssets)
        .pipe(concat('app.css'))
        .pipe(gulp.dest('./public'))
        .on('error', notify.onError("Error: <%= error.message %>"))
});

gulp.task('js', function() {
    gulp.src(jsAssets)
        .pipe(concat('app.js', {newLine: ';'}))
        .pipe(uglify())
        .pipe(gulp.dest('./public'));
});

// This task will add a cache  buster to file with  ?rev=@@hash added to it.  This forces a users cache to refresh anytime there is a change.

gulp.task('rev', function() {
    gulp.src('./app/views/layout.html.twig')
        .pipe(rev())
        .pipe(gulp.dest('./app/views/'));
});


gulp.task('watch', function() {
    gulp.watch('./resources/styles/**/*.scss', ['sass']);
    gulp.watch('./resources/styles/**/*.css', ['bundleCSS', 'rev']);
    gulp.watch('./resources/js/**/*.js', ['js', 'rev']);
});

gulp.task('default', ['sass', 'bundleCSS', 'js', 'watch']);