<?php

use function ptk\tabular\check_structure;
/**
 * Exemplos para ptk\tabular\check_structure()
 * 
 * @see ptk\tabular\check_structure()
 */

require 'vendor/autoload.php';
require 'examples/sample_data.php';


try{
    if(check_structure($sample_data1)){
        echo "Dados são válidos", PHP_EOL;
    }
} catch (Exception $ex) {
    echo $ex->getMessage(), PHP_EOL;
}