#!/usr/bin/php -q
<?php

class TestingTillReceipt {

    public function randomInput() {
        return json_encode(array('products' => array(
                'prod_one' => array(
                    'price' => $this->generateRandomPrices(),
                    'title' => $this->generateRandomProducts()
                ),
                'prod_two' => array(
                    'price' => $this->generateRandomPrices(),
                    'title' => $this->generateRandomProducts()
                ),
                'prod_three' => array(
                    'price' => $this->generateRandomPrices(),
                    'title' => $this->generateRandomProducts()
                ),
                'prod_four' => array(
                    'price' => $this->generateRandomPrices(),
                    'title' => $this->generateRandomProducts()
                ),
                'prod_five' => array(
                    'price' => $this->generateRandomPrices(),
                    'title' => $this->generateRandomProducts()
                )
            ),
            'loyalty_card' => array(
                'card_number' => $this->getRandomLoyaltyCard()
            )
        ));
    }
    
    
    private function generateRandomProducts(){
        /**
         * Containing products.
         */
        $products = array(
            'Apple',
            'Apricot',
            'Avocado',
            'Banana',
            'Bilberry',
            'Blackberry',
            'Blackcurrant',
            'Blueberry',
            'Baked Beans',
            'Washing Up Liquid',
            'Rubber Gloves',
            'Bread',
            'Butter'
        );

        /**
         * Generate a random products.
         */
        $random_products = $products[mt_rand(0, sizeof($products) - 1)];

        return $random_products;
    }
    
    
    private function generateRandomPrices(){
        /**
         * Containing prices.
         */
        $price = array(
            0.15,
            1.58,
            1.55,
            0.22,
            5.50,
            6.45,
            5.55,
            2.23,
        );

        /**
         * Generate a random price.
         */
        $random_price = $price[mt_rand(0, sizeof($price) - 1)];

        return $random_price;
    }
    

    private function getRandomLoyaltyCard(){
        /**
         * Containing loyalty card numbers.
         */
        $LoyaltyCard = array(
            "440000008",
            "550000008",
            "410000008",
            "510000008"
        );

        /**
         * Generate a random card number.
         */
        $randomLoyaltyCard = $LoyaltyCard[mt_rand(0, sizeof($LoyaltyCard) - 1)];

        return $randomLoyaltyCard;
    }
    

}

$generatedJSON = ( new TestingTillReceipt() )->randomInput();

require_once '../MakeTillReceipt.php';
require_once '../input_data.php';

( new MakeTillReceipt() )->produceReceipt($generatedJSON, $customer_discount);