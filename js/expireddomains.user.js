// ==UserScript==
// @name        expireddomains
// @author      武镖
// @description expireddomains.net域名批量打开urlurl
// @namespace   http://wubiao.site
// @encoding    utf-8
// @include     https://member.expireddomains.net/domains/*
// @require     http://code.jquery.com/jquery-2.1.1.min.js
// @version     1
// @grant       GM_xmlhttpRequest
// @run-at      document-end
// ==/UserScript==
(function(){


        var Style = 'Style = "background-color:#0d79d1;display:block;cursor:pointer;position:fixed;top:100px;right:30%;z-index:10000;border:solid 1px #010713;color:#fff;height:40px;';
        var Src1 = '<button id="open-url" ' + Style + '">查看Archive</button>';
        var div = document.createElement("div");
        div.innerHTML = Src1;
        document.getElementsByTagName("body")[0].appendChild(div);
        document.getElementById("open-url").addEventListener("click",openArchive, true);



        function openArchive(){
            var i=1;
            $('.field_domain').each(function(){

                    obj=$(this).children('a');
                    console.log(obj.eq(0).attr("title"));
                    var href=obj.eq(0).attr("title");
                    if(href!="undefined"){
                            url="https://web.archive.org/web/*/"+href;
                            window.open(url,"newwindow"+i);

                    }
                    i=i+1;

            });
        }



        var Style = 'Style = "background-color:#0d79d1;display:block;cursor:pointer;position:fixed;top:100px;right:20%;z-index:10000;border:solid 1px #010713;color:#fff;height:40px;';
        var Src1 = '<button id="open-screen" ' + Style + '">查看ScreensHotse</button>';
        var div = document.createElement("div");
        div.innerHTML = Src1;
        document.getElementsByTagName("body")[0].appendChild(div);
        document.getElementById("open-screen").addEventListener("click",openScreensHotse, true);



        function openScreensHotse(){
            var i=1;
            $('.field_domain').each(function(){

                    obj=$(this).children('a');
                    console.log(obj.eq(0).attr("title"));
                    var href=obj.eq(0).attr("title");
                    if(href!="undefined"){
                            url="http://www.screenshots.com/"+href+"/";
                            window.open(url,"newwindow"+i);

                    }
                    i=i+1;

            });
        }




})();





