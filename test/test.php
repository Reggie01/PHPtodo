<?php
    
    //require '../vendor/autoload.php';
    class Test extends PHPUnit_Framework_TestCase {
        
        public function testHello() {
            $hello = 'hello';
            $this->assertEquals('hello', $hello);
        }
    }

?>