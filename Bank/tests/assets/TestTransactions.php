<?php

require_once 'lib/Autoloader.php';

/**
 * Description of TestTransactions
 *
 * @author ovanes
 */
class TestTransactions extends TransactionController{

    public function testCreditAccount($accountID, $amount){
        echo "I have credited the account with {$amount} amount.\n";
        $this->creditAccount($accountID, $amount);
    }  
    
    public function testDisplayBalance($accountID){
        echo "The new account balance is the following \n";
        $this->displayBalance($accountID);
    }
    
    public function testWithdrawFunds($accountID, $amount){
        echo "I have withdrawn the account with {$amount} amount.\n";
        $this->withdrawFunds($accountID, $amount);
    }
    
    public function testDisplayTransactions($accountID){
        echo "I can see all account transaction done so far..\n";
        $this->displayTransactions($accountID);
    }
    
}

