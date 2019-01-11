var gulp = require('gulp');
var sass = require('gulp-sass');
var browserSync = require('browser-sync').create();
var reload = browserSync.reload;
 
gulp.task('default', function(){
 
    console.log('default gulp task...')
 
});

gulp.task('sass', function(){
   
    gulp.src('./sass/stylesheet.scss')
    
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('../discography-app/css'))
    .pipe(browserSync.reload({
      stream: true
    }));
});

gulp.task('watch', function(){
    
    browserSync.init({
        injectChanges: true,
        port: 8888
    });

    gulp.watch('./sass/*.scss', ['sass']);

    gulp.watch('../discography-app/**/*.php',  browserSync.reload);

});

gulp.task('default', ['watch']);