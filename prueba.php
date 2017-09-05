<?php 

date_default_timezone_set('America/Tijuana');
if(strtotime('+1 month -1 day',(strtotime("2017/09/05"))) == strtotime("2017/10/03")){
	echo "hola";
}

 ?>