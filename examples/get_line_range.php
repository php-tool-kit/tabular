<?php

use function ptk\tabular\get_line_range;
/**
 * Exemplos para ptk\tabular\get_line_range()
 * 
 * @see ptk\tabular\get_line_range()
 */

require 'vendor/autoload.php';
require 'examples/sample_data.php';


print_r(get_line_range($sample_data1, 1,2));