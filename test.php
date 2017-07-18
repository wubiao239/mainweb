<?php 

include_once ('MysqlDB.class.php');
include_once("getSource.php");
$db = MysqlDB::getInstance('127.0.0.1', 'multilang.sbmchina.com', 'root','shibang416');

$data=$db->fetch("phome_ecms_news","where classid=152");

print_r($data);


 ?>