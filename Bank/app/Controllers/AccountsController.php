<?php

/**
 * AccountsController
 *
 * @author ovanes
 */
class AccountsController extends Controller{
    
    /**
    * Used to open new customer account
    */
    public function openAccounts(){
        $newCustomerAccount = ( new AccountsModel() )->createAccount();
        $this->displair($newCustomerAccount);
        return $newCustomerAccount;
    }
    
    /**
     * Close current account. 
     * The data about the account will remain but account will be inactive.
     * 
     * @param intiger $accountNo
     */
    public function closeAccount($accountNo){
        
        try {
            $this->validate('Account Number', $accountNo);
            ( new AccountsModel() )->closeAccount($accountNo);
        } catch (Exception $e) {
            echo  $e->getMessage(), "\n";
        }

    }
    
    /**
     * Show all customers accounts.
     */
    public function showAllAccounts(){
        $this->displair(( new AccountsModel() )->getAllAccounts());
    }
    
    
    public function showAccountSummary($accountID){
        
        try {
            $this->validate('Account ID', $accountID);
            $this->displair(( new AccountsModel() )->accountSummary($accountID));
        } catch (Exception $e) {
            echo  $e->getMessage(), "\n";
        }
        
    }

}
