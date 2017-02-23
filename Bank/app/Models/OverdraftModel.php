<?php

/**
 * OverdraftModel is used to manipulate business logic about Overdrafts
 *
 * @author ovanes
 */
class OverdraftModel extends DB {
   
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Update/Apply overdraft limit to a customer account.
     * 
     * @param intiger $accountID
     * @param double $overdraft
     */
    public function applyAgreedOverdraft($accountID, $overdraft){
        $this->update('overdrafts', array('pre_arranged_negative_balance'=>$overdraft), array('account_id'=>$accountID));
    }
    
    /**
     * Display a cutomer ovedraft
     * 
     * @param intiger $accountID
     * @return array
     */
    public function getCustomerOverdraft($accountID){
        
        $query =  "SELECT `a`.`full_name` AS 'customer_name', `a`.`account_number`, `o`.`pre_arranged_negative_balance` AS 'agreed_overdraft'"
                . "FROM accounts AS `a`"
                . "INNER JOIN overdrafts AS `o` ON (`o`.`account_id` = `a`.`id`)"
                . "WHERE `a`.`id`={$accountID}";
        
        $results = $this->queryRow($query);

        while ($row = $results->fetchArray()) {
             $displayOverdraft = array(
                'Cusomer_Name' => $row['customer_name']  ,
                'Account_Number' => $row['account_number']  , 
                'Agreed_Overdraft' => $row['agreed_overdraft']  
            ); 
        }
        
        return $displayOverdraft;
        
    }

}
