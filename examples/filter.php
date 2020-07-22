<?php

use function ptk\tabular\filter;

/**
 * Exemplos para ptk\tabular\filter()
 * 
 * @see ptk\tabular\filter()
 */
require 'vendor/autoload.php';
require 'examples/sample_data.php';


print_r(filter($sample_data1, function(array $line): bool {
        if ($line['age'] > 20) {
            return true;
        }
        return false;
    }));
