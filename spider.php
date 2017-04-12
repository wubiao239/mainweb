<?php 
@header("Content-Type: text/html; charset=UTF-8");
//不限执行时间
set_time_limit(0); 
error_reporting(0);
//根据url获取产品名称
require_once('phpQuery/phpQuery.php');
//获取单页上所有链接
function getSingleLinks($url){
	$parseUrl=parse_url($url);
	//print_r($parseUrl);
	$scheme=$parseUrl['scheme'];
	$host=$parseUrl['host'];
	$path=$parseUrl['path'];
	$html=phpQuery::newDocumentFile($url);         
	//获取描述内容
	$links=$html->find("a");
	foreach($links as $element){
		$element=pq($element);
		$href=$element->attr('href');
		$hrefs[]=$href;
		//$text=$element->text();
		//echo $text.PHP_EOL;
	}
	//去掉上面的重复连接
	$hrefs=array_unique($hrefs);
	return $hrefs;
}

function getSiteLinks($url,$depth=1) 
{ 
	if(!isset($started)){ 
		$started=1; 
		$currDepth=0; 
	}else{ 
		$currDepth++; 
	} 
	if($currDepth<$depth) 
	{ 
		$singleLinks=getSingleLinks($url); 
		
		if(count($singleLinks)) 
		{ 
			print_r($singleLinks);
			foreach($singleLinks as $v){
				echo $v;
				$a="http://www.mincomining.pw".$v;
				//echo $a;
				$check=get_headers($a,1); 
				if($check[0]=='HTTP/1.1 200 OK' && !array_search($a,$urls) && $currDepth<$depth){ 
					$urls[]=$a; 
					getSiteLinks($a); 
				} 
			} 
		} 
	} 
	return $urls; 
} 

$hrefs=getSiteLinks("http://www.mincomining.pw/");
//print_r($hrefs);

?>