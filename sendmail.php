<?php  
require_once('SMTP.class.php');  
//##########################################  
$smtpserver = "smtp.163.com";//SMTP服务器  
$smtpserverport = 25;//SMTP服务器端口  
$smtpusermail = "wubiao239@163.com";//SMTP服务器的用户邮箱  
$smtpemailto = "1475715597@qq.com";//发送给谁  
$smtpuser = "wubiao239@163.com";//SMTP服务器的用户帐号  
$smtppass = "wb123456";//SMTP服务器的用户密码  
$mailsubject = "vps 宕机需要人工恢复";//邮件主题  
$mailbody = "<h1> vps中域名统计</h1>";//邮件内容 
$mailbody.="multilang.sbmchina.com"."</br>". 
			"sbmconveyor.com"."</br>".
			"sbmmac.com"."</br>".     
			"sbm-mill.com"."</br>".
			"sbmsaudisp.com"."</br>".
			"shibangtech.com"."</br>".    
			"vn.sbmchina.com"."</br>".
			"mongolia.sbmchina.com"."</br>".
			"portablecrusher.sbmchina.com"."</br>".
			"sbm-crushers.com"."</br>".
			"sbm-mine.com"."</br>".  
			"shibanggroup.com"."</br>".
			"m.sbmchina.com"."</br>".
			"pt.sbmchina.com"."</br>".             
			"sbm-grinding.com"."</br>".
			"sbmmachinery.com"."</br>".
			"sbmmineral.com"."</br>".
			"shibangmac.com"."</br>".
			"sparepart.sbmchina.com"."</br>"; 
$mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件  
##########################################  
$smtp = new smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.  
$smtp->debug = false;//是否显示发送的调试信息  
$smtp->sendmail($smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype);  
?>  