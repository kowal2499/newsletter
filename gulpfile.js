var gulp = require('gulp');
var rev = require('gulp-rev');
var clean = require('gulp-clean');
var fs = require('fs');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');

var distFolder = './dist';
var sassAsset = './resources/styles/custom/*.scss';
var compiledSassFolder = './resources/styles/custom';
var cssAssets = [
    './resources/styles/vendor/**/*.css',
    compiledSassFolder + '/*.css'
];
var jsAssets = [
    './resources/js/vendor/jquery-3.3.1.js',
    './resources/js/vendor/bootstrap.min.js',
    './resources/js/vendor/ie10-viewport-bug-workaround.min.js',
    './resources/js/custom/*.js'
    // 'node_modules/quill/dist/quill.js'
]

gulp.task('sass', function() {
    return gulp.src(sassAsset)
        .pipe(sass({
            outputStyle: 'compressed'
        }))
        .pipe(gulp.dest(compiledSassFolder));
});

gulp.task('bundleCSS', ['sass'], function() {
    return gulp.src(cssAssets)
        .pipe(concat('app.css'))
        .pipe(gulp.dest(distFolder));
});

gulp.task('js', ['bundleCSS'], function() {
    return gulp.src(jsAssets)
        .pipe(concat('app.js', {newLine: ';'}))
        .pipe(uglify())
        .pipe(gulp.dest(distFolder));
});

gulp.task('hash', ['js'], function() {
    return gulp.src([
        distFolder + '/app.css',
        distFolder + '/app.js'
        ])
        .pipe(rev())
        .pipe(gulp.dest(distFolder))
        .pipe(rev.manifest())
        .pipe(gulp.dest(distFolder));
});

gulp.task('delete', ['hash'], function() {
    var json = JSON.parse(fs.readFileSync(distFolder + '/rev-manifest.json'));
    return gulp.src([
        distFolder + '/*.css', 
        distFolder + '/*.js',
        '!' + distFolder + '/' + json['app.css'],
        '!' + distFolder + '/' + json['app.js']
        ])
        .pipe(clean());
});

gulp.task('watch', function() {
    gulp.watch('./resources/styles/**/*.scss', ['delete']);
    gulp.watch('./resources/styles/**/*.css', ['delete']);
    gulp.watch('./resources/js/**/*.js', ['delete']);
});

gulp.task('default', ['delete']);