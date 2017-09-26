<?php 

include_once ('MysqlDB.class.php');
$db = MysqlDB::getInstance('127.0.0.1', 'm_zenithcrusher_com', 'root','');
$data=$db->fetch("phome_ecms_case");
foreach ($data as $value) {
	$h= addslashes('<img class="width-fill" src="');
	$c=$value['titlepic'];
	$f=addslashes('" alt="" />');
	$banner=$h.$c.$f;
	echo $banner;
	$id=$value['id'];
	//echo $banner;
	//echo $id.'---';
	$count=$db->update("phome_ecms_case",array("case_banner" =>$banner),"id=$id");
	echo $count;

}



 ?>