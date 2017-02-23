<?php

/**
 * OverdraftController
 *
 * @author ovanes
 */
class OverdraftController extends Controller{
    
    /**
     * Apply overdraft to an account.
     *  
     * @param index $accountID
     */
    public function applyOverdraft($accountID, $overdraft){
        
        try {
            $this->validate('Account ID', $accountID);
            $this->validate('Overdraft', $overdraft);
            
            $rounded = $this->rounding($overdraft);
            
            ( new OverdraftModel() )->applyAgreedOverdraft($accountID, $rounded);
        } catch (Exception $e) {
            echo  $e->getMessage(), "\n";
        }

    }
    
    /**
     * Display cutomer overdraft.
     * 
     * @param intiger $accountID
     */
    public function displayOverdraft($accountID){
        
        try {
            $this->validate('Account ID', $accountID);
            $this->displair( ( new OverdraftModel() )->getCustomerOverdraft($accountID) );
        } catch (Exception $e) {
            echo  $e->getMessage(), "\n";
        }
        
    }

}
