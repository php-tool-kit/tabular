<?php

use function ptk\tabular\seek;

/**
 * Exemplos para ptk\tabular\seek()
 * 
 * @see ptk\tabular\seek()
 */
require 'vendor/autoload.php';
require 'examples/sample_data.php';


print_r(seek($sample_data1, function(array $line): bool {
        if ($line['age'] > 20) {
            return true;
        }
        return false;
    }));
