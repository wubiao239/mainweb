<?php 
@header("Content-Type: text/html; charset=UTF-8");
//不限执行时间
set_time_limit(0); 
//error_reporting(0);
$fileName="prolist.txt";
$domain="http://www.shibangchina.com";
include_once("functions.php");
function main(){
	global $fileName;
	$allUrl=getImgUrls($fileName);
	
	for ($i=0; $i < count($allUrl); $i++) { 
		$imgSrc=trim($allUrl[$i][0]);
		$url=trim($allUrl[$i][1]);
		$pName=getProductName($url);
		
		try {
			$source=getProSource($url);
			if(empty($source)){
				throw new Exception("Error Processing Request", 1);
			}
			$bImgArr=$source['imgs'];
			$title=$source['title'];
			$des=$source['des'];
			$content=$source['content'];
			processImg2($pName,$imgSrc,$bImgArr);
			outPutHtml2($pName,$title,$des,$content);

			
			
		} catch (Exception $e) {
			echo 'Message: ' .$e->getMessage();
		}
		
	}
	echo $fileName." Acquisition is complete.";
	// processImg("http://www.shibangchina.com/products/lm_mill.html","http://www.shibangchina.com/images/products/lm/lm_banner.png");
	// outPutHtml("http://www.shibangchina.com/products/lm_mill.html");
	
}


// $source=getSource("http://www.shibangchina.com/products/mb5x.html");
// print_r($source);
main();
?>