<?php
namespace devskyfly\php56\types;

class LgcTest extends \Codeception\Test\Unit
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
    public function testIsBoolean()
    {
        $val=true;
        $this->assertTrue(Lgc::isBoolean($val));
        
        $val=false;
        $this->assertTrue(Lgc::isBoolean($val));
        
        $val="string";
        $this->assertFalse(Lgc::isBoolean($val));
    }
    
    // tests
    public function testToBoolean()
    {
        $val=1;
        $result=Lgc::toBoolean($val);
        $this->assertTrue($result);
        
        $val="string";
        $result=Lgc::toBoolean($val);
        $this->assertTrue($result);
        
        $val=[1];
        $result=Lgc::toBoolean($val);
        $this->assertTrue($result);
        
        $val=0;
        $result=Lgc::toBoolean($val);
        $this->assertFalse($result);
        
        $val="";
        $result=Lgc::toBoolean($val);
        $this->assertFalse($result);
        
        $val=[];
        $result=Lgc::toBoolean($val);
        $this->assertFalse($result);
    }
}