<?php
#PAC轮询脚本
$iprules="/((?:(?:25[0-5]|2[0-4]\d|((1\d{2})|([1-9]?\d)))\.){3}(?:25[0-5]|2[0-4]\d|((1\d{2})|([1-9]?\d))))/i";
$proxys=array("http://172.16.4.182:7070","http://172.16.3.20:808","http://172.16.2.191:6666");
$pacloc='D:\xampp\htdocs\pac';
$txtloc='C:\Users\Administrator\Desktop\pac.txt';
while(true){
	$pacorder=0;
	$order = 0;
	$timeArr=array();
	foreach($proxys as $k=>$v){
		$begin=getCurrentTime();
		$ip=curl_get_contents($v);
		if(preg_match($iprules,$ip) && $ip!="116.247.96.94"){
			switch($k){
				case 0:
					$pacorder=$pacorder+1;
				break;
				case 1:
					$pacorder=$pacorder+2;
				break;
				case 2:
					$order = 3;
					$pacorder=$pacorder+3;
				break;
			}
		}
		$end=getCurrentTime();
		$timeArr[$k]=$end-$begin;
	}
	echo "{$pacorder}\n";
	switch($pacorder){
		case 0:
		break;
		case 1:
			$c=file_get_contents($txtloc);
			file_put_contents($pacloc,str_replace("proxyDIRECT","PROXY 172.16.4.182:7070;",$c));
			unset($c);
		break;
		case 2:
			$c=file_get_contents($txtloc);
			file_put_contents($pacloc,str_replace("proxyDIRECT","PROXY 172.16.3.20:808;",$c));
			unset($c);
		break;
		case 3:
			$c=file_get_contents($txtloc);
			if($order==3) {
				file_put_contents($pacloc,str_replace("proxyDIRECT","PROXY 172.16.2.191:6666;", $c));
			}else {
				if($timeArr[0] < $timeArr[1]) {
					file_put_contents($pacloc,str_replace("proxyDIRECT","PROXY 172.16.4.182:7070; PROXY 172.16.3.20:808;", $c));
				}else {
					file_put_contents($pacloc,str_replace("proxyDIRECT","PROXY 172.16.3.20:808; PROXY 172.16.4.182:7070;", $c));
				}
			}
			unset($order);
			unset($c);
		case 6:
			$c=file_get_contents($txtloc);
			echo $timeArr[0]."|".$timeArr[1]."|".$timeArr[2]."\n";
			if($timeArr[0]<$timeArr[1] && $timeArr[1] < $timeArr[2]){
				file_put_contents($pacloc,str_replace("proxyDIRECT","PROXY 172.16.4.182:7070; PROXY 172.16.3.20:808; PROXY 172.16.2.191:6666;",$c));
			}else if($timeArr[0] < $timeArr[2] && $timeArr[2] < $timeArr[1]) {
				file_put_contents($pacloc,str_replace("proxyDIRECT","PROXY 172.16.4.182:7070; PROXY 172.16.2.191:6666; PROXY 172.16.3.20:808;",$c));
			}else if($timeArr[0]>$timeArr[1] && $timeArr[0] < $timeArr[2]){
				file_put_contents($pacloc,str_replace("proxyDIRECT","PROXY 172.16.3.20:808; PROXY 172.16.4.182:7070; PROXY 172.16.2.191:6666;",$c));
			}else if($timeArr[1] < $timeArr[2] && $timeArr[2] < $timeArr[0]) {
				file_put_contents($pacloc,str_replace("proxyDIRECT","PROXY 172.16.3.20:808; PROXY 172.16.2.191:6666; PROXY 172.16.4.182:7070;",$c));
			}else if($timeArr[2] < $timeArr[0] && $timeArr[0] < $timeArr[1]) {
				file_put_contents($pacloc,str_replace("proxyDIRECT","PROXY 172.16.2.191:6666; PROXY 172.16.4.182:7070; PROXY 172.16.3.20:808;",$c));
			}else {
				file_put_contents($pacloc,str_replace("proxyDIRECT","PROXY 172.16.2.191:6666; PROXY 172.16.3.20:808; PROXY 172.16.4.182:7070;",$c));
			}
			unset($c);
		break;
	}
	$left=60;
	$i=0;
	while($i<$left){
		sleep(1);
		$i++;
		echo $i."\tsecond \r";
	}
}
function getCurrentTime (){
    list ($msec, $sec) = explode(" ", microtime());
    return floor(((float)$msec + (float)$sec)*1000);
}
function curl_get_contents($proxy){
	$ch = curl_init();   
	curl_setopt($ch, CURLOPT_URL, "http://167.114.135.189/ip.php?antc=".time());
	curl_setopt($ch, CURLOPT_PROXY, $proxy);
	curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
	curl_setopt($ch, CURLOPT_USERAGENT,"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.137 Safari/537.36");
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($ch, CURLOPT_TIMEOUT, 5);
	curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$r = curl_exec($ch);
	if (curl_errno($ch)) {
		$r="";
	}
	curl_close($ch);   
	return $r;   
}