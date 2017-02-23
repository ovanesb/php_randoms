#!/usr/bin/php -q
<?php

require_once 'lib/Autoloader.php';

$DEPOSIT_FUND = 100;
$WITHDRAW_FUND = 50;
$APPLY_OVERDRAFT = 100;

$accountData =  ( new TestAccounts() )->testOpenAccount();
echo "-------------------------------------------------------\n";

( new TestOverdrafts() )->testApplyOverdraft($accountData['id'], $APPLY_OVERDRAFT);
echo "-------------------------------------------------------\n";

( new TestOverdrafts() )->testDisplayOverdraft($accountData['id']);
echo "-------------------------------------------------------\n";

echo "Overdraft test completed\n";


