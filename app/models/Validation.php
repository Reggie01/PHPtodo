<?php

class Validation {

    public function __construct() {
        $logger = Logger::getInstance();
        $logger->debug('Validation object created');
    }

    public function validUsername($username) {
        $logger = Logger::getInstance();
        $logger->debug('Validating user name.');
        if (!empty($username)) {
            $regexForValidUser = '/([a-zA-Z0-9_-]){3,20}$/';
            if (preg_match($regexForValidUser, $username)) {
                $logger->debug("Validation passed for user");
                return TRUE;
            } else {
                $logger->debug("Valid failed for user");
                return FALSE;
            }
        }   
        $logger->debug("Username validation failed.");
        return FALSE;
        
    }
    
    public function validPassword($password) {
        $logger = Logger::getInstance();
        $logger->debug('Validating password.');
        if (!empty($password)) {
            $regexForValidPassword = '/.{3,20}/';
            if (preg_match($regexForValidPassword, $password)) {
                $logger->debug('Validation passed for password.');
                return TRUE;
            } else {
                $logger->debug('Validation failed for password.');
                return FALSE;
            }
        }
        $logger->debug('Validation failed for password.');
        return FALSE;
    }
    
    public function verifyPassword($password, $verify) {
        $logger = Logger::getInstance();
        $logger->debug('Verifying passwords match.');
        if (!empty($verify)) {
            if ($verify === $password) {
                $logger->debug('Verification passed.');
                return True;
            }
            $logger->debug('Verification failed.');
            return False;
        } else {
            $logger->debug('Verification failed.');
            return False;
        }
    }
}
    