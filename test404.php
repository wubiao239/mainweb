<?php 
set_time_limit(0);
//从txt中获取图片地址和采集页网址
function getUrls($fileName){
	$lineArray=array();
	$fp = fopen($fileName, "r") or die("Unable to open file ".$fileName);
	
	while(! feof($fp)){
		$line=fgets($fp);
		$lineArr[]=trim($line);

	}

	fclose($fp);
	return $lineArr;

}
function getStatus($url){


	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_exec($ch);  // $resp = curl_exec($ch);
	$curl_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	return $curl_code;

	
}

$urls=getUrls('urls.txt');
$fp=fopen("200urls.txt", "a+");
foreach ($urls as $url) {
	
	//$headers = get_headers($url); 
	$curl_code=getStatus($url); 
	if ($curl_code == 200 || $curl_code == 302|| $curl_code == 301) {
	    echo $url."-------->{$curl_code}".PHP_EOL."</br>";
		fwrite($fp, $url.PHP_EOL);
	} else {
	    echo $url.'-------->不能正常访问'.PHP_EOL."</br>";
	}
	
}

fclose($fp);


 ?>