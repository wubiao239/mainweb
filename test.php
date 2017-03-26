<?php 
@header("Content-Type: text/html; charset=UTF-8");
// error_reporting(0);
//不限执行时间
set_time_limit(0); 
//error_reporting(0);
$fileName="caselist.txt";
$domain="http://www.shibangchina.com";
include_once("functions.php");


$source=getCaseSource2("http://www.shibangchina.com/case/material/gangzhachuli.html");
print_r($source);
// print_r($source);
//main();
?>