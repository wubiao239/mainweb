<?php 
@header("Content-Type: text/html; charset=UTF-8");
//不限执行时间
set_time_limit(0); 
//error_reporting(0);
$fileName="caselist.txt";
$domain="http://www.shibangchina.com";
include_once("functions.php");
function main(){
	global $fileName;
	global $domain;
	$allUrl=getImgUrls($fileName);
	
	for ($i=0; $i < count($allUrl); $i++) { 
		$imgSrc=$domain.trim($allUrl[$i][0]);
		$url=trim($allUrl[$i][1]);
		$pName=getProductName($url);
		
		try {
			$source=getCaseSource2($url);
			if(empty($source)){
				throw new Exception("Error Processing Request", 1);
			}
			$bImgArr=$source['imgs'];
			$title=$source['title'];
			$des=$source['des'];
			$content=$source['content'];
			processImg2($pName,$imgSrc,$bImgArr,"material");
			outPutHtml2($pName,$title,$des,$content,"material");
			
			
		} catch (Exception $e) {
			echo 'Message: ' .$e->getMessage();
		}
		
	}
	echo $fileName."download finished";
	// processImg("http://www.shibangchina.com/products/lm_mill.html","http://www.shibangchina.com/images/products/lm/lm_banner.png");
	// outPutHtml("http://www.shibangchina.com/products/lm_mill.html");
	
}


// $source=getCaseSource("http://www.shibangchina.com/case/material/278.html");
// print_r($source);
// print_r($source);
main();
?>