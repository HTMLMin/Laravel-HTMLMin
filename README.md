Laravel HTMLMin
===============


[![Build Status](https://img.shields.io/travis/GrahamCampbell/Laravel-HTMLMin/master.svg?style=flat)](https://travis-ci.org/GrahamCampbell/Laravel-HTMLMin)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/GrahamCampbell/Laravel-HTMLMin.svg?style=flat)](https://scrutinizer-ci.com/g/GrahamCampbell/Laravel-HTMLMin/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/GrahamCampbell/Laravel-HTMLMin.svg?style=flat)](https://scrutinizer-ci.com/g/GrahamCampbell/Laravel-HTMLMin)
[![Software License](https://img.shields.io/badge/license-Apache%202.0-brightgreen.svg?style=flat)](LICENSE.md)
[![Latest Version](https://img.shields.io/github/release/GrahamCampbell/Laravel-HTMLMin.svg?style=flat)](https://github.com/GrahamCampbell/Laravel-HTMLMin/releases)


## Introduction

Laravel HTMLMin was created by, and is maintained by [Graham Campbell](https://github.com/GrahamCampbell), and is a simple HTML minifier for [Laravel 4.2+](http://laravel.com). It utilises Mr Clay's [Minify](https://github.com/mrclay/minify) package to minify entire responses, but can also minify blade at compile time. Feel free to check out the [change log](CHANGELOG.md), [releases](https://github.com/GrahamCampbell/Laravel-HTMLMin/releases), [license](LICENSE.md), [api docs](http://docs.grahamjcampbell.co.uk), and [contribution guidelines](CONTRIBUTING.md).


## Installation

[PHP](https://php.net) 5.4.7+ or [HHVM](http://hhvm.com) 3.1+, and [Composer](https://getcomposer.org) are required.

To get the latest version of Laravel HTMLMin, simply require `"graham-campbell/htmlmin": "~2.0"` in your `composer.json` file. You'll then need to run `composer install` or `composer update` to download it and have the autoloader updated.

Once Laravel HTMLMin is installed, you need to register the service provider. Open up `app/config/app.php` and add the following to the `providers` key.

* `'GrahamCampbell\HTMLMin\HTMLMinServiceProvider'`

You can register the HTMLMin facade in the `aliases` key of your `app/config/app.php` file if you like.

* `'HTMLMin' => 'GrahamCampbell\HTMLMin\Facades\HTMLMin'`


## Configuration

Laravel HTMLMin supports optional configuration.

To get started, first publish the package config file:

    php artisan config:publish graham-campbell/htmlmin

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

The `'css'` method will parse a string as css and will minify it as best as possible using Mr Clay's [Minify](https://github.com/mrclay/minify) package.

The `'js'` method will parse a string as js and will minify it as best as possible using Mr Clay's [Minify](https://github.com/mrclay/minify) package.

The `'html'` method will parse a string as html and will minify it as best as possible using Mr Clay's [Minify](https://github.com/mrclay/minify) package. It will also be able to minify inline css and js. This is the method that is automatically used in an after filter when live minification is enabled.

The `'live'` method accepts a response object as a first parameter and will first determine if it can be minified, and then will set the response body to a minified version of the body of the response using the html minifier.

##### Facades\HTMLMin

This facade will dynamically pass static method calls to the `'htmlmin'` object in the ioc container which by default is the `HTMLMin` class.

##### HTMLMinServiceProvider

This class contains no public methods of interest. This class should be added to the providers array in `app/config/app.php`. This class will setup ioc bindings and register automatic blade/live minification based on the config.

##### Filters

You may put the `htmlmin` filter in front of your routes to live minify their responses. This filter will always minify them even when live minification is disabled because the live minification config setting defines if all html responses should be minified. This filter allows you to selectively choose which routes to minify. It may be useful for you to take a look at the [source](https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/master/src/filters.php) for this, read the [tests](https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/master/tests/Functional/FilterEnabledTest.php), or check out Laravel's [documentation](http://laravel.com/docs/routing#route-filters) if you need to.

##### Further Information

There are other classes in this package that are not documented here. This is because they are not intended for public use and are used internally by this package.

Feel free to check out the [API Documentation](http://docs.grahamjcampbell.co.uk) for Laravel HTMLMin.

You may see an example of implementation in [Bootstrap CMS](https://github.com/GrahamCampbell/Bootstrap-CMS).


## License

Apache License

Copyright 2013-2014 Graham Campbell

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

 http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
