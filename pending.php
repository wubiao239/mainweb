<?php 
include_once("./url.php")
?>
<!DOCTYPE HTML>
<html>
<head>
<title>pending in domains</title>


<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<!-- Bootstrap -->
<link href="/bootstrap/css/bootstrap.min.css" rel='stylesheet' type='text/css' />

<script type="text/javascript" src="/themes/tmp/js/jquery.min.js"></script>

<script type="text/javascript" src="/bootstrap/js/bootstrap.min.js"></script>
</head>
<body style="width:80%;margin:0 auto;">

<?php 
date_default_timezone_set('Asia/Shanghai');

function show($domainarr,$date){
    $googledomains=array("google.com", "google.ad", "google.ae", "google.com.af", "google.com.ag", "google.com.ai", "google.al", "google.am", "google.co.ao", "google.com.ar", "google.as", "google.at", "google.com.au", "google.az", "google.ba", "google.com.bd", "google.be", "google.bf", "google.bg", "google.com.bh", "google.bi", "google.bj", "google.com.bn", "google.com.bo", "google.com.br", "google.bs", "google.bt", "google.co.bw", "google.by", "google.com.bz", "google.ca", "google.cd", "google.cf", "google.cg", "google.ch", "google.ci", "google.co.ck", "google.cl", "google.cm", "google.cn", "google.com.co", "google.co.cr", "google.com.cu", "google.cv", "google.com.cy", "google.cz", "google.de", "google.dj", "google.dk", "google.dm", "google.com.do", "google.dz", "google.com.ec", "google.ee", "google.com.eg", "google.es", "google.com.et", "google.fi", "google.com.fj", "google.fm", "google.fr", "google.ga", "google.ge", "google.gg", "google.com.gh", "google.com.gi", "google.gl", "google.gm", "google.gp", "google.gr", "google.com.gt", "google.gy", "google.com.hk", "google.hn", "google.hr", "google.ht", "google.hu", "google.co.id", "google.ie", "google.co.il", "google.im", "google.co.in", "google.iq", "google.is", "google.it", "google.je", "google.com.jm", "google.jo", "google.co.jp", "google.co.ke", "google.com.kh", "google.ki", "google.kg", "google.co.kr", "google.com.kw", "google.kz", "google.la", "google.com.lb", "google.li", "google.lk", "google.co.ls", "google.lt", "google.lu", "google.lv", "google.com.ly", "google.co.ma", "google.md", "google.me", "google.mg", "google.mk", "google.ml", "google.com.mm", "google.mn", "google.ms", "google.com.mt", "google.mu", "google.mv", "google.mw", "google.com.mx", "google.com.my", "google.co.mz", "google.com.na", "google.com.nf", "google.com.ng", "google.com.ni", "google.ne", "google.nl", "google.no", "google.com.np", "google.nr", "google.nu", "google.co.nz", "google.com.om", "google.com.pa", "google.com.pe", "google.com.pg", "google.com.ph", "google.com.pk", "google.pl", "google.pn", "google.com.pr", "google.ps", "google.pt", "google.com.py", "google.com.qa", "google.ro", "google.ru", "google.rw", "google.com.sa", "google.com.sb", "google.sc", "google.se", "google.com.sg", "google.sh", "google.si", "google.sk", "google.com.sl", "google.sn", "google.so", "google.sm", "google.sr", "google.st", "google.com.sv", "google.td", "google.tg", "google.co.th", "google.com.tj", "google.tk", "google.tl", "google.tm", "google.tn", "google.to", "google.com.tr", "google.tt", "google.com.tw", "google.co.tz", "google.com.ua", "google.co.ug", "google.co.uk", "google.com.uy", "google.co.uz", "google.com.vc", "google.co.ve", "google.vg", "google.co.vi", "google.com.vn", "google.vu", "google.ws", "google.rs", "google.co.za", "google.co.zm", "google.co.zw", "google.cat");


    echo "<table class=\"table table-striped \"><th>pending date= {$date} </th><th>google site</th> <th>open archive</th><th>open screen</th>";

    foreach ($domainarr as $key => $domain) {
        $googledomain=$googledomains[array_rand($googledomains)];
        //$googledomain="google.mn";
        echo"
            <tr>
            <td><a href=\"https://www.{$googledomain}/?gws_rd=ssl#q=site:".$domain."\" target=\"_blank\">".$domain."</a></td>
            <td><a href=\"https://www.{$googledomain}/?gws_rd=ssl#q=site:".$domain."\" target=\"_blank\">"."查看site结果"."</a></td>
            <td><a href=\"https://web.archive.org/web/*/http://".$domain."\" target=\"_blank\">"."查看archive结果"."</a></td>
            <td><a href=\"http://www.screenshots.com/search/?q=".$domain."\" target=\"_blank\">"."查看screen结果"."</a></td>

            </tr>";

    }
    echo "</table>";



}

$today=date("Y-m-d",time());
$tomorrow=date("Y-m-d",strtotime("tomorrow"));
$yesterday=date("Y-m-d",strtotime("yesterday"));
//getDomains 两个必填参数，第一个是域名后缀，第二个是域名pending日期
$todayin=getDomains("in",$today);
$todayorg=getDomains("org",$today);
// $tomorrowin=getDomains("in",$tomorrow);
// $tomorroworg=getDomains("org",$tomorrow);
//print_r($todayorg);
//$todaycom=getDomains("com",$today);

//login();
show($todayin,$today);
//print_r($todayin);
show($todayorg,$today);

//show($tomorrowin,$tomorrow);
//show($tomorroworg,$tomorrow);
//show($todaycom,$today);



?>





</body>
</html>
 <!--cache-html-->
