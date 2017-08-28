<?php
if($_POST["u"]!="undefined"){
        $fp=fopen("urls_log.txt", "a+");
        fwrite($fp,$_POST["u"]."\r\n");
        
}
fclose($fp);
echo "ok";

?>