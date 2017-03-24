<?php 
@header("Content-Type: text/html; charset=UTF-8");
//不限执行时间
set_time_limit(0); 
error_reporting(0);
$fileName="prolist.txt";
$domain="http://www.shibangchina.com";
//从txt中获取图片地址和采集页网址
function getImgUrls($fileName){
	$lineArray=array();
	$fp = fopen($fileName, "rb") or die("Unable to open file ".$fileName);
	
	while(! feof($fp))
	{
		$line=fgets($fp);
		$arr = explode("	", $line); 
		$arr = array_filter($arr);

		$lineArr[]=$arr;

	}

	fclose($fp);
	return $lineArr;

}

//将png图片转换为白底的jpg图片
function pngToJpg($srcPathName, $delOri=true)  
{  
	$srcFile=$srcPathName;  
	$srcFileExt=strtolower(trim(substr(strrchr($srcFile,'.'),1)));  
	if($srcFileExt=='png')  
	{  
		$dstFile = str_replace('.png', '.jpg', $srcPathName);  
		$photoSize = GetImageSize($srcFile);  
		$pw = $photoSize[0];  
		$ph = $photoSize[1];  
		$dstImage = ImageCreateTrueColor($pw, $ph);  
		$white=imagecolorallocate($dstImage, 255, 255, 255);
		imagefill($dstImage, 0, 0, $white);  
        //读取图片  
		$srcImage = ImageCreateFromPNG($srcFile);  
        //合拼图片  
		imagecopyresampled($dstImage, $srcImage, 0, 0, 0, 0, $pw, $ph, $pw, $ph);  
		imagejpeg($dstImage, $dstFile, 90);  
		if ($delOri)  
		{  
			unlink($srcFile);  
		}  
		imagedestroy($srcImage);  
	}  
}  
//根据url获取产品名称
function getProductName($url){
	$str=$url;
	$file=substr($str,strripos($str, "/")+1);
	$proName=substr($file,0,strripos($file, "."));
	return $proName;

}
//根据url下载图片
function downImg($url, $saveName)
{
	$in= fopen($url, "rb");
	if(file_exists($saveName)){
		unlink($saveName);
	}
	$out=   fopen($saveName, "wb");
	while ($chunk = fread($in,8192))
	{
		fwrite($out, $chunk, 8192);
	}
	fclose($in);
	fclose($out);
}
//获取网页中的banner标题描述和图片
function getTitleDesImg($url){
	$fContent=file_get_contents($url);
    //从网页中采集title和description和对应图片以及content前两段
	$resultContent=array();
	$resultTitle=array();
	$resultDes=array();
	$imgSrc=array();
	$regDivCarousel="~<div class=\"carousel-desc mt20\">(.*?)</section>~is";
	$regTitle="~<h1>(.*?)</h1>~is";
	$regDes="~<p>(.*?)</p>~is";
	$regTitleDes="~<div class=\"carousel-desc mt20\">(.*?)</div>~is";
	$regImgBox="<div class=\"imgbox\">(.*?)</div>~is";
	$regImgSrc="~<img.*?src=\"(.*?)\".*?>~is"; 

	preg_match($regDivCarousel,$fContent,$resultContent);

	@$divCarousel=trim($resultContent[0]);
	if(!empty($divCarousel)){
		preg_match($regTitle,$divCarousel,$resultTitle);
		@$title=$resultTitle[1];

		preg_match($regTitleDes,$divCarousel,$resultTitleDes);
		@$titleDes=$resultTitleDes[1];

		preg_match_all($regImgSrc,$divCarousel,$resultImgSrc);

		foreach ($resultImgSrc[1] as $key => $value) {

			@$imgSrc[]=$value;
		}

		preg_match_all($regDes,$divCarousel,$resultDes);

		foreach ($resultDes[1] as $key => $value) {
			@$des=$value.PHP_EOL;
		}

	}else{
		echo "not collected DivCarousel content";

	}

	return array("title"=>$title,"des"=>$des,"titleDes"=>$titleDes,"img"=>$imgSrc);

}
//根据url获取content页面的后半段内容以及对应的图片
function getContentImg($url){

	$fContent=file_get_contents($url);
    //从网页中采集title和description以及content前两段
	$resultContent=array();
	$resultTitle=array();
	$resultDes=array();
	$regPro="~<div class=\"pro-detail clearfix\">(.*?)</section>~is";
	$regH="~<h\d>(.*?)</h\d>~is";
	$regP="~<p>(.*?)</p>~is";
	$regImgSrc="~<img.*?src=\"(.*?)\".*?>~is";
	preg_match_all($regPro,$fContent,$resultContent);
	@$ProArr=$resultContent[0];
	if(!empty($resultContent)){
		foreach ($ProArr as $key => $value) {
			$pro=trim($value);
			preg_match($regH,$pro,$resultH);
			@$H[]=$resultH[0];
			preg_match($regImgSrc,$pro,$resultImgSrc);
			@$imgSrc[]=$resultImgSrc[1];
			preg_match_all($regP,$pro,$resultP);
			foreach ($resultP[0] as $key => $value) {
				@$p[]=$value;
			}
		}


	}else{
		echo "not collected Pro content";

	}

	return array("h"=>$H,"p"=>$p,"img"=>$imgSrc);

}


