<?php 
function conversor_monedas($moneda_origen,$moneda_destino,$cantidad) {
	$get = file_get_contents("http://www.google.com/finance/converter?a=$cantidad&from=$moneda_origen&to=$moneda_destino");
	$get = explode("<span class=bld>",$get);
	$get = explode("</span>",$get[1]);  
	return preg_replace("/[^0-9\.]/", null, $get[0]);


}

echo conversor_monedas('MXN', 'USD', 1000);
?>