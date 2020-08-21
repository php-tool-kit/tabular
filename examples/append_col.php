<?php

use function ptk\tabular\append_col;
/**
 * Exemplos para ptk\tabular\append_col()
 * 
 * @see ptk\tabular\append_col()
 */

require 'vendor/autoload.php';
require 'examples/sample_data.php';

print_r(
    append_col($sample_data1, 'year', [1981, 1983, 2015])
);