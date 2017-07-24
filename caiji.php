<?php 

@header("Content-Type: text/html; charset=UTF-8");
//不限执行时间
set_time_limit(0); 
error_reporting(1024);
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


//print_r($urls);

//根据url获取内容
function getSource($url){
	$title="";
	$content="";
	

	require_once('phpQuery/phpQuery.php');
	$html=phpQuery::newDocumentFile($url);         
	//获取描述内容
	$title=$html->find('.news_a h2')->text();
	$content= $html->find(".news_a")->remove();
	
	$content->find('.news_a_t_a')->remove();
	$content->find('.news_a_t')->remove();
	$content->find('a')->remove();
	
	$content->find('#news_next_b')->remove();
	$content->find('#other-news')->remove();

	$content->find('script')->remove();
	$content->find('#ckepop')->remove();

	$content= $content->text();	

	$search = array(        
	                    "~豫弘~is",
	                     "~河南~is",
	                     "~关键字：\|\|~is"
	                                      
	                                );
	                                
	$replace = array(        
	                    "世邦",
	                    "上海",
	                    ""
	                                       
	                                );                        
	
	$content = preg_replace($search,$replace,$content);
	$content=mb_convert_encoding($content, 'utf-8',mb_detect_encoding($content));    
	$title=mb_convert_encoding($title, 'utf-8',mb_detect_encoding($title));
	$title= addslashes($title);
	$title = preg_replace($search,$replace,$title);
	$content=addslashes($content);
	
	return array('title'=>$title,'content'=>$content);

}



function outPut($title,$content,$dir=""){

	if(!empty($dir)){
		if(!file_exists($dir))
			mkdir ($dir,0777) or die("mkdir failed");
			chmod($dir,0777);

	}
	
	if(!empty($dir)){
		$fnTitle=$dir."/".time().".txt";
	}else{
		$fnTitle=time().".txt";
	}
	

	$fp = fopen($fnTitle,'wb') or die("open ".$fnTitle." fail !"); 
	
	@flock($fp ,LOCK_EX );
	fwrite($fp,$title.PHP_EOL) or die('write '.$fnTitle." fail !");
	fwrite($fp,$content) or die('write '.$fnTitle." fail !");
	@flock($fp, LOCK_UN);
	fclose($fp);
	echo "write ".$fnTitle." success"."</br>";
	
			

}

$urls=getUrls('caijiurls.txt');
foreach ($urls as $url) {
	# code...
	$source=getSource($url);
	print_r($source);
	$title=$source['title'];
	$content=$source['content'];
	outPut($title,$content,'./test');
}


//$source=getSource('http://www.ssj.org.cn/news/201272092156.html');

//print_r($source);
 ?>