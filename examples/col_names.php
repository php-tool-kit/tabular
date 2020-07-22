<?php

use function ptk\tabular\col_names;
/**
 * Exemplos para ptk\tabular\col_names()
 * 
 * @see ptk\tabular\col_names()
 */

require 'vendor/autoload.php';
require 'examples/sample_data.php';


print_r(col_names($sample_data1));