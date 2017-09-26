<?php 
function curl_get ($url,$proxy)
{
    $user_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; zh- CN; rv:1.9.0.5) Gecko/2008120122 Firefox/3.0.5 FirePHP/0.2.1"; 
    $ch = curl_init();
    curl_setopt ($ch, CURLOPT_PROXY, $proxy);
    curl_setopt ($ch, CURLOPT_URL, $url);//设置要访问的IP
    curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent);//模拟用户使用的浏览器 
    @curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 ); // 使用自动跳转  
    curl_setopt ( $ch, CURLOPT_TIMEOUT, 120 ); //设置超时时间
    curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 ); // 自动设置Referer  

    //curl_setopt ($ch, CURLOPT_COOKIEJAR, 'c:\cookie.txt');
    curl_setopt ($ch, CURLOPT_HEADER, 1);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt ($ch, CURLOPT_TIMEOUT, 10);
    $info=curl_getinfo($ch);
    //print_r($info);
    $result = curl_exec($ch);
    // Check if any error occured
    if( $result === false)
    {
        echo "fail";
    }else{
        echo "success";
    }
    curl_close($ch);
    return $result;
}

echo curl_get("http://www.sbmchina.com",'172.16.3.20:808');

 ?>