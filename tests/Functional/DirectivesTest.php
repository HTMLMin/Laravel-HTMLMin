<?php

namespace HTMLMin\Tests\HTMLMin\Functional;

use HTMLMin\HTMLMin\Compilers\MinifyCompiler;
use HTMLMin\Tests\HTMLMin\Functional\Provider\TestDirectivesProvider;
use HTMLMin\Tests\HTMLMin\Mock\MinifyCompilerMock;

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
        /** @var MinifyCompiler $minifyCompiler */
        $minifyCompiler = $this->app->make('view')
            ->getEngineResolver()
            ->resolve('blade')
            ->getCompiler();

        $compilerMock = MinifyCompilerMock::newInstance();
        $this->assertArrayHasKey('test_directive', $compilerMock->getCompilerCustomDirectives($minifyCompiler));
    }
}
