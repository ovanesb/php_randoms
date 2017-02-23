<?php

require_once 'lib/Autoloader.php';

/**
 * Description of tesetAccounts
 *
 * @author ovanes
 */
class TestAccounts extends AccountsController{

    public function testOpenAccount(){
        echo 'I have opened an account with the following data. ';
        return $this->openAccounts();
    }
    
    public function testShowAccountSummary($accountID){
        echo "I can see the account summery.\n";
        $this->showAccountSummary($accountID);
    }
    
    public function testCloseAccount($accountNo){
        echo "I can see the account have been closed..\n";
        $this->closeAccount($accountNo);
    }
    
}
