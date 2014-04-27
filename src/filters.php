<?php

/**
 * This file is part of Laravel HTMLMin by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

use Illuminate\Http\Response;
use GrahamCampbell\HTMLMin\Facades\HTMLMin;

Route::filter('htmlmin', function ($route, $request, $response) {
    // check if the response is a real response and not a redirect
    if ($response instanceof Response) {
        // check if the response has a content type header
        if ($response->headers->has('Content-Type') !== false) {
            // check if the contact type header is html
            if (strpos($response->headers->get('Content-Type'), 'text/html') !== false) {
                // get the response body
                $output = $response->getOriginalContent();
                // minify the response body
                $min = HTMLMin::render($output);
                // set the response body
                $response->setContent($min);
            }
        }
    }
});
