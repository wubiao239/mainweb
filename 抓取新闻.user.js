// ==UserScript==
// @name        油猴脚本采集链接图片
// @author      武镖
// @description 油猴脚本采集主站后台的产品和链接
// @namespace   http://wubiao.site
// @encoding    utf-8
// @include     http://static.sbmchina.com/e/admin/ListNews.php*
// @require     http://code.jquery.com/jquery-2.1.1.min.js
// @version     1
// @grant       GM_xmlhttpRequest
// @run-at      document-end
// ==/UserScript==
(function(){
        var Style = 'Style = "display:block;cursor:pointer;position:fixed;top:100px;right:20%;z-index:10000';
        var Src1 = '<button id="Go-To-Top" ' + Style + '">点击抓取</button>';
        var div = document.createElement("div");
        div.innerHTML = Src1;
        document.getElementsByTagName("body")[0].appendChild(div);
        document.getElementById("Go-To-Top").addEventListener("click",clickme, false);

        function clickme(){
            $('div').each(function(){
                    if($(this).attr('align')=="left"){
                            obj=$(this).children('a');
                            console.log(obj.eq(0).attr("href"));
                            console.log(obj.eq(1).attr("href"));
                                GM_xmlhttpRequest({
                                        method: 'POST',
                                        url: 'http://ww.mainweb.com/log.php',
                                        data:"u="+obj.eq(0).attr("href")+"&u2="+obj.eq(1).attr("href"),
                                        //headers: {"Content-Type": "application/x-www-form-urlencoded"},
                                        onload: function(response) {
                                                console.log(response.responseText);
                                        }
                                });
                    }
            });
        }
})();





