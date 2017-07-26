<?php

/*
 * This file is part of Laravel HTMLMin.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 * (c) Raza Mehdi <srmk@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HTMLMin\Tests\HTMLMin\Facades;

use GrahamCampbell\TestBenchCore\FacadeTrait;
use HTMLMin\HTMLMin\Facades\HTMLMin as Facade;
use HTMLMin\HTMLMin\HTMLMin;
use HTMLMin\Tests\HTMLMin\AbstractTestCase;

/**
 * This is the htmlmin facade test class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class HTMLMinTest extends AbstractTestCase
{
    use FacadeTrait;

    /**
     * Get the facade accessor.
     *
     * @return string
     */
    protected function getFacadeAccessor()
    {
        return 'htmlmin';
    }

    /**
     * Get the facade class.
     *
     * @return string
     */
    protected function getFacadeClass()
    {
        return Facade::class;
    }

    /**
     * Get the facade root.
     *
     * @return string
     */
    protected function getFacadeRoot()
    {
        return HTMLMin::class;
    }
}
