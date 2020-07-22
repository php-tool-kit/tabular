<?php

use function ptk\tabular\merge_lines;
/**
 * Exemplos para ptk\tabular\merge_lines()
 * 
 * @see ptk\tabular\merge_lines()
 */

require 'vendor/autoload.php';
require 'examples/sample_data.php';


print_r(merge_lines($sample_data1, $sample_data2));