<?php

use function ptk\tabular\sum_lines;

/**
 * Exemplos para ptk\tabular\sum_lines()
 * 
 * @see ptk\tabular\sum_lines()
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

print_r(sum_lines($data, 'total','field1', 'field2'));