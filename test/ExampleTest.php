<?php

use app\testApp\Calculator;

class CalculatorTest extends PHPUnit_Framework_TestCase {
    
    public function setUp(){
        $this->calculator = new Calculator;
    }
    
    public function inputNumbers() {
        return [
            
                [2,2,4],
                [2.5, 2.5, 5],
                [-3, 1, -2]
           
        ];
    }
    
    /**
     * @dataProvider inputNumbers
     */
    public function testAddNumbers($a, $b, $sum)
    {
            
        $this->assertEquals($sum, $this->calculator->add($a, $b));        
        
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testThrowsExceptionIfNonNumericIsPassed()
    {
      
        $this->calculator->add('a', []);
        
    }
    
    /**
         * @depends testEmpty
         */
        
        public function testPush(array $stack) {
            array_push($stack, 'foo');
            $this->assertEquals('foo', $stack[count($stack)-1]);
            $this->assertNotEmpty($stack);
            
            return $stack;
        }
        
        /**
         * @depends testPush
         */
        
        public function testPop(array $stack){
            $this->assertEquals('foo', array_pop($stack));
            $this->assertEmpty($stack);
        }
        
        public function testOne() {
            $this->assertTrue(true);
            return 'first';
        }
        
        public function testTwo(){
            $this->assertTrue(true);
            return 'second';
        }
        
        /**
         * @depends testOne
         * @depends testTwo
         */
        public function testConsumer() {
            $this->assertEquals(array('first','second'), func_get_args());
        }
}

?>

