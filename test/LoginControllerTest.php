<?php
    
    class LoginControllerTest extends PHPUnit_Framework_TestCase {
        
        public function setUp() {
            $this->login = new Login;
            $this->validation = new Validation();
            $this->login->setValidation($this->validation);
        }
        
        public function userInputValues() {
            return [

                ['fo', './,'],
                ['...', '456'],
                ['121', 'blue']

            ];
        }
    
        /**
         * @dataProvider userInputValues
         */
        public function testUsersInputValid($username, $password)
        {
            $this->login->checkUserInputsValid($username, $password);
            $this->assertEquals(false, $this->login->have_error);

        }
        
        public function testUser() {
            $stub = $this->getMock('User');
            
            //Configure the stub.
            $stub->method('verifyUser')
                 ->willReturn('true');
            
            // Calling $stub->verifyUser() will now return 'true'
            $this->assertEquals('true', $stub->verifyUser('1', '2', '3'));
            
            //$this->login->verifyUserExists('foo', 'foo', $stub);
            
        }
        
        /**
         * @depends testUser
         */
        
        public function testVerifyUserExists() {
            
              
        }
        
    }

?>