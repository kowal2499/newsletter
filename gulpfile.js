var gulp = require('gulp');
var sass = require('gulp-sass');
var jshint = require('gulp-jshint');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var notify = require('gulp-notify');
var plumber = require('gulp-plumber');
var autoprefixer = require('gulp-autoprefixer');
var rev = require('gulp-rev');
var revDel = require('rev-del');
// var revise = require('gulp-revise');
// var del = require('del');


var cssAssets = [
    './resources/styles/vendor/**/*.css',
    './resources/styles/custom/custom.css'
];

var jsAssets = [
    './resources/js/vendor/jquery-3.3.1.js',
    './resources/js/vendor/bootstrap.min.js',
    './resources/js/vendor/ie10-viewport-bug-workaround.min.js',
    './resources/js/custom/*.js'
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
        // .pipe(revise())
        .on('error', notify.onError("Error: <%= error.message %>"))
        .pipe(gulp.dest('./public'))
        
        // .pipe(rev.manifest('rev-manifest.json', {
        //     merge: true
        // }))
        // .pipe(revDel({dest: './public'})) 
        // .pipe(revise.write('public'))
        // .pipe(gulp.dest('public'))  // write manifest to build dir
});

gulp.task('js', function() {
    return gulp.src(jsAssets)
        
        .pipe(concat('app.js', {newLine: ';'}))
        .pipe(uglify())
        // .pipe(revise())
        // .pipe(rev())
        .pipe(gulp.dest('./public'))
        // .pipe(rev.manifest('rev-manifest.json', {
            // merge: true
        // }))
        // .pipe(revDel({ dest: './public' })) 
        // .pipe(revise.write('public'))
        // .pipe(gulp.dest('public'))
});

gulp.task('revision', function() {
    return gulp.src(['public/app.css', 'public/app.js'])
        .pipe(rev())
        .pipe(gulp.dest('public'))
        .pipe(rev.manifest({ path: 'rev-manifest.json', merge: true }))
        .pipe(revDel({ dest: 'public' }))
        .pipe(gulp.dest('public'))
       });

gulp.task('manifest', function() {
    del('public/rev-manifest.json');
    gulp.src('public/*.rev')
    .pipe(revise.merge('public'))
    // .pipe(gulp.dest('public'));
});

gulp.task('watch', function() {
    gulp.watch('./resources/styles/**/*.scss', ['sass']);
    gulp.watch('./resources/styles/**/*.css', ['bundleCSS', 'revision']);
    gulp.watch('./resources/js/**/*.js', ['js', 'revision']);
});

gulp.task('default', ['sass', 'bundleCSS', 'js', 'watch']);