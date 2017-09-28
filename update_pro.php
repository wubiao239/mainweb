<?php 
include_once ('MysqlDB.class.php');
include_once("getparameter.php");
$db = MysqlDB::getInstance('127.0.0.1', 'm_zenithcrusher_com', 'root','');

$pd = $db->fetch("phome_ecms_product_data_1");
//$sd = $db->fetch("phome_ecms_specification");
function str_replace_limit($search, $replace, $subject, $limit=-1){  
    if(is_array($search)){  
        foreach($search as $k=>$v){  
            $search[$k] = '`'. preg_quote($search[$k], '`'). '`';  
        }  
    }else{  
        $search = '`'. preg_quote($search, '`'). '`';  
    }  
    return preg_replace($search, $replace, $subject, $limit);  
}  
foreach ($pd as $key => $value) {
	$proid=$value[id];
	$newstext=$value[newstext];
	$sd = $db->fetch("phome_ecms_specification","where product_id={$proid}");
	$urla=array();
	foreach($sd as $key=>$value){
		$urla[]=$value[titleurl];
	}
	//print_r($urla);
	foreach ($urla as $key => $value) {
		$newstext=str_replace_limit("#", $value,$newstext,1);
	}
	echo $newstext;
	//$db->update("phome_ecms_product_data_1", array("newstext"=>$newstext), "id={$proid}")
	
}
 ?>