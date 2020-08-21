<?php

use function ptk\tabular\reorder_cols;
/**
 * Exemplos para ptk\tabular\reorder_cols()
 * 
 * @see ptk\tabular\reorder_cols()
 */

require 'vendor/autoload.php';
require 'examples/sample_data.php';


print_r(reorder_cols($sample_data1, 'name', 'age', 'id'));