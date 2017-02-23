#!/usr/bin/php -q
<?php

require_once 'lib/Autoloader.php';

$DEPOSIT_FUND = 100;
$WITHDRAW_FUND = 50;
$APPLY_OVERDRAFT = 100;

$accountData =  ( new TestAccounts() )->testOpenAccount();
echo "-------------------------------------------------------\n";

( new TestTransactions() )->testCreditAccount($accountData['id'], $DEPOSIT_FUND);
echo "-------------------------------------------------------\n";

( new TestTransactions() )->testDisplayBalance($accountData['id']);
echo "-------------------------------------------------------\n";

( new TestTransactions() )->testWithdrawFunds($accountData['id'], $WITHDRAW_FUND);
echo "-------------------------------------------------------\n";

( new TestTransactions() )->testDisplayBalance($accountData['id']);
echo "-------------------------------------------------------\n";

( new TestOverdrafts() )->testApplyOverdraft($accountData['id'], $APPLY_OVERDRAFT);
echo "-------------------------------------------------------\n";

( new TestOverdrafts() )->testDisplayOverdraft($accountData['id']);
echo "-------------------------------------------------------\n";

( new TestAccounts() )->testShowAccountSummary($accountData['id']);
echo "-------------------------------------------------------\n";

( new TestTransactions() )->testDisplayTransactions($accountData['id']);
echo "-------------------------------------------------------\n";

( new TestAccounts() )->testCloseAccount($accountData['account_number']);
echo "-------------------------------------------------------\n";

echo "Full test completed\n";


