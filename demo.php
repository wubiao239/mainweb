<?php

header("Content-Type: text/html; charset=utf-8");
require_once('phpQuery/phpQuery.php');
phpQuery::newDocumentFile('http://www.shibangchina.com/case/material/277.html');         
$arr=pq("#new_case_content > div");
$img =pq("img",$arr);
foreach($img as $src){
echo pq($src)->attr("src")."<br />";                                    
}
                                      
foreach($arr as $li){
echo pq($li)->html()."<br />";                                    
}
?>