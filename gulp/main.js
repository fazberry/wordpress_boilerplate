var gulp = require("gulp");

module.exports = function() {
    // Include gulp
    var gulp = require('gulp'); 

    // Include Our Plugins
    var jshint = require('gulp-jshint'),
    sass = require('gulp-sass'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    mocha = require('gulp-mocha');

    var spawn = require('child_process').spawn,
        node;

    // Move all static files
    gulp.task('move', function() {
        gulp.src(['src/*', '!src/js/*.js', '!src/js/*.css', '!src/js/*.sass'])
            .pipe(gulp.dest('dist'));
    });

    // Lint Task
    gulp.task('lint', function() {
        return gulp.src(['src/js/*.js', '!src/js/*.min.js'])
            .pipe(jshint())
            .pipe(jshint.reporter('default'));
    });

    // Move CSS
    gulp.task('css', function() {
        return gulp.src('src/css/*.css')
            .pipe(gulp.dest('dist/css'));
    });

    // Compile our Sass
    gulp.task('sass', function() {
        var s = sass();
        s.on('error', function() { console.log("Error processing SASS"); this.emit('end'); });

        return gulp.src(['src/css/*.scss', '!src/css/_*.scss'])
            .pipe(s)
            .pipe(gulp.dest('dist/css'));
    });

    // Concatenate & Minify JS - unless filename starts with an underscore
    gulp.task('scripts', function() {
        return gulp.src(['src/js/*.js', '!src/js/*.min.js'])
            .pipe(uglify())
            .pipe(gulp.dest('dist/js'));
    });

    // Move static scripts
    gulp.task('scriptsStatic', function() {
        return gulp.src(['src/js/*.min.js'])
            .pipe(gulp.dest('dist/js'));
    });

    // Watch Files For Changes
    gulp.task('watch', function() {
        gulp.watch(['src/*', '!src/js/*.js', '!src/js/*.css', '!src/js/*.sass'], ['move']);
        gulp.watch('src/js/*.js', ['lint', 'scripts', 'scriptsStatic']);
        gulp.watch('src/css/*.scss', ['sass']);
        gulp.watch('src/css/*.css', ['css']);
    });
}