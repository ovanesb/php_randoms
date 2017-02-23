#!/usr/bin/php -q
<?php
require_once 'MakeTillReceipt.php';

( new MakeTillReceipt() )->produceReceipt($JSON, $customer_discount);