<?php 

@header("Content-Type: text/html; charset=UTF-8");
//不限执行时间
set_time_limit(0); 
error_reporting(0);
//从日志文件中获取url
function getUrls($fileName){
	$lineArray=array();
	$fp = fopen($fileName, "rb") or die("Unable to open file ".$fileName);
	
	while(! feof($fp))
	{
		$line=fgets($fp);
		$line=trim($line);
		echo $line;

	}

	fclose($fp);
	

}
getUrls("test.sql");

 ?>