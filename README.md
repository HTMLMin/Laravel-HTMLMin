Laravel HTMLMin
===============

Laravel HTMLMin is currently maintained by [Raza Mehdi](https://github.com/srmklive), and is a simple HTML minifier for [Laravel](http://laravel.com). It utilises Mr Clay's [Minify](https://github.com/mrclay/minify) package to minify entire responses, but can also minify blade at compile time. Feel free to check out the [change log](CHANGELOG.md), [releases](https://github.com/HTMLMin/Laravel-HTMLMin/releases), [license](LICENSE), and [contribution guidelines](CONTRIBUTING.md).

<p align="center">
<img href="https://github.com/HTMLMin/Laravel-HTMLMin/workflows/HTMLMinTests/badge.svg"><img src="https://github.com/HTMLMin/Laravel-HTMLMin/workflows/HTMLMinTests/badge.svg" alt="Tests"></img></a>
<a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Software License"></img></a>
<a href="https://github.com/HTMLMin/Laravel-HTMLMin/releases"><img src="https://img.shields.io/github/release/HTMLMin/Laravel-HTMLMin.svg?style=flat-square" alt="Latest Version"></img></a>
</p>


## Installation

Laravel HTMLMin requires [PHP](https://php.net) 5.5+. This particular version supports Laravel 5.1-5.8, 6.x, 7.x and 8.x.

To get the latest version, simply require the project using [Composer](https://getcomposer.org):

```bash
$ composer require htmlmin/htmlmin
```

Once installed, register the service provider in your `config/app.php`

```php
'providers' => [
    HTMLMin\HTMLMin\HTMLMinServiceProvider::class
]
```

If you want, a facade is available to alias

```php
'aliases' => [
    'HTMLMin' => HTMLMin\HTMLMin\Facades\HTMLMin::class
]
```

## Configuration

Laravel HTMLMin supports optional configuration.

To get started, you'll need to publish all vendor assets:

```bash
$ php artisan vendor:publish
```

This will create a `config/htmlmin.php` file in your app that you can modify to set your configuration. Also, make sure you check for changes to the original config file in this package between releases.

There are three config options:

##### Automatic Blade Optimizations

This option (`'blade'`) enables minification of the blade views as they are compiled. These optimizations have little impact on php processing time as the optimizations are only applied once and are cached. This package will do nothing by default to allow it to be used without minifying pages automatically. The default value for this setting is `false`.

##### Force Blade Optimizations

This option (`'force'`) forces blade minification on views where there such minification may be dangerous. This should only be used if you are fully aware of the potential issues this may cause. Obviously, this setting is dependent on blade minification actually being enabled. The default value for this setting is `false`.

##### Ignore Blade Files

This option (`'ignore'`) is where you can specify paths, which you don't want to minify. A sensible default for this setting is provided.


## Usage

##### HTMLMin

This is the class of most interest. It is bound to the ioc container as `'htmlmin'` and can be accessed using the `Facades\HTMLMin` facade. There are four public methods of interest.

The `'blade'` method will parse a string as blade and minify it as quickly as possible. This is method the compiler class uses when blade minification is enabled.

The `'css'` and `'js'` methods will parse a string as css/js and will minify it using Mr Clay's [Minify](https://github.com/mrclay/minify) package.

The `'html'` method will parse a string as html and will minify it as best as possible using Mr Clay's [Minify](https://github.com/mrclay/minify) package. It will also be able to minify inline css and js. This is the method that is used by the minification middleware.

##### Facades\HTMLMin

This facade will dynamically pass static method calls to the `'htmlmin'` object in the ioc container which by default is the `HTMLMin` class.

##### Minifiers\MinifierInterface

This interface defines the public method a minifier class must implement. Such a class must only provide a `'render'` method which takes one parameter as a string, and should return a string. This package ships with 4 implementations of this interface, but these classes are not intended for public use, so have no been documented here. You can see the source [here](https://github.com/HTMLMin/Laravel-HTMLMin/tree/master/src/Minifiers).

##### Http\Middleware\MinifyMiddleware

You may put the `HTMLMin\HTMLMin\Http\Middleware\MinifyMiddleware` middleware in front of your routes to live minify them. Note that this middleware allows you to achieve maximal results, though at a performance cost because of it running on each request instead of once like the built in blade minification. It may be useful for you to take a look at the [source](https://github.com/HTMLMin/Laravel-HTMLMin/blob/master/src/Http/Middleware/MinifyMiddleware.php) for this, read the [tests](https://github.com/HTMLMin/Laravel-HTMLMin/blob/master/tests/Functional/MiddlewareTest.php), or check out Laravel's [documentation](http://laravel.com/docs/5.1/middleware) if you need to.

##### Skipping Minification

As well as being able to skip folders using the (`'ignore'`) config, there are occasions where you will want to 'skip' single files.

Just add the following comment to each file you want to skip:

```html
<!-- skip.minification -->
```

Please note that if you use (`'force'`) option in the config it will not work.

##### HTMLMinServiceProvider

This class contains no public methods of interest. This class should be added to the providers array in `config/app.php`. This class will setup ioc bindings and register automatic blade minification based on the config.

##### Further Information

There are other classes in this package that are not documented here (such as the compiler class). This is because they are not intended for public use and are used internally by this package.

**Please note to clear view cache to see changes.**

```
php artisan view:clear
```

## Security

If you discover a security vulnerability within this package, please send an e-mail to Raza Mehdi at srmk@outlook.com. All security vulnerabilities will be promptly addressed.


## License

Laravel HTMLMin is licensed under [The MIT License (MIT)](LICENSE).
