Laravel HTMLMin
===============


[![Latest Stable Version](https://poser.pugx.org/graham-campbell/htmlmin/v/stable.png)](https://packagist.org/packages/graham-campbell/htmlmin)
[![Build Status](https://travis-ci.org/GrahamCampbell/Laravel-HTMLMin.png?branch=master)](https://travis-ci.org/GrahamCampbell/Laravel-HTMLMin)
[![Latest Unstable Version](https://poser.pugx.org/graham-campbell/htmlmin/v/unstable.png)](https://packagist.org/packages/graham-campbell/htmlmin)
[![Build Status](https://travis-ci.org/GrahamCampbell/Laravel-HTMLMin.png?branch=develop)](https://travis-ci.org/GrahamCampbell/Laravel-HTMLMin)
[![Total Downloads](https://poser.pugx.org/graham-campbell/htmlmin/downloads.png)](https://packagist.org/packages/graham-campbell/htmlmin)
[![Still Maintained](http://stillmaintained.com/GrahamCampbell/Laravel-HTMLMin.png)](http://stillmaintained.com/GrahamCampbell/Laravel-HTMLMin)


[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/GrahamCampbell/laravel-htmlmin/trend.png)](https://bitdeli.com/free "Bitdeli Badge")


Copyright © [Graham Campbell](https://github.com/GrahamCampbell) 2013  


## THIS ALPHA RELEASE IS FOR TESTING ONLY


## What Is Laravel HTMLMin?

Laravel HTMLMin Is A Simple HTML Minifier For [Laravel 4](http://laravel.com).  

* Laravel HTMLMin was created by, and is maintained by [Graham Campbell](https://github.com/GrahamCampbell).  
* Laravel HTMLMin uses [Travis CI](https://travis-ci.org/GrahamCampbell/Laravel-HTMLMin) to run tests to check if it's working as it should.  
* Laravel HTMLMin uses [Composer](https://getcomposer.org) to load and manage dependencies.  
* Laravel HTMLMin provides a [change log](https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/master/CHANGELOG.md), [releases](https://github.com/GrahamCampbell/Laravel-HTMLMin/releases), and a [wiki](https://github.com/GrahamCampbell/Laravel-HTMLMin/wiki).  
* Laravel HTMLMin is licensed under the MIT, available [here](https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/master/LICENSE.md).  


## System Requirements

* PHP 5.3.3+, 5.4+ or PHP 5.5+ is required.
* You will need [Laravel 4](http://laravel.com) because this package is designed for it.  
* You will need [Composer](https://getcomposer.org) installed to load the dependencies of Laravel HTMLMin.  


## Installation

Please check the system requirements before installing Laravel HTMLMin.  

To get the latest version of HTMLMin, simply require it in your `composer.json` file.

`"graham-campbell/htmlmin": "dev-master"`

You'll then need to run `composer install` or `composer update` to download it and have the autoloader updated.

Once HTMLMin is installed, you need to register the service provider. Open up `app/config/app.php` and add the following to the `providers` key.

`'GrahamCampbell\HTMLMin\HTMLMinServiceProvider'`

You can register the HTMLMin facade in the `aliases` key of your `app/config/app.php` file if you like.

`'HTMLMin' => 'GrahamCampbell\HTMLMin\Facades\HTMLMin'`


## Updating Your Fork

The latest and greatest source can be found on [GitHub](https://github.com/GrahamCampbell/Laravel-HTMLMin).  
Before submitting a pull request, you should ensure that your fork is up to date.  

You may fork Laravel HTMLMin:  

    git remote add upstream git://github.com/GrahamCampbell/Laravel-HTMLMin.git

The first command is only necessary the first time. If you have issues merging, you will need to get a merge tool such as [P4Merge](http://perforce.com/product/components/perforce_visual_merge_and_diff_tools).  

You can then update the branch:  

    git pull --rebase upstream master
    git push --force origin <branch_name>

Once it is set up, run `git mergetool`. Once all conflicts are fixed, run `git rebase --continue`, and `git push --force origin <branch_name>`.  


## License

The MIT License (MIT)

Copyright (c) 2013 Graham Campbell

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
