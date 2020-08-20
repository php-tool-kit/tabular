<?php

use function ptk\tabular\col_names;
use function ptk\tabular\set_col_names;
/**
 * Exemplos para ptk\tabular\set_col_names()
 * 
 * @see ptk\tabular\set_col_names()
 */

require 'vendor/autoload.php';
require 'examples/sample_data.php';

print_r(col_names($sample_data1));

print_r(
    col_names(
        set_col_names($sample_data1, 'codigo', 'nome', 'idade')
    )
);

