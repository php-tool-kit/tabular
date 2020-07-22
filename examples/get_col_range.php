<?php

use function ptk\tabular\get_col_range;
/**
 * Exemplos para ptk\tabular\get_col_range()
 * 
 * @see ptk\tabular\get_col_range()
 */

require 'vendor/autoload.php';
require 'examples/sample_data.php';


print_r(get_col_range($sample_data1, 'name', 'age'));
print_r(get_col_range($sample_data1, '', 'name'));
print_r(get_col_range($sample_data1, 'name', ''));