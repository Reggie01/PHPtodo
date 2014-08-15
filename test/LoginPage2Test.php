<?php

class LoginPage2Test extends PHPUnit_Extensions_Selenium2TestCase
{
    protected $captureScreenshotOnFailure = TRUE;
    protected $screenshotPath = 'C://xampp/htdocs/screenshots';
    protected $screenshotUrl = 'http://localhost/screenshots';
    
    protected function setUp()
    {
       $this->setBrowser('firefox');
       $this->setBrowserUrl('http://localhost/mvctodolist/public/');
    }
    
    public function testTitleName()
    {
        $this->url('http://localhost/mvctodolist/public/');
        $this->assertEquals('Todos', $this->title());
        
    }
    
    public function testDivName()
    {
        $this->url('http://localhost/mvctodolist/public');
        //$this->assertText
    }
}

?>

