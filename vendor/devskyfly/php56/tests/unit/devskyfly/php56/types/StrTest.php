<?php
namespace devskyfly\php56\types;

class StrTest extends \Codeception\Test\Unit
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

    public function testIsString()
    {
        $str="Some test";
        $this->assertTrue(Str::isString($str));
        
        $nmb=123;
        $this->assertFalse(Str::isString($nmb));
    }
    
    public function testToString()
    {
        $val=123;
        $str=Str::toString($val);
        $this->assertTrue(Str::isString($str));
    }
}