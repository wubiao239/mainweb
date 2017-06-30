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
		$lineArr[]=$line;

	}

	fclose($fp);
	return $lineArr;

}


//根据url获取内容
function getSource($url){
	$title="";
	$time="";
	$content="";
	

	require_once('phpQuery/phpQuery.php');
	$html=phpQuery::newDocumentFile($url);         
	//获取描述内容
	$title=$html->find('.newstitle')->html();
	$time=$html->find('.newstime')->html();
	$time=strtotime($time);
	$content=$html->find('.newscontent')->html();
	

	$search = array(        
	                    "~<span(.*?)>~is",
	                     "~<p (.*?)>~is"
	                                      
	                                );
	                                
	$replace = array(        
	                    "<span>",
	                    "<p>"
	                                       
	                                );                        
	//去除样式，去除后效果不是太好不用处理
	//$content = preg_replace($search,$replace,$content);
	$content=mb_convert_encoding($content, 'utf-8',mb_detect_encoding($content));    

	return array('title'=>$title,'time'=>$time,'content'=>$content);

}





// foreach ($urls as $url) {
// 	$content=getSource($url);
// 	echo $url.PHP_EOL;
// 	print_r($content);
// }

$content=getSource("http://fr.leevii.com/news/204.html");
print_r($content);

 ?>