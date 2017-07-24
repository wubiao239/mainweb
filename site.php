<?php 

header("content-type:text/html;charset=utf-8");
set_time_limit(0);
//error_reporting(0);

//模拟登录 
function login_post($url, $cookie, $post) { 
    $curl = curl_init();//初始化curl模块 
    curl_setopt($curl, CURLOPT_URL, $url);//登录提交的地址 
    curl_setopt($curl, CURLOPT_HEADER, 1);//是否显示头信息 
    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//是否自动显示返回的信息 
    //curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie); //设置Cookie信息保存在指定的文件中 
    curl_setopt($curl, CURLOPT_POST, 1);//post方式提交 
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); //不验证证书
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    //curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));//要提交的信息 
    curl_exec($curl);//执行cURL 
    //print_r( curl_getinfo($curl)); 
    curl_close($curl);//关闭cURL资源，并且释放系统资源 

} 

//登录成功后获取数据 
function get_content($url) { 
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_HEADER, 1); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //curl_setopt($ch, CURLOPT_COOKIEFILE, "$cookie"); //读取cookie 
    // curl_setopt($ch, CURLOPT_COOKIE, "ExpiredDomainssessid=isacigjlpp6jgdpv3dfgptmu74; _pk_ref.12.a1ac=%5B%22%22%2C%22%22%2C1476416135%2C%22https%3A%2F%2Fwww.expireddomains.net%2Flogin%2F%22%5D; _pk_id.12.a1ac=c7ef0b1302fcd665.1476067477.9.1476416172.1476416135."); //读取cookie 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //不验证证书
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    $rs = curl_exec($ch); //执行cURL抓取页面内容 
    curl_close($ch);
   
    return $rs; 
} 
function show($domainarr){
    $googledomains=array("google.com", "google.ad", "google.ae", "google.com.af", "google.com.ag", "google.com.ai", "google.al", "google.am", "google.co.ao", "google.com.ar", "google.as", "google.at", "google.com.au", "google.az", "google.ba", "google.com.bd", "google.be", "google.bf", "google.bg", "google.com.bh", "google.bi", "google.bj", "google.com.bn", "google.com.bo", "google.com.br", "google.bs", "google.bt", "google.co.bw", "google.by", "google.com.bz", "google.ca", "google.cd", "google.cf", "google.cg", "google.ch", "google.ci", "google.co.ck", "google.cl", "google.cm", "google.cn", "google.com.co", "google.co.cr", "google.com.cu", "google.cv", "google.com.cy", "google.cz", "google.de", "google.dj", "google.dk", "google.dm", "google.com.do", "google.dz", "google.com.ec", "google.ee", "google.com.eg", "google.es", "google.com.et", "google.fi", "google.com.fj", "google.fm", "google.fr", "google.ga", "google.ge", "google.gg", "google.com.gh", "google.com.gi", "google.gl", "google.gm", "google.gp", "google.gr", "google.com.gt", "google.gy", "google.com.hk", "google.hn", "google.hr", "google.ht", "google.hu", "google.co.id", "google.ie", "google.co.il", "google.im", "google.co.in", "google.iq", "google.is", "google.it", "google.je", "google.com.jm", "google.jo", "google.co.jp", "google.co.ke", "google.com.kh", "google.ki", "google.kg", "google.co.kr", "google.com.kw", "google.kz", "google.la", "google.com.lb", "google.li", "google.lk", "google.co.ls", "google.lt", "google.lu", "google.lv", "google.com.ly", "google.co.ma", "google.md", "google.me", "google.mg", "google.mk", "google.ml", "google.com.mm", "google.mn", "google.ms", "google.com.mt", "google.mu", "google.mv", "google.mw", "google.com.mx", "google.com.my", "google.co.mz", "google.com.na", "google.com.nf", "google.com.ng", "google.com.ni", "google.ne", "google.nl", "google.no", "google.com.np", "google.nr", "google.nu", "google.co.nz", "google.com.om", "google.com.pa", "google.com.pe", "google.com.pg", "google.com.ph", "google.com.pk", "google.pl", "google.pn", "google.com.pr", "google.ps", "google.pt", "google.com.py", "google.com.qa", "google.ro", "google.ru", "google.rw", "google.com.sa", "google.com.sb", "google.sc", "google.se", "google.com.sg", "google.sh", "google.si", "google.sk", "google.com.sl", "google.sn", "google.so", "google.sm", "google.sr", "google.st", "google.com.sv", "google.td", "google.tg", "google.co.th", "google.com.tj", "google.tk", "google.tl", "google.tm", "google.tn", "google.to", "google.com.tr", "google.tt", "google.com.tw", "google.co.tz", "google.com.ua", "google.co.ug", "google.co.uk", "google.com.uy", "google.co.uz", "google.com.vc", "google.co.ve", "google.vg", "google.co.vi", "google.com.vn", "google.vu", "google.ws", "google.rs", "google.co.za", "google.co.zm", "google.co.zw", "google.cat");




    foreach ($domainarr as $key => $domain) {
        $googledomain=$googledomains[array_rand($googledomains)];
        //$googledomain="google.mn";
        $siteUrls="https://www.{$googledomain}/?gws_rd=ssl#q=site:".$domain;
        echo"
           ";

}
   
function getUrls($fileName){
    echo $fileName;
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
$domainUrls=getUrls("urls.txt");
print_r($domainUrls);
//show($domainUrls);

}








 ?>