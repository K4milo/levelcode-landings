 var gulp         = require( 'gulp' ),
     sass         = require( 'gulp-sass' ),
     postcss      = require( 'gulp-postcss' ),
     autoprefixer = require( 'autoprefixer' ),
     mqpacker     = require( 'css-mqpacker' ),
     csswring     = require( 'csswring' ),
     gutil        = require( 'gulp-util' ),
     plumber      = require( 'gulp-plumber' ),
     uglify       = require( 'gulp-uglify' ),
     concat       = require( 'gulp-concat' ),
     sourcemaps   = require('gulp-sourcemaps'),
     livereload   = require('gulp-livereload'),
     task         = [
                    'breakpoint',
                    'sass',
                    'font-awesome'
                    ];

gutil.log(
  gutil.colors.green('.')
  + '\n' +
  gutil.colors.green('/////////////////////////////')
  + '\n' +
  gutil.colors.green('Welcome to project')
  + '\n' +
  gutil.colors.green('/////////////////////////////')
);

//Tareas de postcss
function processors() {
    var processors = [
        autoprefixer,
        mqpacker
    ];
    return gulp.src('../css/*.css')
        .pipe( postcss(processors) )
        .pipe( gulp.dest('../css') );
};

//Tareas de Sass
gulp.task( 'sass', function(){
   gulp.src('scss/styles.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('../css/'));
});



// Tarea de de Breakpoint
gulp.task( 'breakpoint', function() {
  gulp
  .src('scss/styles.scss')
  .pipe( sass({
      includePaths: ['./node_modules/breakpoint-sass/stylesheets']
    }))
  .pipe( gulp.dest('../css/') )

});

//Font Awesome
gulp.task('font-awesome', function() {
    return gulp.src(['./node_modules/font-awesome/fonts/fontawesome-webfont.*'])
           .pipe(gulp.dest('../fonts/'));
});


//Snippet de errores
var gulp_src = gulp.src;
gulp.src = function() {
  return gulp_src.apply(gulp, arguments)
      .pipe( plumber( function(error) {
      // Output an error message
      gutil.log( gutil.colors.red('Error (' + error.plugin + '): ' + error.message));
      // emit the end event, to properly end the task
      this.emit('end');
    })
  );
};

//Tarea Deault
gulp.task('default', task, function(){

  gulp.watch(['./scss/**/*.scss', './js/*.js', '!./js/*.min.js'], task, processors());

  // Create LiveReload server
  livereload.listen();

  // Watch any files in dist/, reload on change
  gulp.watch(['css']).on('change', livereload.changed);

  gutil.log(
    gutil.colors.green('.')
    + '\n' +
    gutil.colors.green('////////////////////////////////////')
    + '\n' +
    gutil.colors.green('Checking changes in your files sass')
    + '\n' +
    gutil.colors.green('////////////////////////////////////')
  );

});


