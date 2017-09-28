<?php 

include_once ('MysqlDB.class.php');
include_once("getparameter.php");
$db = MysqlDB::getInstance('127.0.0.1', 'm_zenithcrusher_com', 'root','');

//$data = $db->fetch("phome_ecms_news_index"," WHERE id =655");

//$data=$query->fetchAll();
//print_r($data);

$sourcea=get_source("./text/parameter30-40.txt");
//print_r($sourcea);
foreach ($sourcea as $source) {
	$re = $db->query("select max(id) from phome_ecms_specification");
	$result=$re->fetch();
	$id=$result[0];
	$filename=$id+1;
	
	//print_r($source);
	$title = $source['title'];
	//$filename=urlencode(strtolower($title));
	$time = $source['time'];
	$product_id=$source['product_id'];
	//echo $product_id;
	//$time=strtotime("2012-12-10");
	$content = $source['content'];
	//产品数据表中字段
	$specificationfield = array(
	    "classid" => 23,
	    "ttid" => 0,
	    "onclick" => 0,
	    "plnum" => 0,
	    "totaldown" => 0,
	    "newspath" => "",
	    "filename" => $filename,
	    "userid" => 2,
	    "username" =>"武镖",
	    "firsttitle" => 0,
	    "isgood" => 0,
	    "ispic" => 0,
	    "istop" => 0,
	    "isqf" => 0,
	    "ismember" => 0,
	    "isurl" => 0,
	    "truetime" => $time,
	    "lastdotime" => $time,
	    "havehtml" => 1,
	    "groupid" => 0,
	    "userfen" => 0,
	    "titlefont" => "",
	    "titleurl" => "/specification/{$filename}.html",
	    "stb" => 1,
	    "fstb" => 1,
	    "restb" => 1,
	    "keyboard" => "",
	    "title" => $title,
	    "newstime" => $time,
	    "titlepic" => "",
	    "smalltext" => $title,
	    "diggtop" => 0,
	    "related_products"=>"",
	    "product_id"=>$product_id
	    
	);
	$data = $db->insert("phome_ecms_specification", $specificationfield);
	echo "insert phome_ecms_specification success".PHP_EOL;
	$re = $db->query("select * from phome_ecms_specification where title='{$title}'");
	$result=$re->fetch();
	$id=$result['id'];
	$classid=$result['classid'];
	//产品数据分表中字段
	$proDataField = array(
	    "id" => $id,
	    "classid" => $classid,
	    "keyid" =>"",
	    "dokey" => 1,
	    "newstempid" => 13,
	    "closepl" => 0,
	    "haveaddfen" => 0,
	    "infotags" =>"" ,
	    "newstext"=>$content

	    
	);

	$data = $db->insert("phome_ecms_specification_data_1", $proDataField);
	echo "insert phome_ecms_specification_data_1 success".PHP_EOL;
	//产品索引表中字段
	$proIndex = array(
	    "id" => $id,
	    "classid" => $classid,
	    "checked" => 1,
	    "newstime" => $time,
	    "truetime" => $time,
	    "lastdotime" => $time,
	    "havehtml" => 1
	);
	//print_r($proIndex);
	$data = $db->insert("phome_ecms_specification_index", $proIndex);
	echo 'insert into phome_ecms_specification_index success'.PHP_EOL;
	//$filename++;
}
$db->close();

 ?>