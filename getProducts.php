<?php 
@header("Content-Type: text/html; charset=UTF-8");
//不限执行时间
set_time_limit(0); 
$fileName="prolist.txt";
//获取图片地址和采集页网址
function getImgUrls($fileName){
	$lineArray=array();
	$fp = fopen($fileName, "r") or die("Unable to open file ".$fileName);
	
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
//根据url获取title，des中的内容，以及content的前两段
function getTitleDes($url){
    $fContent=file_get_contents($url);
    //从网页中采集title和description以及content前两段
    $resultContent=array();
    $resultTitle=array();
    $resultDes=array();
    $regDivCarousel="~<div class=\"carousel-desc mt20\">(.*?)</div>~is";
    $regTitle="~<h1>(.*?)</h1>~is";
    $regDes="~<p>(.*?)</p>~is";
    preg_match($regDivCarousel,$fContent,$resultContent);
    $divCarousel=trim($resultContent[1]);
    if(!empty($resultContent)){
        preg_match($regTitle,$divCarousel,$resultTitle);
        @$title=$resultTitle[1];
        preg_match_all($regDes,$divCarousel,$resultDes);
        foreach ($des=$resultDes[1] as $key => $value) {
           @$des=$value.PHP_EOL;
        }
       
    }else{
        echo "not collected DivCarousel content";

    }

    return array($title,$des,$divCarousel);

}

?>