<?php 

@header("Content-Type: text/html; charset=UTF-8");
//不限执行时间
set_time_limit(0); 
ini_set('memory_limit', '300M');
error_reporting(0);
//从日志文件中获取url
function get_content($fileName){
	$lineArray=array();
	$fp = fopen($fileName, "rb") or die("Unable to open file ".$fileName);
	$content=fread($fp,filesize($fileName));
	fclose($fp);
	return $content;

}
function get_parameter($uri){
	$content=get_content($uri);
	$proa=explode("####",$content);
	$i=0;
	$parameters=array();
	foreach ($proa as $value) {
		$paraa=explode("\r\n\r\n",$value);
		preg_match('~@(.*)@~', $value,$match);
		preg_replace('~@(.*)@~', "",$value);
		$pro_id=$match[1];
		foreach ($paraa as $value) {
			# code...
			
			$value=preg_replace('~@(.*)@~i',"",$value);
			
			$paralinea=explode("\r\n",$value);
			
			$parameter=array();
			if(!empty($pro_id))
				$parameter[product_id]=$pro_id;
			foreach ($paralinea as $value) {
				$para=explode("##",$value);
				//echo $para[0]."=======".trim($para[1]).PHP_EOL;
				if(!empty($para[0])&&!empty($para[1])){
					$k=trim($para[0]);
					$v=trim($para[1]);
					$parameter[$k]=$v;
				}

			}
			//print_r($parameter);
			$parameters[]=$parameter;
			$i++;

		}
		
	}
	return $parameters;
}

function get_source($uri){
	$title="";
	
	$content="";
	$ps=get_parameter($uri);

	$sources=array();
	foreach ($ps as $key => $value) {

		$title=$value[Model];
		$pro_id=$value[product_id];
		$source=array();
		$content="";
		$i=1;
		foreach ($value as $key => $value) {
			if($i!=1){
			$content.='<div class="weui-form-preview__item  pt10">
			       <label class="weui-form-preview__label">'.$key.'</label>
			       <span class="weui-form-preview__value">'.$value.'</span>
			     </div><div class="border-bottom"></div> ';}
			     $i++;
		}
		$time=time();
		$source[title]=$title;
		$source[content]=$content;
		$source[time]=$time;
		$source[product_id]=$pro_id;
		$sources[]=$source;
	}
	return $sources;
}
$s=get_source("./text/parameter30-40.txt");
// foreach ($s as $key => $value) {
	 
// 	echo $value[title].'==='.urlencode(strtolower(trim($value[title]))).PHP_EOL;
// }
 ?>
