<?php

use function ptk\tabular\merge_cols;
use function ptk\tabular\sort;

/**
 * Exemplos para ptk\tabular\sort()
 * 
 * @see ptk\tabular\sort()
 */
require 'vendor/autoload.php';
require 'examples/sample_data.php';


print_r(sort(merge_cols($sample_data1, $sample_data3), [
    'sex' => SORT_ASC,
    'id' => SORT_DESC
]));