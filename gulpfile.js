import gulp from 'gulp';
import sass from 'gulp-sass';
import dartSass from 'sass';
import cleanCSS from 'gulp-clean-css';
import autoprefixer from 'gulp-autoprefixer';
import browserSync from 'browser-sync';
import esbuild from 'esbuild';

const sassCompiler = sass(dartSass);

// =======================
// Paths
// =======================
const paths = {
  scss: './assets/scss/**/*.scss',
  cssOut: './assets/css',

  jsEntry: './assets/javascript/develop/app.js',
  jsOutFile: './assets/javascript/production/app.js',

  jsWatch: './assets/javascript/develop/**/*.js',

  phpWatch: './*.php',
};

// =======================
// Sass
// =======================
function sassInit() {
  return gulp
    .src(paths.scss)
    .pipe(
      sassCompiler
        .sync({
          outputStyle: 'expanded',
          sourceComments: false,
        })
        .on('error', sassCompiler.logError)
    )
    .pipe(autoprefixer({ cascade: false }))
    .pipe(cleanCSS({ compatibility: 'ie8' }))
    .pipe(gulp.dest(paths.cssOut))
    .pipe(browserSync.stream());
}

// =======================
// JavaScript (ESBuild Bundle)
// =======================
async function jsInit() {

  const isProd = true // process.env.NODE_ENV === 'production';

  await esbuild.build({
    entryPoints: [paths.jsEntry],
    bundle: true,
    outfile: paths.jsOutFile,
    sourcemap: !isProd,
    minify: isProd,
    target: ['es2017'],
    format: 'iife',
    globalName: 'ThemeBundle',
    logLevel: 'info',
  });

  browserSync.reload();
}

// =======================
// Browser Sync for PHP projects
// =======================
function watchBrowserServer() {
  browserSync.create().init({
    proxy: 'http://lunapanda.local',
  });

  gulp.watch(paths.scss, sassInit);
  gulp.watch(paths.jsWatch, jsInit);
  gulp.watch(paths.phpWatch).on('change', browserSync.reload);
}

// =======================
// Task Groups
// =======================
const watchAll = gulp.parallel(
  () => gulp.watch(paths.scss, sassInit),
  () => gulp.watch(paths.jsWatch, jsInit)
);

export { sassInit, jsInit, watchAll, watchBrowserServer };