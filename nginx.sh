#!/bin/bash

while :
do
	nginxpid=$(ps -C nginx --no-header | wc -l);
	if [ $nginxpid -eq 0 ];then
		# /etc/init.d/nginx restart
		service nginx restart;
		sleep 5;
		nginxpid=$(ps -C nginx --no-header | wc -l);
		echo $nginxpid;
		if [ $nginxpid -eq 0 ];then
			php sendmail.php
		fi
	fi
	sleep 5;
done