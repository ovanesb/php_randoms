<?php

/**
 *
 * @author ovanes
 */
abstract class Controller implements Common{
    
    public function displair($data){
        echo '<pre>' . print_r($data, 1) . '</pre>';
    }
    
    public function rounding($amount){
        return round($amount / .05) * .05;
    }
    
    public function validate($variable, $value){
        
        if( isset($value) && !empty($value) && is_numeric($value) ){
            return true;
        }else{
           throw new Exception("Missing or wrong input {$variable} Value");
        }
        
    }
    
}
