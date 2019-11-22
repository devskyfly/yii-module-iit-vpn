<?php
namespace devskyfly\php56\types;

class NmbrTest extends \Codeception\Test\Unit
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

    public function testIsDouble()
    {
        $val=0.5;
        $this->assertTrue(Nmbr::isDouble($val));
        $val=1;
        $this->assertFalse(Nmbr::isDouble($val));
    }
    
    public function testIsInteger()
    {
        $val=1;
        $this->assertTrue(Nmbr::isInteger($val));
        
        $val="str";
        $this->assertFalse(Nmbr::isInteger($val));
    }
    
    public function testIsNan()
    {
        $val=NAN;
        $this->assertTrue(Nmbr::isNan($val));
        
        $val=0.5;
        $this->assertFalse(Nmbr::isNan($val));
        
        $this->expectException(\InvalidArgumentException::class);
        
        $val="string";
        Nmbr::isNan($val);
    }

    public function testIsEqual()
    {
        $val_1=1;
        $val_2=1;
        
        $this->assertTrue(Nmbr::isEqual($val_1, $val_2));
        
        $val_1=0.9;
        $val_2=0.9;
        
        $this->assertTrue(Nmbr::isEqual($val_1, $val_2));
        
        $this->expectException(\InvalidArgumentException::class);
        
        $val_1="str";
        $val_2="str";
        
        Nmbr::isEqual($val_1, $val_2);
    }

    public function testIsNumeric()
    {
        $val=1;
        $this->assertTrue(Nmbr::isNumeric($val));
        
        $val=1.5;
        $this->assertTrue(Nmbr::isNumeric($val));
        
        $val="1.5";
        $this->assertTrue(Nmbr::isNumeric($val));
        
        $val="1.5 str";
        $this->assertFalse(Nmbr::isNumeric($val));
        
        $val="str";
        $this->assertFalse(Nmbr::isNumeric($val));
    }

    public function testToDouble()
    {
        $val="1.5";
        $this->assertTrue(Nmbr::isEqual(Nmbr::toDouble($val), 1.5));
        
        $val=1;
        $this->assertTrue(Nmbr::isEqual(Nmbr::toDouble($val), 1.0));
        
        $val="str";
        $result=Nmbr::toDouble($val);
        $this->assertEquals(0, $result);
    }
    
    public function testToInteger()
    {
        $val="1";
        $this->assertTrue(Nmbr::isEqual(Nmbr::toInteger($val), 1));
        
        $val=1;
        $this->assertTrue(Nmbr::isEqual(Nmbr::toInteger($val), 1.0));
        
        
        $val="str";
        $result=Nmbr::toInteger($val);
        $this->assertEquals(0, $result);
    }
    
    public function testToDoubleStrict()
    {
        $val="1.5";
        $this->assertTrue(Nmbr::isEqual(Nmbr::toDoubleStrict($val), 1.5));
        
        $val=1;
        $this->assertTrue(Nmbr::isEqual(Nmbr::toDoubleStrict($val), 1.0));
        
        $this->expectException(\InvalidArgumentException::class);
        
        $val="str";
        $result=Nmbr::toDoubleStrict($val);
    }
    
    public function testToIntStrict()
    {
        $val="1";
        $this->assertTrue(Nmbr::isEqual(Nmbr::toIntegerStrict($val), 1));
        
        $val=1;
        $this->assertTrue(Nmbr::isEqual(Nmbr::toIntegerStrict($val), 1.0));
        
        $this->expectException(\InvalidArgumentException::class);
        
        $val="str";
        $result=Nmbr::toIntegerStrict($val);
    }
}