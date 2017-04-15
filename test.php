<?php 
@header("Content-Type: text/html; charset=UTF-8");
//不限执行时间
set_time_limit(0); 
error_reporting(0);
abstract class SearchInterface   
{  
    protected $G;//图  
    protected $s;//图的首节点  
    function __construct($_G,$_s){$this->G = $_G;$this->s = $_s;}  
    public abstract function search();  
}  

class bfs extends SearchInterface  
{  
    private $d = array();//源点s和顶点u之间的距离  
    private $tt = array();//结点u的父母存于变量  
    private $visit = array();//已访问节点  
      
    function __construct($_G,$_s)  
    {  
        parent::__construct($_G,$_s);  
          
        //初始化$d/$tt,初始值为无穷大/NULL  
        for($i=0;$i<9;$i++)  
        {  
            $this->d[$i] = 20000;  
            $this->tt[$i] = NULL;  
            $this->visit[$i] = 0;  
        }  
          
    }  
    public function search()  
    {  
        //访问所有节点  
          
        $queue = array();  
        for($i=0;$i<9;$i++)  
        {  
            if($this->visit[$i]==0)  
            {  
                array_push($queue,$i);  
                while(!empty($queue))  
                {  
                    $_s = array_shift($queue);                    
                    $this->visit[$_s] = 1;  
                    echo ($_s+1).'<br>';  
                      
                    $link_s = $this->G->get_links($_s);  
                    //获取和s直接相连的顶点u  
                      
                    foreach($link_s as $j => $u)  
                    {  
                        if($this->visit[$u]==0)  
                        {  
                            array_push($queue,$u);  
                            $this->visit[$u] = 2;      
                        }  
                    }  
                }  
            }  
        }  
    }  
  
}  

$G = new Graphic;  
$search = new bfs($G,1);  
$search->search();  

?>