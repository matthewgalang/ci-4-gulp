# CodeIgniter4 + CSS Modules with Gulp

A boilerplate to use [CSS Modules](https://github.com/css-modules/css-modules) on [CodeIgniter4](https://github.com/codeigniter4/CodeIgniter4) through [Gulp](https://gulpjs.com/).

Who would need this? If you have a monolithic MVC project that does not use a javascript framework or other bundler for assets but would like to use CSS Module functionality, then start  here.

## Usage

### Write modular css
Out of the box, the gulpfile supports non-partial scss files in the `scss` folder in the project root. You can write css like this:

```
// componentOne.scss
.myClass {
  color: red;
}
```
```
// componentTwo.scss
.myClass {
  color: blue;
}
```

Running gulp will compile and output a css file at `public/assets/css` containing the transformed styles:

```
// publicStyles.css
.componentOne__myClass {
  color:red;
}
.componentTwo__myClass {
  color:blue;
}
```

Which you can assign class names in your view by:

```
// index.php
<div <?=className('componentOne', ['myClass'])?>>
  This appears red
</div>

<div <?=className('componentTwo', ['myClass'])?>>
  This appears blue
</div>
```

### Generate Transforms

Transforms are saved as JSON objects into the `scss/transforms` folder when running gulp. The CSSModules library will map the correct class name with these transforms.

### Load public stylesheet

All transformed classes are concatenated into one sheet in `public/assets/css`. Cachebusting is enabled on production only (make sure you run the correct npm/yarn script).

## Server Requirements

The project was stable with the following:
Node.js version 15.5.1
npm 7.3.0
yarn 1.22.10

PHP version 7.3 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)

## Installation 

Make sure you have npm + yarn installed then run `yarn` in your project.

## Setup

Copy `env` to `.env` and tailor for your app, specifically the baseURL
and any database settings.