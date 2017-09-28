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
function get_parameter(){
	$content=get_content("./text/parameter.txt");
$proa=explode("####",$content);
$i=0;
$parameters=array();
foreach ($proa as $value) {
	$paraa=explode("###",$value);
	
	foreach ($paraa as $value) {
		# code...
		$paralinea=explode("\r\n",$value);
		$parameter=array();
		foreach ($paralinea as $value) {
			$para=explode("##",$value);
			
			if(!empty($para[0]))
				
				$parameter[$para[0]]=$para[1];
		}

		//echo "============";
		//$product[]=$parameter;
		$parameters[]=$parameter;
		$i++;

	}
	
}
return $parameters;
}

function get_source(){
	$title="";
	
	$content="";
	$ps=get_parameter();

	$sources=array();
	foreach ($ps as $key => $value) {
		$titel=$value[Model];
		$source=array();
		$content="";
		foreach ($value as $key => $value) {
			$content.='<div class="weui-form-preview__item pb10 pt10">
			       <label class="weui-form-preview__label">'.$key.'</label>
			       <span class="weui-form-preview__value">'.$value.'</span>
			     </div><div class="border-bottom"></div> ';
		}
		$time=time();
		$source[titel]=$titel;
		$source[content]=addslashes($content);
		$source[time]=$time;
		$sources[]=$source;
	}
	return $sources;
}
print_r(get_source());
 ?>}
