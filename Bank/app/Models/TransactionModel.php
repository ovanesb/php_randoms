<?php

/**
 * TransactionModel is used to manipulate business logic about funds.
 *
 * @author ovanes
 */
class TransactionModel extends DB {
   
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Credit a customer account.
     * 
     * @param double $amount
     * @param intiger $accountID
     */
    public function depositFunds($accountID, $amount){
    
        /**
         * Get current balance
         */
        $currentBalance = $this->getBalance($accountID);
        
        /**
         * Calculate new figure.
         */
        $newBalance = $currentBalance + $amount;
        
        /**
         * Update the customer account with the new value.
         */
        $this->update('deposits', array('balance'=>$newBalance), array('account_id'=>$accountID));

        /**
         * Make record for the transaction just happened.
         * About third parameter 1-Deposit, 2-Withdraw
         */
        $this->createTransaction($accountID,  1, $amount );
    }
    
    
    /**
     * Get the current balance against given customer account.
     * 
     * @param intiger $accountID
     * @return double
     */
    public function getBalance($accountID){
        
        return $this->selectOneRow('deposits', 'balance', array(
            'account_id' => $accountID
        ));
 
    }
    
    /**
     * 
     * @param intiger $accountID
     * @param intiger $transactionType
     * @param double $amount
     */
    public function createTransaction( $accountID,  $transactionType, $amount ){
        $this->insert('transactions', array(
            'account_id' => $accountID, 
            'transaction_type_id' => $transactionType,
            'amount' => $amount, 
            'created_date'  => date('Y-m-d H:i:s')
        ));
    }

    /**
     * Display customer current balance.
     * 
     * @param intiger $accountID
     * @return array
     */
    public function getCustomerBalance($accountID){
        
        $query =  "SELECT `a`.`full_name` AS 'customer_name', `a`.`account_number`, `d`.`balance` AS 'current_balance'"
                . "FROM deposits AS `d`"
                . "INNER JOIN accounts AS `a` ON (`a`.`id` = `d`.`account_id`)"
                . "WHERE `a`.`id`={$accountID}";
       
        $results = $this->queryRow($query);

        while ($row = $results->fetchArray()) {
             $displayBalance = array(
                'Cusomer_Name ' => $row['customer_name']  ,
                'Account_Number' => $row['account_number']  , 
                'Current_Balance' => $row['current_balance']  
             ); 
        }
        
        return $displayBalance;
        
    }
    
    /**
     * Withdraw an account.
     * 
     * @param intiger $accountID
     * @param double $amount
     */
    public function debitAccount($accountID, $amount){
        
        /**
         * Get current account balnace 
         */
        $currentBalance = $this->getBalance($accountID);
        
        /**
         * Get agreed overdraft if any.
         */
        $allowedOverdraft = $this->getCustoomerOverdraft($accountID);

        /**
         * Calculate new figure.
         */
        $newBalance = ( $currentBalance - $amount );

        /**
         * Check if debit(withdrawal) can happen
         */
        if( ($newBalance + $allowedOverdraft) >=0){

            /**
             * Make record for the transaction just happened.
             * About third parameter 1-Deposit, 2-Withdraw
             */
            $this->createTransaction($accountID, 2, $amount);

            /**
             * Update the customer account with the new value.
             */
            $this->update('deposits', array('balance'=>$newBalance), array('account_id'=>$accountID)); 

        }else{
            echo 'Sorry, the amount you try to withdraw exit the limit of your account.';
        }
    }
    
    /**
     * Getting customer agreed overdraft.
     * 
     * @param intiger $accountID
     * @return double
     */
    public function getCustoomerOverdraft( $accountID){
        return $this->selectOneRow('overdrafts', 'pre_arranged_negative_balance', array('account_id'=>$accountID));
    }
    
    
    public function getAccountTransactions($accountID){
        $query = "SELECT "
                . " `a`.`full_name` AS 'customer_name', `a`.`account_number`, "
                . "`t`.`amount`, `t`.`created_date`,"
                . "`lt`.`type_name`"
                . "FROM `accounts` as `a`"
                . "INNER JOIN `transactions` AS `t` ON(`t`.`account_id` = `a`.`id`)"
                . "INNER JOIN `lookup_transactions` AS `lt` ON(`lt`.`id` = `t`.`transaction_type_id`)"
                . "WHERE `a`.`id` = {$accountID} ORDER BY `created_date`;";
        
        $results = $this->queryRow($query);

        while ($row = $results->fetchArray()) {
            $accountTransactions[] = array(
                'Customer_Name' => $row['customer_name'],
                'Account_Number' => $row['account_number'],
                'Transaction_Type' => $row['type_name'],
                'Amount' => $row['amount'],
                'Date' => date("d-m-Y H:i:s",  strtotime($row['created_date']))
            );
        }

        return $accountTransactions;
        
    }
    
}
