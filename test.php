<?php 
//根据url获取文件名称
// function getProductName($url){
//     $str=$url;
//     $file=substr($str,strripos($str, "/")+1);
//     $proName=substr($file,0,strripos($file, "."));
//     return $proName;

// }
// $str="http://www.shibangchina.com/products/c6x.html";
// $file=substr($str,strripos($str, "/")+1);
// $proName=substr($file,0,strripos($file, "."));
// // echo $proName;
// $dir=$proName;
// if (!is_dir($dir)) mkdir($dir);


// function downImg($url, $saveName)
// {
//     $in=    fopen($url, "rb");
//     $out=   fopen($saveName, "wb");
//     while ($chunk = fread($in,8192))
//     {
//         fwrite($out, $chunk, 8192);
//     }
//     fclose($in);
//     fclose($out);
// }


//downImg("http://www.shibangchina.com/images/products/mb5x/mb5x1.png","mb5x1.png");

// function getContent($url){
//     $fContent=file_get_contents($url);
//     $resultContent=array();
//     $resultTitle=array();
//     $resultDes=array();
//     $regDivCarousel="~<div class=\"carousel-desc mt20\">(.*?)</div>~is";
//     $regTitle="~<h1>(.*?)</h1>~is";
//     $regDes="~<p>(.*?)</p>~is";
//     preg_match($regDivCarousel,$fContent,$resultContent);
//     $divCarousel=trim($resultContent[1]);
//     if(!empty($resultContent)){
//         echo $divCarousel;
//         preg_match($regTitle,$divCarousel,$resultTitle);
//         @$title=$resultTitle[1];
//         print_r($resultTitle);
//         echo $title;
//         preg_match_all($regDes,$divCarousel,$resultDes);
//         @$des=$resultDes[1];
//         print_r($resultDes);
//         echo $des;
       
//     }else{
//         echo "not collected DivCarousel content";

//     }

    
    
//     print_r($resultContent);

// }

// function getTitleDes($url){
//     $fContent=file_get_contents($url);
//     //从网页中采集title和description以及content前两段
//     $resultContent=array();
//     $resultTitle=array();
//     $resultDes=array();
//     $regDivCarousel="~<div class=\"carousel-desc mt20\">(.*?)</div>~is";
//     $regTitle="~<h1>(.*?)</h1>~is";
//     $regDes="~<p>(.*?)</p>~is";
//     preg_match($regDivCarousel,$fContent,$resultContent);
//     $divCarousel=trim($resultContent[1]);
//     if(!empty($resultContent)){
//         preg_match($regTitle,$divCarousel,$resultTitle);
//         @$title=$resultTitle[1];
//         preg_match_all($regDes,$divCarousel,$resultDes);
//         foreach ($des=$resultDes[1] as $key => $value) {
//            @$des=$value.PHP_EOL;
//         }
       
//     }else{
//         echo "not collected DivCarousel content";

//     }

//     return array($title,$des,$divCarousel);

// }


// $content=getTitleDes("http://www.shibangchina.com/products/mtw_mill.html");
// print_r($content);
 ?>