<?php 
@header("Content-Type: text/html; charset=UTF-8");
//不限执行时间
set_time_limit(0); 
//error_reporting(0);
$domain="";
//$pendingurls=array();
$urls=array();

/**
 * 获取单页本站没有被抓取的连接
 * @param  string 
 * @return array
 */
function fetchlinks($url)
{        
        global $urls;

        $links=array();
        $pendingLinks=array();
        if ($content=file_get_contents($url))
        {        
                if(array_search($url, $urls)===false)
                        array_push($urls,$url);                
                $links= striplinks($content);
                $links= expandlinks($links, $url);
                foreach ($links as $key => $value) {
                        if(array_search($value, $urls)===false){
                                echo $value.PHP_EOL;
                                array_push($pendingLinks, $value);
                        }
                }

                return $pendingLinks;
        }
        else
                return array();
}

/**
 * 将采集的href替换成包含域名的地址
 * @param  array
 * @param  string
 * @return array
 */
function expandlinks($links,$url)
{
        global $domain;
        preg_match("~^[^\?]+~",$url,$match);

        $match = preg_replace("~/[^\/\.]+\.[^\/\.]+$~","",$match[0]);
        $match = preg_replace("~/$~","",$match);
        $match_part = parse_url($match);
        $match_root =$match_part["scheme"]."://".$match_part["host"];
        if(empty($domain)){
                $domain=$match_part["host"];
        }
                        
        $search = array(         "~^http://".preg_quote($domain)."~i",
                                                "~^(\/)~i",
                                                "~^(?!http://)(?!mailto:)~i",
                                                "~/\./~",
                                                "~/[^\/]+/\.\./~",
                                                "~/index\.html~",
                                                "~/#.*~",
                                                "~/cdn-cgi.*~"
                                        );
                                        
        $replace = array(        "",
                                                $match_root."/",
                                                $match."/",
                                                "/",
                                                "/",
                                                "/",
                                                "/",
                                                "/"
                                        );                        
        foreach ($links as $key => $value) {
                $expandedLinks[] = preg_replace($search,$replace,$value);
                
        }                
        
        $expandedLinks=array_unique($expandedLinks);
        foreach ($expandedLinks as $key => $value) {
                // $check=get_headers($value,1);
                
                // if(stripos($value, $domain)===false||$check[0]!='HTTP/1.1 200 OK'){
                //         unset($expandedLinks[$key]);
                // }

                
                if(stripos($value, $domain)===false){
                        unset($expandedLinks[$key]);
                }

        }
        $expandedLinks=array_unrepeat($expandedLinks);
        return $expandedLinks;
}

//去掉重复项并把数组重新排列
function array_unrepeat($input){
   
    $keys = array();
    for($i=0;$i<count($input);$i++){
        $keys[$i] = $i;
    }
    return  array_combine($keys, $input);
} 
//获取文档中的所有连接
function striplinks($document)
{        
        preg_match_all("~<\s*a\s.*?href\s*=\s*                        # find <a href=
                                        ([\"\'])?                                        # find single or double quote
                                        (?(1) (.*?)\\1 | ([^\s\>]+))                # if quote found, match up to next matching
                                                                                                # quote, otherwise match up to next space
                                        ~isx",$document,$links);
                                        
        while(list($key,$val) = each($links[2]))
        {
                if(!empty($val))
                        $match[] = $val;
        }                                
        
        while(list($key,$val) = each($links[3]))
        {
                if(!empty($val))
                        $match[] = $val;
        }                
        
        return $match;
}

//采用广度优先算法获取网站的所有链接
function getSiteLinks($urlArry) 
{         
        global $urls;
        if(empty($urlArry)){
                
                return;
        }
        $urls=array_merge($urls,$urlArry);
        
        foreach ($urlArry as $key => $value) {
                //echo $value.PHP_EOL;
                $pendingUrls=fetchlinks($value);
                getSiteLinks($pendingUrls);
        }
} 


$hrefs=fetchlinks("http://www.sbmchina.com");
getSiteLinks($hrefs);
print_r($urls);

?>