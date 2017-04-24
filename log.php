<?php
if($_POST["u"]!="undefined"){
        $fp=fopen("prolist.txt", "a+");
        fwrite($fp,$_POST["u"]."\t".$_POST["u2"]."\r\n");
        fclose($fp);
}
echo "ok";

?>