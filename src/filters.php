<?php

/*
 * This file is part of Laravel HTMLMin.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use GrahamCampbell\HTMLMin\Facades\HTMLMin;

Route::filter('htmlmin', function ($route, $request, $response) {
    HTMLMin::live($response);
});
