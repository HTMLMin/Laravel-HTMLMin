Laravel HTMLMin
===============

Laravel HTMLMin was created by, and is maintained by [Graham Campbell](https://github.com/GrahamCampbell), and is a simple HTML minifier for [Laravel 5](http://laravel.com). It utilises Mr Clay's [Minify](https://github.com/mrclay/minify) package to minify entire responses, but can also minify blade at compile time. Feel free to check out the [change log](CHANGELOG.md), [releases](https://github.com/GrahamCampbell/Laravel-HTMLMin/releases), [license](LICENSE), [api docs](http://docs.grahamjcampbell.co.uk), and [contribution guidelines](CONTRIBUTING.md).

![Laravel HTMLMin](https://cloud.githubusercontent.com/assets/2829600/4432287/a99460da-468c-11e4-9bda-18345c06b2a5.PNG)

<p align="center">
<a href="https://travis-ci.org/GrahamCampbell/Laravel-HTMLMin"><img src="https://img.shields.io/travis/GrahamCampbell/Laravel-HTMLMin/master.svg?style=flat-square" alt="Build Status"></img></a>
<a href="https://scrutinizer-ci.com/g/GrahamCampbell/Laravel-HTMLMin/code-structure"><img src="https://img.shields.io/scrutinizer/coverage/g/GrahamCampbell/Laravel-HTMLMin.svg?style=flat-square" alt="Coverage Status"></img></a>
<a href="https://scrutinizer-ci.com/g/GrahamCampbell/Laravel-HTMLMin"><img src="https://img.shields.io/scrutinizer/g/GrahamCampbell/Laravel-HTMLMin.svg?style=flat-square" alt="Quality Score"></img></a>
<a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Software License"></img></a>
<a href="https://github.com/GrahamCampbell/Laravel-HTMLMin/releases"><img src="https://img.shields.io/github/release/GrahamCampbell/Laravel-HTMLMin.svg?style=flat-square" alt="Latest Version"></img></a>
</p>


## Installation

[PHP](https://php.net) 5.4+ or [HHVM](http://hhvm.com) 3.3+, and [Composer](https://getcomposer.org) are required.

To get the latest version of Laravel HTMLMin, simply add the following line to the require block of your `composer.json` file:

```
"graham-campbell/htmlmin": "~3.0"
```

You'll then need to run `composer install` or `composer update` to download it and have the autoloader updated.

Once Laravel HTMLMin is installed, you need to register the service provider. Open up `config/app.php` and add the following to the `providers` key.

* `'GrahamCampbell\HTMLMin\HTMLMinServiceProvider'`

You can register the HTMLMin facade in the `aliases` key of your `config/app.php` file if you like.

* `'HTMLMin' => 'GrahamCampbell\HTMLMin\Facades\HTMLMin'`

#### Looking for a laravel 4 compatable version?

Checkout the [2.1 branch](https://github.com/GrahamCampbell/Laravel-HTMLMin/tree/2.1), installable by requiring `"graham-campbell/htmlmin": "~2.0"`.


## Configuration

Laravel HTMLMin supports optional configuration.

To get started, you'll need to publish all vendor assets:

```bash
$ php artisan vendor:publish
```

This will create a `config/htmlmin.php` file in your app that you can modify to set your configuration. Also, make sure you check for changes to the original config file in this package between releases.

There are a few config options:

##### Automatic Blade Optimizations

This option (`'blade'`) enables minification of the the blade views as they are compiled. These optimizations have little impact on php processing time as the optimizations are only applied once and are cached. This package will do nothing by default to allow it to be used without minifying pages automatically. The default value for this setting is `false`.

##### Force Blade Optimizations

This option (`'force'`) forces blade minification on views where there such minification may be dangerous. This should only be used if you are fully aware of the potential issues this may cause. Obviously, this setting is dependent on blade minification actually being enabled. The default value for this setting is `false`.

##### Automatic Live Optimizations

This option (`'live'`) enables minification of the html responses just before they are served. These optimizations have greater impact on php processing time as the optimizations are applied on every request. This package will do nothing by default to allow it to be used without minifying pages automatically. The default value for this setting is `false`.


## Usage

##### HTMLMin

This is the class of most interest. It is bound to the ioc container as `'htmlmin'` and can be accessed using the `Facades\HTMLMin` facade. There are five public methods of interest.

The `'blade'` method will parse a string as blade and minify it as quickly as possible. This is method the compiler class uses when blade minification is enabled.

The `'css'` and `'js'` methods will parse a string as css/js and will minify it using Mr Clay's [Minify](https://github.com/mrclay/minify) package.

The `'html'` method will parse a string as html and will minify it as best as possible using Mr Clay's [Minify](https://github.com/mrclay/minify) package. It will also be able to minify inline css and js. This is the method that is automatically used in an after filter when live minification is enabled.

The `'live'` method accepts a response object as a first parameter and will first determine if it can be minified, and then will set the response body to a minified version of the body of the response using the html minifier.

##### Facades\HTMLMin

This facade will dynamically pass static method calls to the `'htmlmin'` object in the ioc container which by default is the `HTMLMin` class.

##### Minifiers\MinifierInterface

This interface defines the public method a minifier class must implement. Such a class must only provide a `'render'` method which takes one parameter as a string, and should return a string. This package ships with 4 implementations of this interface, but these classes are not intended for public use, so have no been documented here. You can see the source [here](https://github.com/GrahamCampbell/Laravel-HTMLMin/tree/master/src/Minifiers).

##### HTMLMinServiceProvider

This class contains no public methods of interest. This class should be added to the providers array in `config/app.php`. This class will setup ioc bindings and register automatic blade/live minification based on the config.

##### Filters

You may put the `htmlmin` filter in front of your routes to live minify their responses. This filter will always minify them even when live minification is disabled because the live minification config setting defines if all html responses should be minified. This filter allows you to selectively choose which routes to minify. It may be useful for you to take a look at the [source](https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/master/src/filters.php) for this, read the [tests](https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/master/tests/Functional/FilterEnabledTest.php), or check out Laravel's [documentation](http://laravel.com/docs/routing#route-filters) if you need to.

##### Further Information

There are other classes in this package that are not documented here (such as the compiler class). This is because they are not intended for public use and are used internally by this package.

Feel free to check out the [API Documentation](http://docs.grahamjcampbell.co.uk) for Laravel HTMLMin.


## License

Laravel HTMLMin is licensed under [The MIT License (MIT)](LICENSE).
