<?php 
@header("Content-Type: text/html; charset=UTF-8");
//不限执行时间
set_time_limit(0); 
$fileName="prolist.txt";
//从txt中获取图片地址和采集页网址
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

    $divCarousel=trim($resultContent[0]);
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
    $ProArr=$resultContent[0];
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


function outPutHtml($url,$imgSrc){
    $fnTitle="title.html";
    $fnDes="des.html";
    $fnContent="content.html";

    $pName=getProductName($url);
    
    if (!file_exists($pName)){
        mkdir ($pName); 
        echo 'create '.$pName.' success.';
    } else {
        echo $pName.' exists';
    }

    
    // if(file_exists($fnTitle))
    // {

    // }

    // ob_start(); 

    // $temp = ob_get_contents(); 
    // ob_end_clean(); 
    // //写入文件 
    // $fp = fopen(‘xxx.html','w'); 
    // fwrite($fp,$temp) or die(‘写文件错误'); 
}

outPutHtml("http://www.shibangchina.com/products/mtm_mill.html","http://www.shibangchina.com/images/products/mtm/1.png");
?>