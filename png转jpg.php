<?php
/*
$saveDir   保存地址
$file      png图片地址

*/


  function imageToJpg($saveDir,$file){
		$saveDir = str_replace ( "\\", "/", $saveDir );
		$srcFile=$saveDir.$file;
		$srcFileExt= strtolower ( trim ( substr ( strrchr ( $srcFile, '.' ), 1 ) ) );
		if($srcFileExt=='jpeg'||$srcFileExt=='jpg'){
			return $saveDir.$file;
		}
		$srcFileName = basename ( $file ,'.'.$srcFileExt);
		$dstFile = $saveDir.$srcFileName.".jpg";
		$photoSize   = GetImageSize($srcFile);
		$pw  = $photoSize[0];
		$ph  = $photoSize[1];
		$srcImage = true;
		if ( stripos( strtolower($srcFile),".gif") ){
			//创建图片
			$dstImage = ImageCreateTrueColor( $pw, $ph);
			imagecolorallocate($dstImage, 255, 255, 255);
			//读取图片
			$srcImage  = ImageCreateFromGif($srcFile);
			//合拼图片
			imagecopyresampled($dstImage,$srcImage ,0,0,0,0,$pw,$ph ,$pw,$ph);
			//ImageCopyResized($dstImage,$srcImage,0,0,0,0,$pw,$ph,$pw,$ph);
			ImageJpeg($dstImage,$dstFile);
			imagedestroy($srcImage );
		}
		if (  stripos( strtolower($srcFile),".png") ){
			//创建图片
			$dstImage = ImageCreateTrueColor( $pw, $ph);
			imagecolorallocate($dstImage, 255, 255, 255);
			//读取图片
			$srcImage  = ImageCreateFromPNG($srcFile);
			//合拼图片
			imagecopyresampled($dstImage,$srcImage ,0,0,0,0,$pw,$ph ,$pw,$ph);
			ImageJpeg($dstImage,$dstFile);
			imagedestroy($srcImage );
		}
		/*if ( $srcImage == false  ||  stripos( strtolower($srcFile),".jpg") ){
		 $srcImage = ImageCreateFromJPEG($srcFile);
		}*/
		if(is_file($srcFile)){
			@unlink($srcFile);
		}
		return $saveDir.$srcFileName.".jpg";
	}






?>