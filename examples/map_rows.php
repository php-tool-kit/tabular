<?php

use function ptk\tabular\map_rows;
/**
 * Exemplos para ptk\tabular\map_rows()
 * 
 * @see ptk\tabular\map_rows()
 */

require 'vendor/autoload.php';
require 'examples/sample_data.php';

print_r(map_rows($sample_data1, function($line){
    $info= "My name is {$line['name']} and I am {$line['age']} years old.";
    return array_merge($line, ['info' => $info]);
}));