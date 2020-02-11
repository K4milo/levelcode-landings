let gulp = require('gulp');
let sass = require('gulp-sass');

sass.compiler = require('node-sass');

gulp.task('styles', () => {
    return gulp.src('scss/styles.scss')
        .pipe(sass())
        .pipe(gulp.dest('../css'));
});

gulp.task('watch', () => {
    gulp.watch('scss/styles.scss', gulp.series('styles'));
});

gulp.task('default', gulp.parallel('styles'));

