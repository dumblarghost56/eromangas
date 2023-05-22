const {src,dest,watch} = require("gulp")
const webp = require("gulp-webp")
const avif = require("gulp-avif")

//Todo para compilar sass
const plumber = require("gulp-plumber")
const sass = require("gulp-sass")(require("sass"))
const cssnano = require("cssnano")
const autoprefixer = require("autoprefixer")
const postcss = require("gulp-postcss")
const sourcemaps = require("gulp-sourcemaps")

//Todo para compilar Javascript
const terser = require("gulp-terser-js");

const css = ()=>{
  return src("src/scss/**/*.scss")
  .pipe(plumber())
  // .pipe(sourcemaps.init())
  .pipe(sass())
  .pipe(postcss([cssnano,autoprefixer]))
  // .pipe(sourcemaps.write("."))
  .pipe(dest("public/assets/css"))
}


const js = ()=>{
  return src("src/js/**/*.js")
    // .pipe(sourcemaps.init())
    .pipe(terser())
    // .pipe(sourcemaps.write("."))
    .pipe(dest("public/assets/js")) 
}

const dev = ()=>{
  watch("src/scss/**/*.scss",css)
  watch("src/js/**/*.js",js)
}

const toWebp = ()=>{
  src("public/assets/thumbnails/*.{jpg,png}")
    .pipe(webp())
    .pipe(dest("public/assets/thumbnails"))

  return src("public/assets/imgs/*.{jpg,png}")
  .pipe(webp())
  .pipe(dest("public/assets/imgs"))
}

const toAvif = ()=>{
  src("public/assets/thumbnails/*.{jpg,png}")
    .pipe(avif())
    .pipe(dest("public/assets/thumbnails"))

  return src("public/assets/imgs/*.{jpg,png}")
  .pipe(avif())
  .pipe(dest("public/assets/imgs"))
}

const img = ()=>{
  toWebp()
  return toAvif()
}

exports.css = css
exports.js = js
exports.webp = toWebp
exports.avif = toAvif
exports.img = img
exports.dev = dev