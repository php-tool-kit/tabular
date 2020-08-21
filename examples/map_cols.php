<?php

use function ptk\tabular\map_cols;
/**
 * Exemplos para ptk\tabular\map_cols()
 * 
 * @see ptk\tabular\map_cols()
 */

require 'vendor/autoload.php';
require 'examples/sample_data.php';

print_r(map_cols($sample_data1, function($cell){
    return strtoupper($cell);
}, 'name'));