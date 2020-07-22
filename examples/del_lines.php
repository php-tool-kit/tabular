<?php

use function ptk\tabular\del_lines;
/**
 * Exemplos para ptk\tabular\del_lines()
 * 
 * @see ptk\tabular\del_lines()
 */

require 'vendor/autoload.php';
require 'examples/sample_data.php';


print_r(del_lines($sample_data1, 0, 2));