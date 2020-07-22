<?php

use function ptk\tabular\get_cols;
/**
 * Exemplos para ptk\tabular\get_cols()
 * 
 * @see ptk\tabular\get_cols()
 */

require 'vendor/autoload.php';
require 'examples/sample_data.php';


print_r(get_cols($sample_data1, 'name', 'age'));