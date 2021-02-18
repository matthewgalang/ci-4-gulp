// Gulpfile.js
var gulp = require("gulp"),
    livereload = require("gulp-livereload"),
    hash = require("gulp-hash"),
    sass = require("gulp-dart-sass"),
    postcss = require("gulp-postcss"),
    mode = require("gulp-mode")(),
    path = require("path"),
    del = require("del"),
    fs = require("fs"),
    glob = require("glob"),
    config = require("./gulp-config"),
    concat = require('gulp-concat'),
    sourcemaps = require('gulp-sourcemaps');

var isProduction = mode.production();
const PostCssPlugins = [
    require("postcss-modules")({
        generateScopedName: isProduction
            ? "[contenthash:base64:5]m4s"
            : "[name]__[local]___[contenthash:base64:5]",
    }),
    isProduction ? require("autoprefixer")() : false,
].filter(Boolean);

gulp.task("sass", function () {
    return gulp.src(config.paths.src.scss)
        .pipe(mode.development(sourcemaps.init()))
        .pipe(sass({
                includePaths: ["node_modules"],
            }).on("error", sass.logError))
        .pipe(postcss(PostCssPlugins))
        .pipe(concat('styles.css'))
        .pipe(mode.development(sourcemaps.write('.')))
        .pipe(mode.production(hash()))
        .pipe(gulp.dest(config.paths.dest.css)) // hashed files output path
        .pipe(mode.production(
            hash.manifest("scss/manifest.json", {
                deleteOld: true,
                sourceDir: config.paths.dest.css, // old hashed files path
                append: false,
            }))
        )
        .pipe(mode.production(gulp.dest(".")))
        .pipe(livereload());
});

logStream = function (file) {
    console.log(file);
};

gulp.task("sass:watch", function () {
    livereload.listen();
    gulp.watch(
        config.paths.src.scss,
        { usePolling: true },
        gulp.series("sass", "clean")
    );
    gulp.watch("app/Views/*.php", { usePolling: true }).on(
        "change",
        function (file) {
            livereload.reload(file.path);
        }
    );
});

gulp.task("clean", async function () {
    clean();
});

/**
 * Checks all files in scss folder with .css.json extension and deletes it if matching filenames with .scss extension is not found
 */
function clean() {
    glob.sync("scss/*.css.json").forEach((filepath) => {
        scss_file = `${path.dirname(filepath)}/${path.basename(
            filepath,
            ".css.json"
        )}.scss`;
        fs.access(scss_file, (error) => {
            if (error) {
                del(filepath);
            }
        });
    });
    if (isProduction) {
        glob.sync("public/assets/css/styles.+(css|css.map)").forEach((filepath) => {
            del(filepath);
        });
    } else {
        glob.sync("public/assets/css/styles-*.css").forEach((filepath) => {
            del(filepath);
        });
    }
}

/**
 * Watches deletion of .scss files in scss folder and deletes the matching filename with a .css.json extension
 */
gulp.task("clean:watch", function () {
    gulp.watch(config.paths.src.scss, { usePolling: true }).on(
        "unlink",
        function (filepath) {
            additionalFile = `${path.dirname(filepath)}/${path.basename(
                filepath,
                ".scss"
            )}.css.json`;
            del(additionalFile);
        }
    );
});

gulp.task(
    "default",
    isProduction
        ? gulp.parallel("sass", "clean")
        : gulp.series("clean", "sass", gulp.parallel("sass:watch", "clean:watch"))
);
