<?php

use function ptk\tabular\search;

/**
 * Exemplos para ptk\tabular\search()
 * 
 * @see ptk\tabular\search()
 */
require 'vendor/autoload.php';
require 'examples/sample_data.php';


print_r(
    search($sample_data1, '/mary/i', 'name')
);
