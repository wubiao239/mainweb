<?php
// @header("Content-Type: text/html; charset=UTF-8");
// error_reporting(0);
//通用方法
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
	if($in){
		if(file_exists($saveName)){
			unlink($saveName);
		}
		$out= fopen($saveName, "wb");
		while ($chunk = fread($in,8192))
		{
			fwrite($out, $chunk, 8192);
		}
		fclose($in);
		fclose($out);

	}else{
		echo "download ".$url." falil".'</br>'.PHP_EOL;
	}
	
}


//获取网页中的banner标题描述和图片
//舍弃的方法getSource()优化效果更好
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
		return array("title"=>$title,"des"=>$des,"titleDes"=>$titleDes,"img"=>$imgSrc);	

	}else{
		echo "not collected DivCarousel content";
		return false;

	}

	

}
//根据url获取content页面的后半段内容以及对应的图片
//舍弃的方法getSource()优化效果更好
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
		return array("h"=>$H,"p"=>$p,"img"=>$imgSrc);

	}else{
		echo "not collected Pro content";
		return false;

	}

	

}

//舍弃方法outputhtml2()处理效果更好
function outPutHtml($url){
	
	$content="";

	$pName=getProductName($url);

	if (!file_exists($pName)){
		mkdir ($pName,0777);

		echo 'create '.$pName.' success.';
	}
	try{

		$fhContent=getTitleDesImg($url);
		$shContent=getContentImg($url);
		if($shContent){
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
		


		throw new Exception("Error Processing Request", 1);
		
		
	} catch (Exception $e) {
		echo "url=".$url."can not collection title  and des and imgs"."</br>";
		return false;
	}
	
	


}
//处理通过$url获取case中的内容
// 舍弃方法getCaseSource2 通用性更强
function getCaseSource($url){
	$title="";
	$des="";
	$content="";
	$realImgSrc=array();
	$pName=getProductName($url);

	require_once('phpQuery/phpQuery.php');
	$html=phpQuery::newDocumentFile($url);         
	//获取描述内容
	$h1=$html->find('.kuangshan_ks_banner_text h1');
	foreach($h1 as $element){
		$element=pq($element);
		$title=$h1->text();
		$content.='<h1>'.mb_convert_encoding($h1->html(), 'utf-8',mb_detect_encoding($h1->html())) .'</h1>'.PHP_EOL;
	}
	
	//获取描述内容
	$p=$html->find('.kuangshan_ks_banner_text p');
	
	foreach($p as $element){
		$element=pq($element);
		$des.=$element->text(); 
		$content.='<p>'.mb_convert_encoding($element->html(), 'utf-8',mb_detect_encoding($element->html())).'</p>' .PHP_EOL;
	}

	//获取前半部分图片
	$imgs=$html->find('.kuangshan_ks_banner_text img');
	$i=1;
	foreach($imgs as $element) {
		$element=pq($element);
		$content.="<p><img src=\"/images/{$pName}/{$pName}-{$i}.jpg\" alt=\"{$pName}-{$i}\" /></p>".PHP_EOL;
		$realImgSrc[]=$element->attr('src'); 
		$i++;
	}

	//获取后半部分的内容和图片	
	$newCaseContent=$html->find('#new_case_content > div');

	foreach($newCaseContent as $element) {
		$sHtml=pq($element);
		//排除客户现场
		if(!$sHtml->hasClass('customer_site')){
			$h=$sHtml->find('h2');
			foreach($h as $elem) {
				$elem=pq($elem);
				$content.= '<h1>'.$elem->text() .'</h1>'.PHP_EOL;
			}

			$p=$sHtml->find('p');
			foreach($p as $elem) {
				$elem=pq($elem);
				$content.= '<p>'.$elem->text().'</p>'.PHP_EOL; 
			}
			$img=$sHtml->find('img');
			foreach($img as $elem) {
				$elem=pq($elem);
				$content.="<p><img src=\"/images/{$pName}/{$pName}-{$i}.jpg\" alt=\"{$pName}-{$i}\" /></p>".PHP_EOL;
				$realImgSrc[]=$elem->attr('src');
				$i++;

			}

		}
		



	}

	return array('title'=>$title,'des'=>$des,'content'=>$content,'imgs'=>$realImgSrc);

}


//处理通过$url获取case中的内容
function getCaseSource2($url){
	$title="";
	$des="";
	$content="";
	$realImgSrc=array();
	$pName=getProductName($url);

	require_once('phpQuery/phpQuery.php');
	$html=phpQuery::newDocumentFile($url);         
	//获取描述内容
	$h1=$html->find('.kuangshan_ks_banner_text h1');
	foreach($h1 as $element){
		$element=pq($element);
		$title=$h1->text();
		$content.='<h1>'.mb_convert_encoding($h1->html(), 'utf-8',mb_detect_encoding($h1->html())) .'</h1>'.PHP_EOL;
	}
	
	//获取描述内容
	$p=$html->find('.kuangshan_ks_banner_text p');
	
	foreach($p as $element){
		$element=pq($element);
		$des.=$element->html(); 
		$content.='<p>'.mb_convert_encoding($element->html(), 'utf-8',mb_detect_encoding($element->html())).'</p>' .PHP_EOL;
	}
	$content.=PHP_EOL;
	//获取前半部分图片
	$imgs=$html->find('.kuangshan_ks_banner_text img');
	$i=1;
	foreach($imgs as $element) {
		$element=pq($element);
		$content.="<p><img src=\"/images/{$pName}/{$pName}-{$i}.jpg\" alt=\"{$pName}-{$i}\" /></p>".PHP_EOL;
		$realImgSrc[]=$element->attr('src'); 
		$i++;
	}

	
	//获取后半部分的内容和图片
	//获取后半部分的内容和图片	
	$newCaseContent=$html->find('#new_case_content > div');

	$caseContent=$html->find('#content>div');
	if(count($caseContent)){
		//echo count($contentElement);
		$j=1;
		foreach($caseContent as $element) {

			$sHtml=pq($element);

			switch ($j) {
				case '1':
				$img=$sHtml->find('img');
				if(count($img)){
					foreach($img as $elem) {
						$elem=pq($elem);
							//$content.="<p><img src=\"/images/{$pName}/{$pName}-{$i}.jpg\" alt=\"{$pName}-{$i}\" /></p>".PHP_EOL;
						$realImgSrc[]=str_replace("../../", "/", $elem->attr('src'));
						$i++;

					}
				}
				break;
				
				case '2':
				$h=$sHtml->find('h3');
				if(count($h)){
					foreach($h as $elem) {
						$elem=pq($elem);
						$content.= '<h1>'.$elem->text() .'</h1>'.PHP_EOL;
					}
				}
				$p=$sHtml->find('p');
				if(count($p)){
					foreach($p as $elem) {
						$elem=pq($elem);
						if($elem->text()!=" ")
						$content.= '<p>'.$elem->text().'</p>'.PHP_EOL; 
					}
				}
				break;

				case '3':
				$h=$sHtml->find('h3');
				if(count($h)){
					foreach($h as $elem) {
						$elem=pq($elem);
						$content.= '<h1>'.$elem->text() .'</h1>'.PHP_EOL;
					}

				}


				$p=$sHtml->find('p');
				if(count($p)){
					foreach($p as $elem) {
						$elem=pq($elem);
						$content.= '<p>'.$elem->text().'</p>'.PHP_EOL; 
					}
				}

				$img=$sHtml->find('img');
				if(count($img)){
					foreach($img as $elem) {
						$elem=pq($elem);
						$content.="<p><img src=\"/images/{$pName}/{$pName}-{$i}.jpg\" alt=\"{$pName}-{$i}\" /></p>".PHP_EOL;
						$realImgSrc[]=str_replace("../../", "/", $elem->attr('src'));
						$i++;

					}
				}

				break;

				
			}
			$j++;
			


		}

	}
	else if(count($newCaseContent)){


		foreach($newCaseContent as $element) {
			$sHtml=pq($element);
			//排斥客户现场related_case
			if($sHtml->hasClass('customer_site')){
				$img=$sHtml->find('img');
				if(count($img)){
					foreach($img as $elem) {
						$elem=pq($elem);
						//$content.="<p><img src=\"/images/{$pName}/{$pName}-{$i}.jpg\" alt=\"{$pName}-{$i}\" /></p>".PHP_EOL;
						$realImgSrc[]=$elem->attr('src');
						$i++;

					}

				}
				continue;
			}
			if($sHtml->hasClass('related_case')){
				continue;
			}
			$h2=$sHtml->find('h2');
			foreach($h2 as $elem) {
				$elem=pq($elem);
				$content.= '<h1>'.$elem->text() .'</h1>'.PHP_EOL;
			}

			$h3=$sHtml->find('h3');
			if(count($h3)){
				foreach($h3 as $elem) {
					$elem=pq($elem);
					$content.= '<p>'.$elem->text().'</p>'.PHP_EOL; 
				}
			}

			$p=$sHtml->find('p');
			if(count($p)){
				foreach($p as $elem) {
					$elem=pq($elem);
					$content.= '<p>'.$elem->text().'</p>'.PHP_EOL; 
				}
			}
			
			$img=$sHtml->find('img');
			if(count($img)){
				foreach($img as $elem) {
					$elem=pq($elem);
					$content.="<p><img src=\"/images/{$pName}/{$pName}-{$i}.jpg\" alt=\"{$pName}-{$i}\" /></p>".PHP_EOL;
					$realImgSrc[]=$elem->attr('src');
					$i++;

				}

			}



		}

	}
	

	return array('title'=>$title,'des'=>$des,'content'=>$content,'imgs'=>$realImgSrc);

}
//输出文件内容到title.html,des.html,content.html
function outPutHtml2($pName,$title,$des,$content,$dir=""){
	
	if(!empty($dir)){
		$dirPName=$dir."/".$pName;
		mkdir ($dir,0777);
		mkdir ($dirPName,0777);
		$pName=$dirPName;

	}else{
		if (!file_exists($pName)){
			mkdir ($pName,0777);

			echo 'create '.$pName.' success.';
		} else {
			echo $pName.' exists';
		}

	}

	try{

		
		if($pName){
			

			$fnTitle=$pName."/"."title.html";
			$fnDes=$pName."/"."des.html";
			$fnContent=$pName."/"."content.html";
			
			
			
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
		


		throw new Exception("Error Processing Request", 1);
		
		
	} catch (Exception $e) {
		
		return false;
	}
	
	


}
//优化过的图片处理方法
function processImg2($pName,$imgSrc,$bImgArr,$dir=""){

	global $domain;
	if(!empty($dir)){
		$dirPName=$dir."/".$pName;
		mkdir ($dir,0777);
		mkdir ($dirPName,0777);

	}else{
		$dirPName=$pName;
		if (!file_exists($pName)){
			mkdir ($pName,0777);
			
			echo 'create '.$pName.' success.';
		} else {
			echo $pName.' exists';
		}

	}

	
	try {
		
		if($imgSrc){
			$extension=substr(strrchr($imgSrc, '.'), 1);
			$saveName=$dirPName."/".$pName.".".$extension;
			downImg($imgSrc,$saveName);
			if($extension="png"){
				pngToJpg($saveName,true);
			}
			echo "download and pngTojpg ".$saveName." finished"."</br>";
			$allImg=$bImgArr;
			$i=1;
			foreach ($allImg as $key => $value) {
				$value=trim($value);

				//echo $value;
				if(stripos($value,"static.shibangchina.com")){
					
					$allImgSrc=$value;
					
				}else{
					$allImgSrc=$domain.$value;
				}
				
				$extension=substr(strrchr($value, '.'), 1);
				$saveName=$dirPName."/".$pName."-".$i.".".$extension;
				
				downImg($allImgSrc,$saveName);
				if($extension="png"){
					pngToJpg($saveName,true);
				}
				echo "download and pngTojpg ".$saveName." finished"."</br>";
				$i++;
			}

		}
		
		throw new Exception("Error Processing Request", 1);
		
		
	} catch (Exception $e) {
		
		return false;
	}
	

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
	try {
		$fhContent=getTitleDesImg($url);
		$shContent=getContentImg($url);
		if($fhContent){
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
		
		throw new Exception("Error Processing Request", 1);
		
		
	} catch (Exception $e) {
		echo "url=".$url."can not collection img and contents"."</br>";
		return false;
	}
	

}




function getProSource($url){
	$title="";
	$des="";
	$content="";
	$realImgSrc=array();
	$pName=getProductName($url);

	include_once('simple_html_dom.php'); 
	// 新建一个Dom实例
	$html = new simple_html_dom();
	// 从url中加载
	$html->load_file($url);



	$h1=$html->find('#pro-slide h1');

	foreach($h1 as $element) {
		$title.=$element->plaintext;
		$content.=mb_convert_encoding($element->outertext, 'utf-8',mb_detect_encoding($element->outertext)) .PHP_EOL;
	}


	$p=$html->find('#pro-slide p');

	foreach($p as $element){
		$des.=$element->plaintext; 
		$content.=mb_convert_encoding($element->outertext, 'utf-8',mb_detect_encoding($element->outertext)) .PHP_EOL;
	}
	$content.=PHP_EOL;	

	$imgs=$html->find('#pro-slide img');
	$i=1;
	foreach($imgs as $element) {
		
		$content.="<p><img src=\"/images/{$pName}/{$pName}-{$i}.jpg\" alt=\"{$pName}-{$i}\" /></p>".PHP_EOL;
		$realImgSrc[]=$element->src; 
		$i++;
	}


	$proDetail=$html->find('.pro-detail');


	foreach($proDetail as $element) {

		

		$strProDetail=mb_convert_encoding($element->outertext, 'utf-8',mb_detect_encoding($element->outertext));
		//echo $strProDetail;
		$sHtml=str_get_html($strProDetail);
		$h=$sHtml->find('h1');
		foreach($h as $elem) 
			$content.= $elem->outertext .PHP_EOL;
		$p=$sHtml->find('p');
		foreach($p as $elem) 
			$content.= $elem->outertext .PHP_EOL; 
		$img=$sHtml->find('img');
		foreach($img as $elem) {
			$content.="<p><img src=\"/images/{$pName}/{$pName}-{$i}.jpg\" alt=\"{$pName}-{$i}\" /></p>".PHP_EOL;
			$realImgSrc[]=$elem->src;
			$i++;

		}



	}

	return array('title'=>$title,'des'=>$des,'content'=>$content,'imgs'=>$realImgSrc);

}



?>