<?php

use function ptk\tabular\merge_cols;
/**
 * Exemplos para ptk\tabular\merge_cols()
 * 
 * @see ptk\tabular\merge_cols()
 */

require 'vendor/autoload.php';
require 'examples/sample_data.php';


print_r(merge_cols($sample_data1, $sample_data3));