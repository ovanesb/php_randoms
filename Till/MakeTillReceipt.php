#!/usr/bin/php -q
<?php

require_once 'input_data.php';
require_once 'receiptInterface.php';

/**
 * Producing a till receipt.
 */

class MakeTillReceipt implements receiptInterface{
    
    /**
     * It will contain list of the customer items.
     * 
     * @var mixed 
     */
    private $inputItems;
    
    /**
     * It will contain list of loyalty cards
     * 
     * Used to check about discount.
     * 
     * @var mixed 
     */
    private $inputDiscount;

    /**
     * 
     * Converting json to array.
     * And save it in object
     * 
     * @param string(JSON) $input
     * @param string(JSON) $discount
     */
    private function handleInput($input, $discount){
        $this->inputItems = json_decode($input, 1);
        $this->inputDiscount = json_decode($discount, 1);
    }

    /**
     * Run the flow
     * 
     * @param string(JSON)  $input
     * @param string(JSON) $discount
     */
    public function produceReceipt($input, $discount){
        $this->handleInput($input, $discount);
        $this->prepare();
    }
    
    /**
     * Preparing the complete customer receipt.
     */
    public function prepare(){
        $price = 0 ;
        $applyDiscount = $this->applyDiscount();
        
        $this->createLine();
        echo "-    Item   - Price -\n";
        foreach ($this->inputItems['products'] as $key => $val){
            echo "------------------------------------\n";
            echo $val['title'] . '  -   ' .  $val['price'] . "\n";
            $price += $val['price'];
        }
        $this->createLine();
        echo "\n";
        $this->createLine();
        echo "Sub-Total - " . $price . "\n";
        $this->createLine();
        echo "Discounts - {$applyDiscount}\n"; 
        $this->createLine();
        echo "\n";
        $this->createLine();
        echo "Grand Total -  " . ($price - $applyDiscount ). "\n" ;
        $this->createLine();
    }
    
    /**
     * 
     * Find if a customer have got loyalty card and apply discount against it.
     * 
     * @return string
     */
    public function applyDiscount(){

        foreach ($this->inputDiscount as $k => $v){
            if ($this->inputItems['loyalty_card']['card_number'] == $k) {
                return $v['discount'];
            }
        }
        
        return '0';
        
    }
    
    /**
     * Create line.
     */
    private function createLine(){
        echo "------------------------------------\n";
    }

    
}