#!/usr/bin/php -q
<?php

require_once 'lib/Autoloader.php';

$DEPOSIT_FUND = 100;
$WITHDRAW_FUND = 55;

$accountData =  ( new AccountsController() )->openAccounts();
echo "-------------------------------------------------------\n";

( new TransactionController() )->creditAccount($accountData['id'], $DEPOSIT_FUND);
echo "-------------------------------------------------------\n";

( new TransactionController() )->displayBalance($accountData['id']);
echo "-------------------------------------------------------\n";

( new TransactionController() )->withdrawFunds($accountData['id'], $WITHDRAW_FUND);
echo "-------------------------------------------------------\n";

( new TransactionController() )->displayBalance($accountData['id']);
echo "-------------------------------------------------------\n";

( new OverdraftController() )->applyOverdraft($accountData['id'], $APPLY_OVERDRAFT);
echo "-------------------------------------------------------\n";

( new OverdraftController() )->displayOverdraft($accountData['id']);
echo "-------------------------------------------------------\n";

( new AccountsController() )->showAccountSummary($accountData['id']);
echo "-------------------------------------------------------\n";

( new TransactionController() )->displayTransactions($accountData['id']);
echo "-------------------------------------------------------\n";

( new AccountsController() )->closeAccount($accountData['account_number']);
echo "-------------------------------------------------------\n";