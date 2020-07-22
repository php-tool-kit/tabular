<?php

use function ptk\tabular\del_cols;
/**
 * Exemplos para ptk\tabular\del_cols()
 * 
 * @see ptk\tabular\del_cols()
 */

require 'vendor/autoload.php';
require 'examples/sample_data.php';


print_r(del_cols($sample_data1, 'id', 'age'));