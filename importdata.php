<?php

/**
 * 传入路径得到所有的文件名
 * @param  [string]
 * @return [array]
 */
function listDir($dir) {
    $dir = iconv("UTF-8", "gb2312", $dir);
    $dirs = array();
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if ((is_dir($dir . "/" . $file)) && $file != "." && $file != "..") {
                   // echo "$file" . PHP_EOL;
                    $dirs[] = $file;
                    //listDir($dir."/".$file."/");
                    
                }
            }
            closedir($dh);
        }
    }
    return $dirs;
}
//phome_ecms_products_data_1  phome_ecms_products phome_ecms_products_index
include_once ('MysqlDB.class.php');
$db = MysqlDB::getInstance('127.0.0.1', 'empirecms', 'root');

//直接从产品数据表中国获取栏目id，获取的不一定准确。根据自己建立的栏目id填写栏目id
// $data = $db->fetch("phome_ecms_products", "Row");
// $classid = $data['classid'];

$classid = 60;

$path = "./finished/products/";
$dirs = listDir($path);
foreach ($dirs as $key => $value) {
    //if($key >= 1) break;
    $allpath = $path . $value;
    $title = file_get_contents($allpath . '/' . 'title.html');
    $des = file_get_contents($allpath . '/' . 'des.html');
    $content = file_get_contents($allpath . '/' . 'content.html');
    //产品数据表中字段
    $profield = array(
        "classid" => 60,
        "ttid" => 0,
        "onclick" => 0,
        "plnum" => 0,
        "totaldown" => 0,
        //"newspath" => "",
        "filename" => $value,
        "userid" => 1,
        "username" =>"wubiao",
        "firsttitle" => 0,
        "isgood" => 0,
        "ispic" => 0,
        "istop" => 0,
        "isqf" => 0,
        "ismember" => 0,
        "isurl" => 0,
        "truetime" => 1493202154,
        "lastdotime" => 1493202154,
        "havehtml" => 1,
        "groupid" => 0,
        "userfen" => 0,
        "titlefont" => "",
        "titleurl" => "/products/{$value}.html",
        "stb" => 1,
        "fstb" => 1,
        "restb" => 1,
        //"keyboard" => "",
        "title" => $title,
        "newstime" => 1493109247,
        "titlepic" => "/images/{$value}/{$value}.jpg",
        "banner" => "<p>{$des}</p>",
        "serices" => $value,
        "content" => $content,
        "related_case" => 10,
        "related_products" => 10
    );
    $data = $db->insert("phome_ecms_products", $profield);

    $re = $db->query("select * from phome_ecms_products where title='{$title}'");
    $result=$re->fetch();
    $id=$result['id'];
    
    //产品数据分表中字段
    $proDataField = array(
        "id" => $id,
        "classid" => $classid,
        //"keyid" =>"",
        "dokey" => 0,
        "newstempid" => 0,
        "closepl" => 0,
        "haveaddfen" => 0,
        //"infotags" =>"" ,
        
    );
   
    $data = $db->insert("phome_ecms_products_data_1", $proDataField);
    //产品索引表中字段
    $proIndex = array(
        "id" => $id,
        "classid" => $classid,
        "checked" => 1,
        "newstime" => 1493109247,
        "truetime" => 1493109247,
        "lastdotime" => 1493109247,
        "havehtml" => 1
    );
    //print_r($proIndex);
    $data = $db->insert("phome_ecms_products_index", $proIndex);
    echo 'insert into '.$value." success".PHP_EOL;
}
$db->close();
?>
