<?php

use function ptk\tabular\sum_cols;

/**
 * Exemplos para ptk\tabular\sum_cols()
 * 
 * @see ptk\tabular\sum_cols()
 */
require 'vendor/autoload.php';

$data = [
    [
        'field1' => 1,
        'field2' => 10
    ],
    [
        'field1' => 2,
        'field2' => 20
    ],
    [
        'field1' => 3,
        'field2' => 30
    ]
];

print_r(sum_cols($data, 'field1', 'field2'));