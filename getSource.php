<?php 

@header("Content-Type: text/html; charset=UTF-8");
//不限执行时间
set_time_limit(0); 
error_reporting(0);
//从日志文件中获取url
function getUrls($fileName){
	$lineArray=array();
	$fp = fopen($fileName, "rb") or die("Unable to open file ".$fileName);
	
	while(! feof($fp))
	{
		$line=fgets($fp);
		$line=trim($line);
		$lineArr[]=$line;

	}

	fclose($fp);
	return $lineArr;

}


//根据url获取内容
function getSource($url){
	$title="";
	$time="";
	$content="";
	

	require_once('phpQuery/phpQuery.php');
	$html=phpQuery::newDocumentFile($url);         
	//获取描述内容
	$title=$html->find('.newstitle')->html();
	$time=$html->find('.newstime')->html();
	$time=strtotime($time);
	$content=$html->find('.newscontent')->html();
	

	$search = array(        
	                    "~<span(.*?)>~is",
	                     "~<p (.*?)>~is"
	                                      
	                                );
	                                
	$replace = array(        
	                    "<span>",
	                    "<p>"
	                                       
	                                );                        
	//去除样式，去除后效果不是太好不用处理
	//$content = preg_replace($search,$replace,$content);
	$content=mb_convert_encoding($content, 'utf-8',mb_detect_encoding($content));    
	$title=mb_convert_encoding($title, 'utf-8',mb_detect_encoding($title));
	//$title=htmlspecialchars($title);
	$title= addslashes($title);
	//$title=mysql_escape_string ($title);
	$content=addslashes($content);
	//$content=mysql_escape_string ($content);
	//$title=clear($title);
	return array('title'=>$title,'time'=>$time,'content'=>$content);

}


function clear($kw)
{ 
    $kw= str_replace(array("~" ,"!" ,"@" ,"#" ,"$" ,"%" ,"^" ,"+","&" ,"*" ,"," ,"." ,"?" ,";",":" ,'\'','"' ,"[" ,"]" ,"{" ,"}" ,"!" ,"￥" ,"……" ,"…" ,"、" ,"，" ,"。" ,"？" ,"；" ,"：","'","“" ,"”" ,"'" ,"【" ,"】" ,"～" ,"！" ,"＠" ,"＃" ,"＄" ,"％" ,"＾" ,"＆" ,"＊" ,"，" ,"．" ,"＜" ,"＞" ,"；" ,"：","＇","＂" ,"［" ,"］" ,"｛" ,"｝","／" ,"＼" ,"（" ,"）" ,"(" ,")","《","》", '$','¿','×'),'', $kw ); 
		
    $kw= str_replace( array("  ","-","_","\\","/","|"),' ', $kw ); 
	
    //$kw= str_replace(array("á","í","é","ó","ú","ñ","Á","Í","É","Ó","Ú","Ñ","ç","ã","à","â","ê","ô","õ","ü"),array("a","i","e","o","u","n","a","i","e","o","u","n","c","a","a","a","e","o","o","u"),$kw);
	
    //$kw= str_replace(array("а","б","в","г","д","е","ё","ж","з","и","й","к","л","м","н","о","п","р","с","т","у","ф","х","ц","ч","ш","я","ю","щ","щ","э","ъ","ь","А","Б","В","Г","Д","Е","Ё","Э","Ж","З","И","Й","К","Л","М","Н","О","П","Р","С","Т","У","Ф","Х","Ц","Ч","Ш","Щ","Ы","Ю","Я","ы"),array("a","b","v","g","d","e","e","zh","z","i","j","k","l","m","n","o","p","r","s","t","u","f","x","c","ch","s","ya","yu","sch","y","e","","","A","B","V","G","D","E","E","E","J","Z","I","I","K","L","M","N","O","P","R","S","T","U","F","H","C","CH","SH","SH","Y","YU","YA","s"),$kw);
    
	//$kw = strtolower(strip_tags(trim($kw)));    
	
	//$kw = explode(' ',$kw);
	
	//$kw = implode('-',array_filter($kw));
	
	return $kw;
} 


// foreach ($urls as $url) {
// 	$content=getSource($url);
// 	echo $url.PHP_EOL;
// 	print_r($content);
// }

//$content=getSource("http://fr.leevii.com/news/204.html");
//print_r($content);

 ?>