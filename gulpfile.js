/**
 * Created by iibarguren on 3/13/17.
 */

var gulp = require('gulp'),
    sass = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    scsslint = require('gulp-scss-lint'),
    rename = require('gulp-rename'),
    jscs = require('gulp-jscs'),
    phpcs = require('gulp-phpcs'),
    phpcbf = require('gulp-phpcbf'),
    gutil = require('gulp-util'),
    cssnano = require('gulp-minify-css');
gulp.task('sass', function () {
    return gulp.src('./app/Resources/assets/scss/app.scss')
        .pipe(sass({sourceComments: 'map'}))
        .pipe(autoprefixer())
        .pipe(gulp.dest('./web/css/'))
        .pipe(rename({suffix: '.min'}))
        .pipe(cssnano())
        .pipe(gulp.dest('./web/css/'));
});

gulp.task('watch', function () {
    gulp.watch('./app/Resources/assets/scss/**/*.scss', ['sass']);
});

gulp.task('scsslint', function () {
    return gulp.src('./app/Resources/assets/scss/**/*.scss')
        .pipe(scsslint());
});

gulp.task('jscs', function () {
    return gulp.src('./app/Resources/assets/js/**/*.js')
        .pipe(jscs({
            configPath: './vendor/sonata-project/core-bundle/Resources/public/vendor/bootstrap/js/.jscsrc'
        }))
        .pipe(jscs.reporter());
});

gulp.task('phpcs', function () {
    return gulp.src(['./src/AppBundle/**/*.php'])
        .pipe(phpcs({
            bin: './vendor/bin/phpcs',
            standard: 'PSR2',
            warningSeverity: 0
        }))
        .pipe(phpcs.reporter('log'));
});

gulp.task('phpcbf', function () {
    return gulp.src(['./src/AppBundle/**/*.php'])
        .pipe(phpcbf({
            bin: './vendor/bin/phpcbf',
            standard: 'PSR2',
            warningSeverity: 0
        }))
        .on('error', gutil.log)
        .pipe(gulp.dest('src/AppBundle'));
});

gulp.task('default', ['sass', 'watch', 'scsslint']);