<?php 
//phome_ecms_cases_data_1  phome_ecms_cases phome_ecms_cases_index
include_once ('MysqlDB.class.php');
$db = MysqlDB::getInstance('127.0.0.1', 'empirecms', 'root');

//直接从产品数据表中国获取栏目id，获取的不一定准确。根据自己建立的栏目id填写栏目id
$data = $db->fetch("phome_ecms_cases");

print_r($data);

?>