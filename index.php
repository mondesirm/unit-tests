<?php

require 'vendor/autoload.php';

use Classes\Calc;

$calc = new Calc();
$res = $calc->mul(2, 3);

echo $res;