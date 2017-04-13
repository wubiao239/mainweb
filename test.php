<?php 
@header("Content-Type: text/html; charset=UTF-8");
//不限执行时间
set_time_limit(0); 
error_reporting(0);

function fetchlinks($url)
{	
	$links=array();
	if ($content=file_get_contents($url))
	{			
		$links= striplinks($content);
		$links= expandlinks($links, $url);

		return $links;
	}
	else
		return false;
}

function expandlinks($links,$url)
{
	
	preg_match("~^[^\?]+~",$url,$match);

	$match = preg_replace("~/[^\/\.]+\.[^\/\.]+$~","",$match[0]);
	$match = preg_replace("~/$~","",$match);
	$match_part = parse_url($match);
	$match_root =$match_part["scheme"]."://".$match_part["host"];
			
	$search = array( 	"~^http://".preg_quote($match_part["host"])."~i",
						"~^(\/)~i",
						"~^(?!http://)(?!mailto:)~i",
						"~/\./~",
						"~/[^\/]+/\.\./~"
					);
					
	$replace = array(	"",
						$match_root."/",
						$match."/",
						"/",
						"/"
					);			
	foreach ($links as $key => $value) {
		$expandedLinks[] = preg_replace($search,$replace,$value);
	}		
	

	return $expandedLinks;
}

function striplinks($document)
{	
	preg_match_all("~<\s*a\s.*?href\s*=\s*			# 查找 <a href=
					([\"\'])?					# 查找单双引号
					(?(1) (.*?)\\1 | ([^\s\>]+))		# if quote found, match up to next matching
												# quote, otherwise match up to next space
					~isx",$document,$links);
					

	while(list($key,$val) = each($links[2]))
	{
		if(!empty($val))
			$match[] = $val;
	}				
	
	while(list($key,$val) = each($links[3]))
	{
		if(!empty($val))
			$match[] = $val;
	}		
	
	return $match;
}

$links=fetchlinks("http://www.hobokenremax.pw/");
print_r($links);


?>