function outPutHtml($url){
	
	$content="";

	$pName=getProductName($url);

	if (!file_exists($pName)){
		mkdir ($pName,0777);
		 
		echo 'create '.$pName.' success.';
	}
	$fhContent=getTitleDesImg($url);
	$shContent=getContentImg($url);
	$title=$fhContent['title'];
	$des=$fhContent['des'];
	$titleDes=$fhContent['titleDes'];
	$fhImg=$fhContent['img'];
	$shImg=$shContent['img'];

	$fnTitle=$pName."/"."title.html";
	$fnDes=$pName."/"."des.html";
	$fnContent=$pName."/"."content.html";
	//拼接content内容
	$content.=trim($titleDes).PHP_EOL.PHP_EOL;
	$i=1;
	foreach ($fhImg as $key => $value) {
		$content.="<p><img src=\"/images/{$pName}/{$pName}-{$i}.jpg\" alt=\"{$pName}-{$i}\" /></p>".PHP_EOL;
		$i++;
	}
	$count=count($shContent['h']);

	for ($j=0;$j<$count;$j++ ) {
		$h=$shContent['h'][$j];
		$h1 = preg_replace("~h\d~is", "h1", $h).PHP_EOL;
		$p=$shContent['p'][$j].PHP_EOL;
		$img="<p><img src=\"/images/{$pName}/{$pName}-{$i}.jpg\" alt=\"{$pName}-{$i}\" /></p>".PHP_EOL;
		$content.=$h1;
		$content.=$p;
		$content.=$img;

		$i++;
	}
	
	//写入title到title.html
	@chmod($pName, 0666 ) ;
	$fp = fopen($fnTitle,'wb') or die("open ".$fnTitle." fail !"); 
	
	@flock($fp ,LOCK_EX );
	fwrite($fp,$title) or die('write '.$fnTitle." fail !");
	@flock($fp, LOCK_UN);
	fclose($fp);
	echo "write ".$fnTitle." success"."</br>";
	
	////写入des到des.html
	@chmod($pName, 0666 ) ;
	$fp = fopen($fnDes,'wb') or die("open ".$fnDes." fail !"); 
	@flock($fp ,LOCK_EX );
	fwrite($fp,$des) or die('write '.$fnDes." fail !");
	@flock($fp, LOCK_UN);
	fclose($fp);
	echo "write ".$fnDes." success"."</br>";

	//写入content到content.html

	@chmod($pName, 0666 ) ;
	$fp = fopen($fnContent,'wb') or die("open ".$fnContent." fail !"); 
	@flock($fp ,LOCK_EX );
	fwrite($fp,$content) or die('write '.$fnContent." fail !");
	@flock($fp, LOCK_UN);
	fclose($fp);
	echo "write ".$fnContent." success"."</br>";


}

function processImg($url,$imgSrc){

	global $domain;
	$pName=getProductName($url);

	if (!file_exists($pName)){
		mkdir ($pName,0777);
		 
		echo 'create '.$pName.' success.';
	} else {
		echo $pName.' exists';
	}

	$fhContent=getTitleDesImg($url);
	$shContent=getContentImg($url);
	$extension=substr(strrchr($imgSrc, '.'), 1);
	$saveName=$pName."/".$pName.".".$extension;
	downImg($imgSrc,$saveName);
	if($extension="png"){
		pngToJpg($saveName,true);
	}
	echo "download and pngTojpg ".$saveName." finished"."</br>";
	$allImg=array_merge_recursive($fhContent['img'],$shContent['img']);
	$i=1;
	foreach ($allImg as $key => $value) {
		$allImgSrc=$domain.$value;
		$extension=substr(strrchr($value, '.'), 1);
		$saveName=$pName."/".$pName."-".$i.".".$extension;
		downImg($allImgSrc,$saveName);
		if($extension="png"){
			pngToJpg($saveName,true);
		}
		echo "download and pngTojpg ".$saveName." finished"."</br>";
		$i++;
	}

}
function main(){
	global $fileName;
	$allUrl=getImgUrls($fileName);
	print_r($allUrl);
	for ($i=0; $i < count($allUrl); $i++) { 
		$imgSrc=trim($allUrl[$i][0]);
		$url=trim($allUrl[$i][1]);
		
		processImg($url,$imgSrc);
		outPutHtml($url);
	}
	// processImg("http://www.shibangchina.com/products/lm_mill.html","http://www.shibangchina.com/images/products/lm/lm_banner.png");
	// outPutHtml("http://www.shibangchina.com/products/lm_mill.html");
	
}

main();
?>