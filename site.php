<?php 

header("content-type:text/html;charset=utf-8");
set_time_limit(0);
//error_reporting(0);
function getRandomAgent() {
    $agents = array('Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36',
                 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
                 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:21.0) Gecko/20100101 Firefox/21.0',
                 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; QQDownload 718; .NET CLR 2.0.50727; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729)',
                 'Mozilla/5.0 (compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm)',
                 'Mozilla/5.0 (X11; U; Linux x86_64; en-US; rv:1.9) Gecko Minefield/3.0',
                 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6',
                 'Mozilla/5.0 (iPhone; CPU iPhone OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Mobile/9B206',
                 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0; MATP; MATP)',
                 'Mozilla/5.0 (Windows NT 6.1; rv:22.0) Gecko/20100101 Firefox/22.0');
     $agent = $agents[array_rand($agents)];
     return $agent;
}

function getRandomGoogle(){
	$googledomains=array("google.com", "google.ad", "google.ae", "google.com.af", "google.com.ag", "google.com.ai", "google.al", "google.am", "google.co.ao", "google.com.ar", "google.as", "google.at", "google.com.au", "google.az", "google.ba", "google.com.bd", "google.be", "google.bf", "google.bg", "google.com.bh", "google.bi", "google.bj", "google.com.bn", "google.com.bo", "google.com.br", "google.bs", "google.bt", "google.co.bw", "google.by", "google.com.bz", "google.ca", "google.cd", "google.cf", "google.cg", "google.ch", "google.ci", "google.co.ck", "google.cl", "google.cm", "google.cn", "google.com.co", "google.co.cr", "google.com.cu", "google.cv", "google.com.cy", "google.cz", "google.de", "google.dj", "google.dk", "google.dm", "google.com.do", "google.dz", "google.com.ec", "google.ee", "google.com.eg", "google.es", "google.com.et", "google.fi", "google.com.fj", "google.fm", "google.fr", "google.ga", "google.ge", "google.gg", "google.com.gh", "google.com.gi", "google.gl", "google.gm", "google.gp", "google.gr", "google.com.gt", "google.gy", "google.com.hk", "google.hn", "google.hr", "google.ht", "google.hu", "google.co.id", "google.ie", "google.co.il", "google.im", "google.co.in", "google.iq", "google.is", "google.it", "google.je", "google.com.jm", "google.jo", "google.co.jp", "google.co.ke", "google.com.kh", "google.ki", "google.kg", "google.co.kr", "google.com.kw", "google.kz", "google.la", "google.com.lb", "google.li", "google.lk", "google.co.ls", "google.lt", "google.lu", "google.lv", "google.com.ly", "google.co.ma", "google.md", "google.me", "google.mg", "google.mk", "google.ml", "google.com.mm", "google.mn", "google.ms", "google.com.mt", "google.mu", "google.mv", "google.mw", "google.com.mx", "google.com.my", "google.co.mz", "google.com.na", "google.com.nf", "google.com.ng", "google.com.ni", "google.ne", "google.nl", "google.no", "google.com.np", "google.nr", "google.nu", "google.co.nz", "google.com.om", "google.com.pa", "google.com.pe", "google.com.pg", "google.com.ph", "google.com.pk", "google.pl", "google.pn", "google.com.pr", "google.ps", "google.pt", "google.com.py", "google.com.qa", "google.ro", "google.ru", "google.rw", "google.com.sa", "google.com.sb", "google.sc", "google.se", "google.com.sg", "google.sh", "google.si", "google.sk", "google.com.sl", "google.sn", "google.so", "google.sm", "google.sr", "google.st", "google.com.sv", "google.td", "google.tg", "google.co.th", "google.com.tj", "google.tk", "google.tl", "google.tm", "google.tn", "google.to", "google.com.tr", "google.tt", "google.com.tw", "google.co.tz", "google.com.ua", "google.co.ug", "google.co.uk", "google.com.uy", "google.co.uz", "google.com.vc", "google.co.ve", "google.vg", "google.co.vi", "google.com.vn", "google.vu", "google.ws", "google.rs", "google.co.za", "google.co.zm", "google.co.zw", "google.cat");

	$googledomain=$googledomains[array_rand($googledomains)];
	return $googledomain;

}

function getRandomProxy() {
    $proxies = array('172.16.4.182:1314',
                 '172.16.3.20:808',
                 //'60.51.218.180:8080'
                 );
    $proxy = $proxies[array_rand($proxies)];
    return $proxy;
}
function get($url){
    $header= array( 
    'GET / HTTP/1.1',
    'Host: '.getRandomGoogle(),
    'Accept-Encoding: gzip, deflate',
    'User-Agent:'.getRandomAgent(), 
    'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8', 
    'Accept-Language: zh-cn,zh;q=0.5', 
    'Accept-Charset: GB2312,utf-8;q=0.7,*;q=0.7', 
    'Keep-Alive:300', 
    'Connection:keep-alive' 
    ); 
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, false);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_PROXY, getRandomProxy());
    curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // curl_setopt($ch, CURLOPT_SSLVERSION,CURL_SSLVERSION_DEFAULT);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $content= curl_exec ($ch);
    $error = curl_error($ch); 
    curl_close ($ch);
    //$content=mb_convert_encoding($content, 'utf-8',mb_detect_encoding($content));
    return $content;
}
function site($domain) {

    //https://www.google.com.hk/search?hl=en&q=hello
    //$siteUrls="https://www.{$googledomain}/?gws_rd=ssl#q=site:".$domain;
    $siteUrls="https://www.".getRandomGoogle()."/search?hl=en&q=site:".$domain;
    return trim($siteUrls);

	
}
   
function getUrls($fileName){
    //echo $fileName;
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

$urls=getUrls("siteUrls.txt");
require_once('phpQuery/phpQuery.php');
$nosites=array();
echo "查询有结果的域名".'</br>';
echo "+++++++++++++++++++++++++++++".'</br>';
foreach ($urls as $url) {
	# code...
	$site=site($url);
	//echo get($site);
	$html=phpQuery::newDocumentFile(get($site));         

	$result=$html->find('#resultStats')->html();
	if(empty($result)){
		$nosites[]=$url;
	}else{
		echo $url."===========>".$result."</br>";
	}
	sleep(rand(15,45));
	
}
if(!empty($nosites)){
	echo "查询无结果的域名"."</br>";
	echo "+++++++++++++++++++++++++++++".'</br>';
	foreach ($nosites as $nosite) {
		# code...
		echo $nosite.'</br>';
	}
}








 ?>