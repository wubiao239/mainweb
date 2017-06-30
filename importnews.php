<?php 

include_once ('MysqlDB.class.php');
include_once("getSource.php");
$db = MysqlDB::getInstance('127.0.0.1', 'multilang.sbmchina.com', 'root','shibang416');

//$data = $db->fetch("phome_ecms_news_index"," WHERE id =655");

//$data=$query->fetchAll();
//print_r($data);


$urls=getUrls("urls/ar_url.log");
//
$filename=298;
foreach ($urls as $url) {

	$source=getSource($url);
	$title = $source['title'];
	$time = $source['time'];
	$content = $source['content'];
	//产品数据表中字段
	$newsfield = array(
	    "classid" => 88,
	    "ttid" => 0,
	    "onclick" => 0,
	    "plnum" => 0,
	    "totaldown" => 0,
	    "newspath" => "",
	    "filename" => $filename,
	    "userid" => 1,
	    "username" =>"超管",
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
	    "titleurl" => "http://ar.sbmchina.com/media/news/{$filename}.html",
	    "stb" => 1,
	    "fstb" => 1,
	    "restb" => 1,
	    "keyboard" => "",
	    "title" => $title,
	    "newstime" => $time,
	    "titlepic" => "",
	    "ftitle" => "",
	    "smalltext" => $title,
	    "diggtop" => 0,
	    "relatedmachine" => "",
	    "relatedinfo" => "",
	    "classname"=>"",
	    "tags"=>""
	);
	$data = $db->insert("phome_ecms_news", $newsfield);
	echo "insert phome_ecms_news success".PHP_EOL;
	$re = $db->query("select * from phome_ecms_news where title='{$title}'");
	$result=$re->fetch();
	$id=$result['id'];
	$classid=$result['classid'];
	//产品数据分表中字段
	$proDataField = array(
	    "id" => $id,
	    "classid" => $classid,
	    "keyid" =>"",
	    "dokey" => 1,
	    "newstempid" => 0,
	    "closepl" => 0,
	    "haveaddfen" => 0,
	    "infotags" =>"" ,
	    "writer" =>"",
	    "befrom"=>"",
	    "newstext"=>$content

	    
	);

	$data = $db->insert("phome_ecms_news_data_1", $proDataField);
	echo "insert phome_ecms_news_data_1 success".PHP_EOL;
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
	$data = $db->insert("phome_ecms_news_index", $proIndex);
	echo 'insert into phome_ecms_news_index success'.PHP_EOL;
	$filename++;
}
$db->close();

 ?>