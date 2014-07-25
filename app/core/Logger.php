<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Logger {
    
    private static $_logger = null;
    
    private function __construct() {
       
    }
    
    public static function getInstance() {
        
        if(self::$_logger === null) {
             //require_once '../vendor/autoload.php';
             self::$_logger = new Katzgrau\KLogger\Logger(__DIR__.'/logs');
        }
        return self::$_logger;
    }
}

