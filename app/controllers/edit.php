<?php

class Edit extends Controller {

    public function __construct(){}
    
    public function index(){
        $request = getServerRequest();
        if($request == 'GET'){
            $this->get();
        } else if($request == 'POST' ){
        
        }
    }
    
    public function get(){
        
    }

}

?>