<?php

require_once 'PHPUnit/Extensions/SeleniumTestCase.php';
//class WebTest extends PHPUnit_Extensions_Selenium2TestCase
class LoginPageTest extends PHPUnit_Extensions_SeleniumTestCase
{
    protected $captureScreenshotOnFailure = TRUE;
    protected $screenshotPath = 'C://xampp/htdocs/screenshots';
    protected $screenshotUrl = 'http://localhost/screenshots';
    
    public static $browsers = array(
        
        array(
            
            'name' => 'Linux Firefox',
            'browser' => '*firefox',
            'host' => 'localhost',
            'port' => 4444,
            'timeout' => 30000,
        ),
        
        array(
            
            'name' => 'Linux Chrome',
            'browser' => '*googlechrome',
            'host' => 'localhost',
            'port' => 4444,
            'timeout' => 30000
        )
        
//        array(
//            
//            'name' => 'Linux Chrome',
//            'browser' => '*iexplore',
//            'host' => 'localhost',
//            'port' => 4444,
//            'timeout' => 30000
//        )
    );
    
    protected function setUp()
    {   
        $this->setBrowserUrl('http://localhost/mvctodolist/public/');
    }
    
    public function testTitleOfPages()
    {
        $this->open('http://localhost/mvctodolist/public/');
        $this->assertTitle('Todos');
        $this->clickAndWait('link=Edit');
        $this->assertTitle('Edit Todo');
        $this->clickAndWait('link=Sign Up');
        $this->assertTitle('Sign Up');
        $this->clickAndWait('link=Login');
        $this->assertTitle('Login');
    }
    
//    public function testInvalidLogin() 
//    {   
//        $this->open('http://localhost/mvctodolist/public/');
//        $this->assertText('id=blue', 'blue');
//        
//    }
   
}

?>



