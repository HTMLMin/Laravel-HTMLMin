<?php

namespace HTMLMin\Tests\HTMLMin\Functional;

use HTMLMin\HTMLMin\Compilers\MinifyCompiler;
use HTMLMin\Tests\HTMLMin\Functional\Provider\TestComponentsProvider;

class ComponentsTest extends AbstractFunctionalTestCase
{
    /**
     * Get the required service providers.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return string[]
     */
    protected function getRequiredServiceProviders($app)
    {
        return [TestComponentsProvider::class];
    }

    public function testUseComponents()
    {
        if (version_compare($this->app->version(), '7.0', '<')) {
            $this->markTestSkipped('Class components were released in Laravel version 7.0.0');
        }

        /** @var MinifyCompiler $minifyCompiler */
        $minifyCompiler = $this->app->make('view')
            ->getEngineResolver()
            ->resolve('blade')
            ->getCompiler();

        $this->assertArrayHasKey('test-component', $minifyCompiler->getClassComponentAliases());
    }
}

