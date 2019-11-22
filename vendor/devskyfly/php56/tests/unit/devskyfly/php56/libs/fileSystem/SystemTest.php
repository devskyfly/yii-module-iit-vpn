<?php
namespace devskyfly\php56\libs\fileSystem;

class SystemTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {
        $this->assertTrue(Files::fileExists(__DIR__.'/../../../../../../README.md'));
        $this->assertFalse(Files::fileExists(__DIR__.'/../../../../../../README.md1'));
    }
}