<?php

use function ptk\tabular\read_csv;
/**
 * Exemplos para ptk\tabular\read_csv()
 * 
 * @see ptk\tabular\read_csv()
 */

require 'vendor/autoload.php';
require 'examples/sample_data.php';

$handle = fopen('examples/sample.csv', 'r');

print_r(read_csv($handle, ';'));

fclose($handle);
