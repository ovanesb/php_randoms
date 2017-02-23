<?php

/**
 * AccountsModel is used to manipulate business logic about accounts.
 *
 * @author ovanes
 */
class AccountsModel extends DB {
   
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Open a new account
     * Adding records to account table.
     * Creating 0.00 balance in balance table. 
     * Creating 0.00 overdraft in overdraft table.
     * 
     * @return array
     */
    public function createAccount(){
       
        /**
         * Insert Data for new customer account
         */
        $this->insert('accounts', array(
            'account_number' => $this->generateRandomNumber(),
            'full_name' => $this->generateRandomName(),
            'is_active' => 1
        ));
        
        $accountID = $this->driver->lastInsertRowid();

        /**
         * Create plasehoder for new account with 0.00 balance
         */
        $this->insert('deposits', array(
            'account_id' => $accountID,
            'balance' => 0.00
        ));
        
        /**
         * Create plasehoder for new account with 0.00 overdarft
         */
        $this->insert('overdrafts', array(
            'account_id' => $accountID,
            'pre_arranged_negative_balance' => 0.00
        ));
        
        return $this->getOneAccount($accountID);

    }
    
    
    /**
     * Close close a customer account
     * 
     * @param intiger $accountNo
     */
    public function closeAccount($accountNo){
        
        /**
         * Get Account id by account Number
         */
        $id = $this->selectOneRow('accounts', 'id', array(
            'account_number' => $accountNo
        ));

        /**
         * Set account status is active to 0.
         */
        $this->update('accounts', array('is_active'=>0), array('id'=>$id));
    }


    /**
     * Retrive all accounts
     * @return type
     */
    function getAllAccounts(){
        
        $results = $this->select('accounts', array(
            'is_active' => 1
        ));

        while ($row = $results->fetchArray()) {
             $allAccounts[] = array( 
                 'id' => $row['id'], 
                 'account_number' => $row['account_number'],
                 'full_name' => $row['full_name'], 
                 'is_active' => $row['is_active']
            ); 
                 
        }
        
        return $allAccounts;
       
    }
    
    /**
     * Get account summery 
     *  -current balance
     *  -applied overdraft
     * 
     * @return array
     */
    function accountSummary($accountID){
        
        $query =  "SELECT `a`.`full_name` AS 'customer_name', `a`.`account_number`, "
                . "`o`.`pre_arranged_negative_balance` AS 'agreed_overdraft',"
                . "`d`.`balance`"
                . "FROM accounts AS `a`"
                . "INNER JOIN overdrafts AS `o` ON (`o`.`account_id` = `a`.`id`)"
                . "INNER JOIN deposits AS `d` ON (`d`.`account_id` = `a`.`id`)"
                . "WHERE `a`.`id`={$accountID}";
        
        $results = $this->queryRow($query);

        while ($row = $results->fetchArray()) {
             $accountSummary = array( 
                 'Customer_Name' => $row['customer_name'], 
                 'Account_Number' => $row['account_number'],
                 'Current_Balance' => $row['balance'],
                 'Agreed_Overdraft' => $row['agreed_overdraft']
            ); 
        }
        
        return $accountSummary;
       
    }
    
    /**
     * Retrieve data for an account by account ID
     * 
     * @param array $accountID
     */
    public function getOneAccount($accountID){
        $results = $this->select('accounts', array(
            'id' => $accountID
        ));
        
        while ($row = $results->fetchArray()) {
            $anAccount = array( 'id'=>$row['id'],'customer_name' => $row['full_name'], 'account_number' => $row['account_number']);
        }
        
        return $anAccount;
    }

    
    /**
     * Generating random 9 digits number 
     * that is going to be used for customer account identifier.
     * 
     * @return string
     */
    function generateRandomNumber(){
        
        $generated_account_number = '1'.mt_rand(10000000,99999999);
         
        $result = $this->select('accounts',array(
            'account_number' => $generated_account_number
        ));
        
        $row = $result->fetchArray();
        
        if( empty($row)){
                return $generated_account_number;
        }  else {
            $this->generateRandomNumber();
        }

    }

    /**
     * Generating random name by given two arrays with random names.
     * 
     * @return string
     */
    function generateRandomName(){
        /**
         * Containing forenames.
         */
        $names = array(
            'Christopher',
            'Ryan',
            'Ethan',
            'John',
            'Zoey',
            'Sarah',
            'Michelle',
            'Samantha',
        );

        /**
         *  Containing surnames.
         */
        $surnames = array(
            'Walker',
            'Thompson',
            'Anderson',
            'Johnson',
            'Tremblay',
            'Peltier',
            'Cunningham',
            'Simpson',
            'Mercado',
            'Sellers'
        );

        /**
         * Generate a random forename.
         */
        $random_name = $names[mt_rand(0, sizeof($names) - 1)];

        /**
         * Generate a random surname.
         */
        $random_surname = $surnames[mt_rand(0, sizeof($surnames) - 1)];

        /**
         * Combine them together and print out the result.
         */
        return $random_name . ' ' . $random_surname;
    }
    
}
