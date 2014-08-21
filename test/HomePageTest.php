<?php

require_once 'PHPUnit/Extensions/SeleniumTestCase.php';
//class WebTest extends PHPUnit_Extensions_Selenium2TestCase
class HomePageTest extends PHPUnit_Extensions_SeleniumTestCase
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
    
//    public function testTitleOfPages()
//    {
//        $this->open('http://localhost/mvctodolist/public/');
//        $this->assertTitle('Todos');
//        $this->clickAndWait('link=Create Todo');
//        $this->clickAndWait('link=Sign Up');
//        $this->assertTitle('Sign Up');
//        $this->clickAndWait('link=Login');
//        $this->assertTitle('Login');
//        
//        /* Click on the first edit. */
//        $this->clickAndWait('link=Home');
//        $this->clickAndWait('link=Edit');
//        $this->assertTitle('Edit Todo');
//    }
    
    public function testEditInput() {
        return [
            ['write moar tests']
            
        ];
    }
    
    /**
     * @dataProvider testEditInput
     */
    
    public function testEditLink($value){
        
        $this->open('/mvctodolist/public/');
        $this->clickAndWait('link=Edit');
        $this->type('name=content');
        $this->type('name=content', $value);
        $this->clickAndWait('id=edit_submit');
        $this->assertText('id=12', $value);
    }
//    
//    public function testEditInputValueBlank(){
//        $this->open('/mvctodolist/public/');
//        $this->clickAndWait('link=Edit');
//        $this->type('name=content');
//        $this->clickAndWait('id=edit_content');
//        $this->assertText('id=edit_error', '');
//    }
   
}

?>



