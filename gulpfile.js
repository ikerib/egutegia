/**
 * Created by iibarguren on 3/13/17.
 */

var gulp = require('gulp'),
    concat = require('gulp-concat'),
    cssnext = require('postcss-cssnext'),
    cssnano = require('gulp-cssnano'),
    livereload = require('gulp-livereload'),
    modernizr = require('gulp-modernizr'),
    plumber = require('gulp-plumber'),
    postcss = require('gulp-postcss'),
    rename = require('gulp-rename'),
    sass = require('gulp-sass'),
    scsslint = require('gulp-scss-lint'),
    clean = require('gulp-clean'),
    uglify = require('gulp-uglify'),
    sass2 = require('gulp-ruby-sass')
    notify = require("gulp-notify")
    bower = require('gulp-bower');

var config = {
    sassPath: './app/Resources/assets/scss',
    bowerDir: './app/Resources/assets/js'
}

var paths = {
    npm: './node_modules',
    sass: './app/Resources/assets/scss',
    js: './app/Resources/assets/js',
    svg: './app/Resources/assets/svg',
    buildCss: './web/css',
    buildJs: './web/js',
    buildSvg: './web/svg'
};

function onError(err) {
    console.log(err);
    this.emit('end');
}

gulp.task('bower', function() {
    return bower()
        .pipe(gulp.dest(config.bowerDir))
});

gulp.task('clean', function () {
    return gulp.src(['web/css/*', 'web/js/*', 'web/fonts/*'])
        .pipe(clean());
});

gulp.task('icons', function() {
    return gulp.src(config.bowerDir + '/font-awesome/fonts/**.*')
        .pipe(gulp.dest('./web/fonts'));

});

gulp.task('css', function () {
    return gulp.src([
        './app/Resources/assets/js/bootstrap/dist/css/bootstrap.css',
        './app/Resources/assets/js/bootstrap/dist/css/bootstrap-theme.css'
    ])
        .pipe(gulp.dest('web/css/'));
});

gulp.task('sass', ['scss-lint'], function () {
    console.log(paths.sass + '/app.scss');
    gulp.src(paths.sass + '/app.scss')
        .pipe(plumber({
            errorHandler: onError
        }))
        .pipe(sass({
            errLogToConsole: true
        }))
        .pipe(postcss([cssnext]))
        .pipe(gulp.dest(paths.buildCss))
        .pipe(livereload());
});

gulp.task('sass:prod', function () {
    gulp.src(paths.sass + '/app.scss')
        .pipe(plumber({
            errorHandler: onError
        }))
        .pipe(sass())
        .pipe(postcss([cssnext]))
        .pipe(cssnano({
            keepSpecialComments: 1,
            rebase: false
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest(paths.buildCss));
});

gulp.task('scss-lint', function () {
    gulp.src([
        paths.sass + '/**/*.scss',
        '!' + paths.sass + '/base/_reset.scss'
    ])
        .pipe(plumber({
            errorHandler: onError
        }))
        .pipe(scsslint());
});


gulp.task('js:dev', function() {
    return gulp.src([
        './app/Resources/assets/js/jquery/dist/jquery.js',
        './app/Resources/assets/js/bootstrap/dist/js/bootstrap.js',
        './app/Resources/assets/js/app.js'
    ])
        .pipe(gulp.dest('web/js/'));
});


gulp.task('js:prod', function() {
    return gulp.src([
        './app/Resources/assets/js/jquery/dist/jquery.js',
        './app/Resources/assets/js/bootstrap/dist/js/bootstrap.js'
    ])
        .pipe(concatJs('app.js'))
        .pipe(minifyJs())
        .pipe(gulp.dest('web/js/'));
});

gulp.task('watch', function () {
    gulp.watch('./app/Resources/assets/scss/**/*.scss', ['sass']);
});


gulp.task('default', ['sass', 'js:dev', 'watch']);

gulp.task('prod', ['sass:prod', 'modernizr', 'js:prod']);