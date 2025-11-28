import gulp from 'gulp';
import sass from 'gulp-sass';
import dartSass from 'sass';
import cleanCSS from 'gulp-clean-css';
import uglify from 'gulp-uglify';
import autoprefixer from 'gulp-autoprefixer';
import browserSync from 'browser-sync';

const sassCompiler = sass(dartSass);

// Sass
function sassInit() {
    return gulp
        .src('./assets/scss/**/*.scss')
        .pipe(
            sassCompiler.sync({
                outputStyle: 'expanded',
                sourceComments: false,
            }).on('error', sassCompiler.logError)
        )
        .pipe(autoprefixer({ cascade: false }))
        .pipe(cleanCSS({ compatibility: 'ie8' })) // Minify the CSS
        .pipe(gulp.dest('./assets/css'))
        .pipe(browserSync.stream());
}

// JavaScript
function jsInit() {
    return gulp
        .src('./assets/javascript/develop/**/*.js')
        .pipe(uglify())
        .pipe(gulp.dest('./assets/javascript/production'));
}

// Browser Sync for PHP projects
function watchBrowserServer() {
    browserSync.create().init({
        proxy: 'http://localhost/complacer',
    });
    gulp.watch('./assets/scss/**/*.scss', sassInit);
    gulp.watch('./assets/javascript/develop/**/*.js', jsInit);
    gulp.watch('./*.php').on('change', browserSync.reload);
}

// Task Groups
const watchAll = gulp.parallel(
    () => gulp.watch('./assets/scss/**/*.scss', sassInit),
    () => gulp.watch('./assets/javascript/develop/**/*.js', jsInit)
);

export { sassInit, jsInit, watchAll, watchBrowserServer };