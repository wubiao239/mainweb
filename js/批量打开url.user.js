// ==UserScript==
// @name        油猴脚本批量打开url
// @author      武镖
// @description 油猴脚本批量打开url
// @namespace   http://wubiao.site/url
// @encoding    utf-8
// @include     https://www.baidu.com/*
// @run-at      document-end
// ==/UserScript==
(function(){

        var Style = 'Style = "background-color:#fff;display:block;cursor:pointer;position:fixed;bottom:25%;right:10%;z-index:10000;border:solid 1px #010713 ;height:400px;width:300px;';
        var Src1 = '<textarea placeholder="添加网址,每个网址占一行" id="urls" ' + Style + '"></textarea>';
        var div = document.createElement("div");
        div.innerHTML = Src1;
        document.getElementsByTagName("body")[0].appendChild(div);


        var Style = 'Style = "background-color:#0d79d1;display:block;cursor:pointer;position:fixed;bottom:15%;right:10%;z-index:10000;border:solid 1px #010713;color:#fff;height:40px;';
        var Src1 = '<button id="open-url" ' + Style + '">打开网站</button>';
        var div = document.createElement("div");
        div.innerHTML = Src1;
        document.getElementsByTagName("body")[0].appendChild(div);
        document.getElementById("open-url").addEventListener("click",openUrl, true);


        function openUrl(){
            var i=1;
            var strUrls=document.getElementById("urls").value;
            //alert(strUrls);
            var urls=new Array();
            urls=strUrls.split("\n");
            //console.log(urls);

                for (var k = 0, length = urls.length; k < length; k++) {
                  if(urls[k].indexOf("http")>=0){
                    window.open(urls[k],"newwindow"+i);
                    //console.log(urls[k]);
                  }
                  i=i+1;
                }




        }






})();





