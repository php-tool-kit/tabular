<?php

use function ptk\tabular\duplicates;

/**
 * Exemplos para ptk\tabular\duplicates()
 * 
 * @see ptk\tabular\duplicates()
 */
require 'vendor/autoload.php';

$data = [
    [1,2,3],
    [2,3,4],
    [3,4,5],
    [4,5,6],
    ["1",2,3],
    [1,2,3],
    [4,5,6]
];

print_r(duplicates($data));
print_r(duplicates($data, false));