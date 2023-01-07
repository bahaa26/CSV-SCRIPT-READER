<!DOCTYPE html>
<html>

<head>
    <title>Transactions</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            margin-bottom: 150px;
            margin-top: 50px;
        }

        table tr th,
        table tr td {
            padding: 5px;
            border: 1px #eee solid;
        }

        tfoot tr th,
        tfoot tr td {
            font-size: 20px;
        }

        tfoot tr th {
            text-align: right;
        }
    </style>
</head>

<body>
    <?php if (!empty($transactions_files)) : ?>
        <?php foreach ($transactions_files as $file) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Check #</th>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <? if (!empty($file)) : ?>
                        <?php foreach ($file['transactions'] as $transactions) : ?>
                            <tr>
                                <td><?= mainFormatDate($transactions['date']) ?? 0 ?></td>
                                <td><?= $transactions['checkNumber'] ?? 0 ?></td>
                                <td><?= $transactions['description'] ?? 0 ?></td>
                                <td style="color: <?=  changeColorForAmount($transactions['amount']) ?>">
                                    <?= formatDollarAmount($transactions['amount']) ?? 0 ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Total Income:</th>
                        <td style="color: <?=  changeColorForAmount($file['total']['totalIncome']) ?>" ><?= formatDollarAmount($file['total']['totalIncome']) ?? 0 ?></td>
                    </tr>
                    <tr>
                        <th colspan="3">Total Expense:</th>
                        <td style="color: <?=  changeColorForAmount($file['total']['totalExpense']) ?>" ><?= formatDollarAmount($file['total']['totalExpense']) ?? 0 ?></td>
                    </tr>
                    <tr>
                        <th colspan="3">Net Total:</th>
                        <td style="color: <?=  changeColorForAmount($file['total']['netTotal']) ?>" ><?= formatDollarAmount($file['total']['netTotal']) ?? 0 ?></td>
                    </tr>
                <? endif ?>
                </tfoot>
            </table>
        <?php endforeach ?>
    <?php endif ?>
</body>

</html>