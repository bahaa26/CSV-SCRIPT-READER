<?php

declare(strict_types = 1);

function getTransactionFiles(string $filesPath): array
{
    $files = [];

    foreach(scandir($filesPath) as $file) {
        if (is_dir($file)) {
            continue;
        }

        $files[] = $filesPath . $file;
    }

    return $files;
}

function getTransactions(string $fileName, ?callable $transactionHandler = null, ?callable $totalTransactions): array {
    if(! file_exists($fileName)) {
        trigger_error('File "' . $fileName . '" doesn\'t', E_USER_ERROR);
    }

    $file = fopen($fileName, 'r');

    fgetcsv($file);

    $transactions = [];

    while((($transaction = fgetcsv($file)) !== false) && !feof($file)) {
        if($transactionHandler !== null) {
            $transactions[] = $transactionHandler($transaction);
        } else {
            $transactions[] = $transaction;
        }
    }

    $transactions = array_merge(['transactions' => $transactions],$totalTransactions($transactions));

    return $transactions;
}

function extractTransaction(array $transactionRow): array {

    [$date, $check, $description, $amount] = $transactionRow;

    $amount = (float) str_replace(['$',','], '', $amount);

    return [
        'date' => $date,
        'checkNumber' => $check,
        'description' => $description,
        'amount' => $amount
    ];
}

function calculateTotal(array $transactions): array {
    $totals = ['netTotal' => 0, 'totalIncome' => 0, 'totalExpense' => 0];

    foreach($transactions as $transaction) {
        $totals['netTotal'] += $transaction['amount'];
        if($transaction['amount'] >= 0) {
            $totals['totalIncome'] += $transaction['amount'];
        } else {
            $totals['totalExpense'] += $transaction['amount'];
        }
    } 

    return ['total' => $totals];
//     
}
