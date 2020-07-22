<?php

use function ptk\tabular\get_lines;
/**
 * Exemplos para ptk\tabular\get_lines()
 * 
 * @see ptk\tabular\get_lines()
 */

require 'vendor/autoload.php';
require 'examples/sample_data.php';


print_r(get_lines($sample_data1, 0, 2));