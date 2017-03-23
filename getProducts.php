<?php 
@header("Content-Type: text/html; charset=UTF-8");
$fileName="prolist.txt";
//获取图片地址和采集页网址
function getImgUrls($fileName){
	$lineArray=array();
	$fp = fopen($fileName, "r") or die("Unable to open file ".$fileName);
	while(! feof($fp))
	{
		$line=fgets($fp);
		$lineArray[]=$line;

	}

	fclose($fp);
	return $lineArray;

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

getImgUrls($fileName);
?>