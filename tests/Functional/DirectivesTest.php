<?php

namespace HTMLMin\Tests\HTMLMin\Functional;

class DirectivesTest extends AbstractFunctionalTestCase
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
        return [TestDirectivesProvider::class];
    }

    public function testUseDirectives()
    {
        $this->app->view->addNamespace('stubs', realpath(__DIR__.'/stubs'));

        $actual = $this->app->view->make('stubs::directive')->render();

        $this->assertSame(TestDirectivesProvider::testDirective(), $actual);
    }

    public function testUseAliasComponents()
    {
        if (version_compare($this->app->version(), '5.4', '<')) {
            $this->markTestSkipped('Component Aliases were released in Laravel version 5.6.0');
        }

        $this->app->view->addNamespace('stubs', realpath(__DIR__.'/stubs'));

        $actual = $this->app->view->make('stubs::useAliasComponent')->render();

        $expected = file_get_contents(__DIR__.'/stubs/aliasComponent.blade.php');

        $this->assertSame($expected, $actual);
    }
}
