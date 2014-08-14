<?php

require_once 'PHPUnit/Extensions/SeleniumTestCase.php';
//class WebTest extends PHPUnit_Extensions_Selenium2TestCase
class WebTest extends PHPUnit_Extensions_SeleniumTestCase
{
    protected $captureScreenshotOnFailure = TRUE;
    protected $screenshotPath = 'C://xampp/htdocs/screenshots';
    protected $screenshotUrl = 'http://localhost/screenshots';
       
    protected function setUp()
    {   
        $this->setBrowser('iexplore');
        $this->setBrowserUrl('http://localhost/mvctodolist/public/');
    }
    
    public function testTitle()
    {
        $this->open('http://localhost/mvctodolist/public/');
        $this->assertTitle('Example WWW Page');
    }
   
}

