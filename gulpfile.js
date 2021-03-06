var pump = require('pump');

var gulp = require('gulp');
var pug = require('gulp-pug');
var less = require('gulp-less');
var minifyCSS = require('gulp-csso');
var minifyJS = require('gulp-uglify');
var cssmin = require('gulp-cssmin');
var rename = require('gulp-rename');
var concat = require('gulp-concat');
var prefixer = require('gulp-autoprefixer');
var sass = require('gulp-sass');


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// JS

// gulp.task('scripts', function () {
//     //return gulp.src('dist/js/*.js')
//     return gulp.src([
//         'public_html/components/jquery/dist/jquery.js',
//         'public_html/components/jquery-migrate/jquery-migrate.js',
//         'public_html/components/bootstrap/dist/js/bootstrap.js',
//         //'public_html/components/jquery-validation/dist/jquery.validate.js',
//         //'public_html/components/jquery-validation/dist/additional-methods.js',
//         //'public_html/components/jquery-validation/src/localization/messages_ru.js',
//         'public_html/components/jquery-form-validator/form-validator/jquery.form-validator.js',
//         'public_html/components/jquery.cookie/jquery.cookie.js',
//         'public_html/components/headhesive/dist/headhesive.js',
//         'public_html/components/slick-carousel/slick/slick.js',
//         // //'dist/js/main/*.js'
//         'dist/js/main/main.js'
//         //'dist/js/main/form.js'
//     ])
//     //.pipe(concat('all_main.js'))
//         .pipe(concat('all_main.js'))
//         .pipe(gulp.dest('public_html/js'));
// });


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// css
gulp.task('sass:build', function () {
    gulp.src('sass/styles.sass') //Выберем наш main.scss

        .pipe(sass()) //Скомпилируем
        .pipe(prefixer()) //Добавим вендорные префиксы
        .pipe(gulp.dest('frontend/media/css/')); //И в build

});

gulp.task('sass:buildmain', function(){
    gulp.src('sass/main.sass')
        .pipe(sass()) //Скомпилируем
        .pipe(prefixer()) //Добавим вендорные префиксы
        .pipe(gulp.dest('frontend/assets/main/css')); //И в build

})





gulp.task('css', function () {
    return gulp.src([
        //'frontend/media/css/bootstrap.css',
       // 'frontend/media/css/jquery-ui.smoothness.1.12.1.css',
       'frontend/media/css/bootstrap.4.1.3.min.css',
        //'vendor/bower-asset/jquery-ui/themes/smoothness/jquery-ui.min.css',
        //'vendor/bower-asset/jquery-ui/themes/smoothness/theme.css',
        'frontend/media/css/flaticon.css',
        'frontend/media/css/font-awesome/css/font-awesome.min.css',
        // 'frontend/media/css/animate.3.2.3.css',
        'frontend/media/css/prefix2.css',
        'frontend/media/css/styles.css'
    ])
    .pipe(concat('style_all.css'))
    .pipe(gulp.dest('frontend/media/css'))
    .pipe(minifyCSS())
    .pipe(concat('style_all.min.css'))
    .pipe(gulp.dest('frontend/media/css'))
    .pipe(gulp.dest('frontend/web/css'))
});



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// default
gulp.task('default', ['sass:build','css']
    // , function () {

    // gulp.src(["!public_html/css/*.min.css", 'public_html/css/*.css'])
    //     .pipe(cssmin())
    //     .pipe(rename({suffix: '.min'}))
    //     .pipe(gulp.dest('public_html/css'));
    //
    // gulp.src(["!public_html/js/*.min.js", 'public_html/js/*.js'])
    //     .pipe(minifyJS())
    //     .pipe(rename({suffix: '.min'}))
    //     .pipe( gulp.dest('public_html/js'))

// }
);