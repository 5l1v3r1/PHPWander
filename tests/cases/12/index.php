<?php declare(strict_types = 1);

$vars = D::$vars;

// ok
echo $vars[0];

D::$vars = $_GET['d'];

// tainted
echo D::$vars;

// tainted
echo D::danger();
