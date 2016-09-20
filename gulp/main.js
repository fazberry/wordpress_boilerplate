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
    mocha = require('gulp-mocha'),
    path  = require('path');

    var spawn = require('child_process').spawn,
        node;

    var src = 'src/wp-content/themes/*/';

    // Move all static files
    gulp.task('move', function() {
        gulp.src(['./src/**/*', '!src/**/*.js', '!src/**/*.css', '!src/**/*.scss'])
            .pipe(gulp.dest('dist'));
    });

    // Lint Task
    gulp.task('lint', function() {
        return gulp.src([src+'js/*.js', '!'+src+'js/*.min.js'])
            .pipe(jshint())
            .pipe(jshint.reporter('default'));
    });

    // Move CSS
    gulp.task('css', function() {
        return gulp.src('src/**/*.css')
            .pipe(gulp.dest('dist'));
    });

    // Compile our Sass
    gulp.task('sass', function() {
        var s = sass();
        s.on('error', function() { console.log("Error processing SASS"); this.emit('end'); });

        return gulp.src(['src/**/*.scss', '!src/**/_*.scss'])
            .pipe(s)
            .pipe(gulp.dest('dist'));
    });

    // Concatenate & Minify JS - unless filename starts with an underscore
    gulp.task('scripts', function() {
        var s = uglify();
        s.on('error', function() { console.log("Error processing JS"); this.emit('end'); });

        return gulp.src(['src/**/*.js', '!src/**/*.min.js'])
            .pipe(s)
            .pipe(gulp.dest('dist'));
    });

    // Move static scripts
    gulp.task('scriptsStatic', function() {
        return gulp.src(['src/**/*.min.js'])
            .pipe(gulp.dest('dist'));
    });

    // Watch Files For Changes
    gulp.task('watch', function() {
        gulp.watch(['./src/*','./src/**/*', '!'+src+'js/*.js', '!'+src+'js/*.css', '!'+src+'js/*.scss'], ['move']);
        gulp.watch(src+'js/*.js', ['lint', 'scripts', 'scriptsStatic']);
        gulp.watch(src+'css/*.scss', ['sass']);
        gulp.watch(src+'css/*.css', ['css']);
    });
}