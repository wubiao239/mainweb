<?php 


 if(strpos($bqsr['titleurl'], "http://")==false){
 	echo "http://m.sbmchina.com".$bqsr['titleurl'];
	
}else{
	echo $bqsr['titleurl'];
}
 ?>
