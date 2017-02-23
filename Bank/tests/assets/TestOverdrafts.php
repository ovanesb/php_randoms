<?php

require_once 'lib/Autoloader.php';

/**
 * Description of tesetAccounts
 *
 * @author ovanes
 */
class TestOverdrafts extends OverdraftController{

    public function testApplyOverdraft($accountID, $amount){
        echo "I have applied {$amount} overdraft.\n";
        $this->applyOverdraft($accountID, $amount);
    }
    
    public function testDisplayOverdraft($accountID){
        echo "I can see the allowed account pre-arranged negative balance\n";
        $this->displayOverdraft($accountID);
    }
    
}
