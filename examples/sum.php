<?php

use function ptk\tabular\sum;

/**
 * Exemplos para ptk\tabular\sum()
 * 
 * @see ptk\tabular\sum()
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

print_r(sum($data, 'field1', 'field2'));