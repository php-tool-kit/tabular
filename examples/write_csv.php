<?php

use function ptk\tabular\write_csv;
/**
 * Exemplos para ptk\tabular\write_csv()
 * 
 * @see ptk\tabular\write_csv()
 */

require 'vendor/autoload.php';
require 'examples/sample_data.php';

$handle = fopen('examples/sample.csv', 'w');

write_csv($handle, $sample_data1, ';');

fclose($handle);

print_r(file('examples/sample.csv'));