#!/usr/bin/php -q
<?php

require_once 'lib/Autoloader.php';

$DEPOSIT_FUND = 100;

$accountData =  ( new TestAccounts() )->testOpenAccount();
echo "-------------------------------------------------------\n";

( new TestTransactions() )->testCreditAccount($accountData['id'], $DEPOSIT_FUND);
echo "-------------------------------------------------------\n";

( new TestTransactions() )->testDisplayBalance($accountData['id']);
echo "-------------------------------------------------------\n";

( new TestTransactions() )->testDisplayTransactions($accountData['id']);
echo "-------------------------------------------------------\n";

echo "Accounts testing completed\n";


