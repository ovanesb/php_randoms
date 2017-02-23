<?php

/**
 * TransactionController
 *
 * @author ovanes
 */
class TransactionController extends Controller{
    
    /**
     * Credit an account
     *  
     * @param index $accountID
     */
    public function creditAccount($accountID, $amount){
        
        try {
            
            $this->validate('Account ID', $accountID);
            $this->validate('Amount', $amount);
            
            $rounded = $this->rounding($amount);
            $this->displair( ( new TransactionModel() )->depositFunds($accountID, $rounded) );
            
        } catch (Exception $e) {
            echo  $e->getMessage(), "\n";
        }

    }
    
    /**
     * Dispaly customer current balance.
     * 
     * @param intiger $accountID
     */
    public function displayBalance($accountID){
        
        try {
            $this->validate('Account ID', $accountID);
            $this->displair( ( new TransactionModel() )->getCustomerBalance($accountID) );
        } catch (Exception $e) {
            echo  $e->getMessage(), "\n";
        }

    }
    
    /**
     * Debit customer account
     * 
     * @param intiger $accountID
     * @param double $amount
     */
    public function withdrawFunds($accountID, $amount){
        try {
            $this->validate('Account ID', $accountID);
            $this->validate('Amount', $amount);
            $rounded = $this->rounding($amount);
            $this->displair( ( new TransactionModel() )->debitAccount($accountID, $rounded) );
        } catch (Exception $e) {
            echo  $e->getMessage(), "\n";
        }
    }
    
    /**
     * Display customer transactions.
     */
    public function displayTransactions($accountID){
        try {
            $this->validate('Account ID', $accountID);
            $this->displair( (new TransactionModel() )->getAccountTransactions($accountID) );
        } catch (Exception $e) {
            echo  $e->getMessage(), "\n";
        }
    }
    
}
