// ==UserScript==
// @name        油猴脚本采集搜索引擎链接
// @author      武镖
// @description 油猴脚本抓取google搜索的url
// @namespace   http://wubiao.site
// @encoding    utf-8
// @include     https://www.baidu.com/s*
// @include     https://www.google.com/search*
// @require     http://code.jquery.com/jquery-2.1.1.min.js
// @version     1
// @grant       GM_xmlhttpRequest
// @run-at      document-end
// ==/UserScript==
(function(){
        
        var Style = 'Style = "background-color:#0d79d1;display:block;cursor:pointer;position:fixed;top:100px;right:20%;z-index:10000;border:solid 1px #010713 ;color:#fff;height:40px;';
        var Src1 = '<button id="Go-To-Top" ' + Style + '">点击抓取</button>';
        var div = document.createElement("div");
        div.innerHTML = Src1;
        document.getElementsByTagName("body")[0].appendChild(div);
        document.getElementById("Go-To-Top").addEventListener("click",catchUrl, false);

        var Style = 'Style = "background-color:#0d79d1;display:block;cursor:pointer;position:fixed;top:100px;right:30%;z-index:10000;border:solid 1px #010713;color:#fff;height:40px;';
        var Src1 = '<button id="open-url" ' + Style + '">打开网站</button>';
        var div = document.createElement("div");
        div.innerHTML = Src1;
        document.getElementsByTagName("body")[0].appendChild(div);
        document.getElementById("open-url").addEventListener("click",openUrl, true);
        //alert(window.location.host);
        // function isDomain(){
        //     if(window.location.host)

        // }
        host=window.location.host
        // if(host=="www.baidu.com"){
        //     alert(host);
        //     window.location=location;
        // }
        function catchUrl(){
        	if(host=="www.google.com"){
               $('.r').each(function(){
                       
                       obj=$(this).children('a');
                       var href=obj.eq(0).attr("href");
                       console.log(href);
                       //console.log(obj.eq(1).attr("href"));
                       if(href.indexOf("/search?q=")){
                           GM_xmlhttpRequest({
                                   method: 'POST',
                                   url: 'http://ww.mainweb.com/getUrls_log.php',
                                   data:"u="+obj.eq(0).attr("href"),
                                   headers: {"Content-Type": "application/x-www-form-urlencoded"},
                                   onload: function(response) {
                                           console.log(response.responseText);
                                   }
                           });
                       }
                           
                       
               }); 
            }

            if(host=="www.baidu.com"){
               $('.t').each(function(){
                       
                       obj=$(this).children('a');
                       var href=obj.eq(0).attr("href");
                       console.log(href);
                       //console.log(obj.eq(1).attr("href"));
                       if(href.indexOf("/search?q=")){
                           GM_xmlhttpRequest({
                                   method: 'POST',
                                   url: 'http://ww.mainweb.com/getUrls_log.php',
                                   data:"u="+obj.eq(0).attr("href"),
                                   headers: {"Content-Type": "application/x-www-form-urlencoded"},
                                   onload: function(response) {
                                           console.log(response.responseText);
                                   }
                           });
                       }
                           
                       
               }); 
            }
            
            
        }

        function openUrl(){
            var i=1;
            if(host=="www.google.com"){
                $('.r').each(function(){
                        
                        obj=$(this).children('a');
                        console.log(obj.eq(0).attr("href"));
                        var href=obj.eq(0).attr("href");
                        if(href!="undefined"){
                            if(href.indexOf("/search?q=")){
                                //alert(i);
                                console.log(href);
                                window.open(href,"newwindow"+i);
                            }
                        }
                    i=i+1;    
                        
                });
            }
            if(host=="www.baidu.com"){
                $('.t').each(function(){
                        
                    obj=$(this).children('a');
                    console.log(obj.eq(0).attr("href"));
                    var href=obj.eq(0).attr("href");
                    if(href!="undefined"){
                       
                            window.open(href,"newwindow"+i);
                       
                    }
                    i=i+1;
                        
                        
                });

            }

            
        }
        

        // function openUrl(){
        //     var i=1;
        //     $('.r').each(function(){
                    
        //             obj=$(this).children('a');
        //             console.log(obj.eq(0).attr("href"));
        //             var href=obj.eq(0).attr("href");
        //             if(href!="undefined"){
        //                 if(href.indexOf("/search?q=")){
                            

        //                     var vra=document.createElement('a');

        //                     vra.target='_blank';

        //                     vra.href=href;

        //                     document.body.appendChild(vra);

        //                     vra.click();
        //                 }
        //             }
        //             i=i+1;
                    
        //     });
        // }
         

})();

	



