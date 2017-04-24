<?php 

/***********************
第二种实现办法：用readdir()函数
************************/
//print_r($_SERVER);
function listDir($dir)
{
	$dir=iconv("UTF-8","gb2312",$dir);
	if(is_dir($dir))
   	{
     	if ($dh = opendir($dir)) 
		{
        	while (($file = readdir($dh)) !== false)
			{
     			if((is_dir($dir."/".$file)) && $file!="." && $file!="..")
				{
     				echo 'path=='."$file".PHP_EOL;
     				listDir($dir."/".$file."/");
     			}
				else
				{
         			if($file!="." && $file!="..")
					{
         				echo $file.PHP_EOL;
      				}
     			}
        	}
        	closedir($dh);
     	}
   	}
}
//开始运行
listDir("./finished/case/");



 ?>