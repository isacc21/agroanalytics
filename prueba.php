<?php 
date_default_timezone_set('America/Tijuana');

$foo = '2017/10/18';
$bar = strtotime($foo);
$candy = strtotime('-1 month +3 days',$bar);
echo date('d/m/Y',$candy);
echo '<br>';
echo date('d/m/Y');
 ?>