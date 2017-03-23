<?php 
function png2jpg($srcPathName, $delOri=true)  
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

png2jpg("b6x_banner1.png",false);

 ?>