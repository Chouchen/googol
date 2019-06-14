<?php
########################################################################################
#                                                                                      #
#    ████████      ████████      ████████      ████████    ████████      ████████████  #
#  ████    ████  ████    ████  ████    ████  ████    ████    ████        ████          #
#  ████          ████    ████  ████    ████  ████            ████        ████          #
#  ████  ██████  ████    ████  ████    ████  ████  ██████    ████        ██████████    #
#  ████    ████  ████    ████  ████    ████  ████    ████    ████        ████          #
#  ████    ████  ████    ████  ████    ████  ████    ████    ████  ████  ████          #
#    ████████      ████████      ████████      ████████    ████████████  ████████████  #
#                                                                                      #
########################################################################################

$config['tpl']=array(
	'web'=>'<li class="result"><a rel="noreferrer" href="#link"><h3 class="title">#title</h3>#higlightedlink</a>#wot<p class="description">#description</p></li>',
	'images'=>'<a class="image" style="background-image:url(#thumbnail)" rel="noreferrer" href="#link" title="#link"><div class="description">#description</div></a>',
	//'images'=>'<div class="image"><a rel="noreferrer" href="#image" title="#link">#thumbnail</a><div class="description">#width x #height<a class="source" href="#url" title="#title"> #url</a></div></div>',
	'videos'=>'<div class="video box cols200-1fr" data-w="#w"><a class="thumb" rel="noreferrer" href="#link" title="#link"><img src="#thumbnail"/></a><div><h3>#titre</h3><p class="site">#site</p><p class="description">#description</p></div></div>',
	'news'=>'<div class="result box cols200-1fr"><a rel="noreferrer" href="#link"><img src="#thumbnail"/></a><div><a rel="noreferrer" href="#link"><h3 class="title">#title</h3>#higlightedlink</a>#wot<p class="description">#description</p></div></div>',
);

$config['colors']=array(		
		''=>msg('Color'),
		'ic:trans'=>'Transparent',
		'ic:gray'=>msg('Black_and_white'),
		'ic:color'=>msg('Color'),
		'ic:specific,isc:red'=>'red',
		'ic:specific,isc:orange'=>'orange',
		'ic:specific,isc:yellow'=>'yellow',
		'ic:specific,isc:pink'=>'pink',
		'ic:specific,isc:white'=>'white',
		'ic:specific,isc:gray'=>'gray',
		'ic:specific,isc:black'=>'black',
		'ic:specific,isc:brown'=>'brown',
		'ic:specific,isc:green'=>'green',
		'ic:specific,isc:teal'=>'teal',
		'ic:specific,isc:blue'=>'blue',
	);
$config['sizes']=array(
		''=>msg('size'),
		'isz:l'=>msg('Big'),
		'isz:m'=>msg('Medium'),
		'isz:i'=>msg('Icon'),
		'isz:lt,islt:vga'=>'>  640x 480',
		'isz:lt,islt:svga'=>'>  800x 600',
		'isz:lt,islt:xga'=>'> 1024x 768',
		'isz:lt,islt:2mp'=>'> 1600x1200 2mpx',
		'isz:lt,islt:4mp'=>'> 2272x1704 4mpx',
		'isz:lt,islt:6mp'=>'> 2816x2112 6mpx',
		'isz:lt,islt:8mp'=>'> 3264x2448 8mpx',
		'isz:lt,islt:10mp'=>'> 3648x2736 10mpx',
		'isz:lt,islt:12mp'=>'> 4096x3072 12mpx',
		'isz:lt,islt:15mp'=>'> 4480x3360 15mpx',
		'isz:lt,islt:20mp'=>'> 5120x3840 20mpx',
		'isz:lt,islt:40mp'=>'> 7216x5412 40mpx',
		'isz:lt,islt:70mp'=>'> 9600x7200 70mpx',
);


$config['regex']=array(
	/*
	'web'=>'#(?<=<h3 class="r"><a href="/url\?q=)([^&]+).*?>(.*?)</a>.*?(?<=<span class="st">)(.*?)(?=</span>)#s',
	*/
	'web'=>'#href="\/url\?q=(?<link>[^"]+)&sa=[^^]*?<div[^>]+>(?<title>[^^]*?)<\/div>[^^]*?<div[^>]+>(?<soustitre>[^^]*?)<\/div>[^^]+?<div[^>]+>(?<description>[^^]*?)\.\.\.[^^]*?<\/div>#s',
	'news'=>'#\/url\?q=(?<link>[^"]*?)&[^^]*?>(?<title>[^^]*?)<\/a>[^^]*?<span class="f">(?<date>[^^]*?)<\/span>[^^]*?<div class="st">(?<description>[^^]*?)<\/div>[^^]*?src="(?<thumbnail>[^"]*?)"#s',
	/*'vid'=>'#(?:<img.*?src="([^"]+)".*?width="([0-9]+)".*?)?<h3 class="r">[^<]*<a href="/url\?q=(.*?)(?:&|&).*?">(.*?)</a>.*?<cite[^>]*>(.*?)</cite>.*?<span class="(?:st|f)">(.*?)(?:</span></td>|</span><br></?div>)#',*/
	'vid'=>'#\/url\?q=(?<link>[^"]*?)&sa[^^]*?>(?<title>[^^]*?)<\/a>[^^]*?<span class="f">(?<description>[^^]*?)<\/span><\/td>#',
	'vidthmbs'=>'#<img.*?src="([^"]+)".*?width="([0-9]+)"#',
	//'img'=>'#imgurl=(?P<imgurl>.*?)&amp;imgrefurl=(?P<srcurl>.*?)&amp;h=(?P<h>[0-9]+).*?w=(?P<w>[0-9]+).*?"id":"(?P<id>.*?)".*?"isu":"(?P<site>.*?)".*?"ity":"(?P<type>.*?)".*?"th":(?P<th>[0-9]+).*?"tu":"(?P<thmbsrc>.*?)".*?"tw":(?P<tw>[0-9]+)#',//LOCALREGEX 
	'img'=>'#\/url\?q=(?<link>[^"]*?)&sa=[^^]*?height="(?<h>[0-9]*?)" src="(?<thumbnail>[^"]*?)" width="(?<w>[0-9]*?)"[^^]*?(?<info>[0-9]+ × [0-9]+ - [0-9]+.*?)<\/td>#',//LOCALREGEX 
	//'img'=>'#style="background:(?P<color>rgb\([0-9]{1,3},[0-9]{1,3},[0-9]{1,3}\))".*?"id":"(?P<id>.*?)".*?"isu":"(?P<site>.*?)".*?"ity":"(?P<type>.*?)".*?"oh":(?P<h>[0-9]+).*?"ou":"(?P<imgurl>.*?)".*?"ow":(?P<w>[0-9]+).*?"ru":"(?P<srcurl>.*?)".*?"st":"(?P<desc>.*?)".*?"th":(?P<th>[0-9]+).*?"tu":"(?P<thmbsrc>.*?)".*?"tw":(?P<tw>[0-9]+)#',//SERVERREGEX 
	'dataimg'=>'#\["(?P<id>.*?)","data:image\/jpeg;base64(?P<dataimg>.*?)"\]#',
	'pages'=>'#&start=([0-9]+)#',
);


	if (COLOR&&SIZE){
		define('FILTER',COLOR.'&'.SIZE);
	}elseif (COLOR){
		define('FILTER',COLOR);
	}elseif (SIZE){
		define('FILTER',SIZE);
	}else{
		define('FILTER','');
	}





################################################################################
#                                                                              #
# █████   ████  █████   ████  ██████         ████  ██  ██ ██████ █████  ██  ██ #
# ██  ██ ██  ██ ██  ██ ██  ██ ██            ██  ██ ██  ██ ██     ██  ██ ██  ██ #
# ██  ██ ██  ██ ██  ██  ██    ██            ██  ██ ██  ██ ██     ██  ██ ██  ██ #
# █████  ██████ █████    ██   █████         ██  ██ ██  ██ █████  █████   ████  #
# ██     ██  ██ ██  ██    ██  ██            ██ ██  ██  ██ ██     ██  ██   ██   #
# ██     ██  ██ ██  ██ ██  ██ ██            ██  ██ ██  ██ ██     ██  ██   ██   #
# ██     ██  ██ ██  ██  ████  ██████         ███ █  ████  ██████ ██  ██   ██   #
#                                                                              #
################################################################################

	function parsePage($page){
		global $config;
		if (OFFLINE){
			$page=file_get_contents(MODE.'_last_downloaded_page.html');
		}else{
			$page=preg_replace('#<!doctype html>|<html[^^]+?-->|<head>[^^]+?<\/head>|<body[^^]+?<div id="main">|<style>[^^]+?<\/style>|<script[^µ]+?<\/script>|<footer>[^µ]+?<\/body>#','',$page);
			if (DEBUG){file_put_contents(MODE.'_last_downloaded_page.html',$page);}
		}
			

		if (MODE=='web'){ 
			preg_match_all($config['regex']['web'], $page, $data);
			//preg_match_all($config['regex']['pages'],$page,$p);
			$retour=array(
				'link'=>$data['link'],
				'title'=>array_map('strip_tags',$data['title']),
				'description'=>array_map('strip_tags',$data['description']),
				'nb_pages'=>false,
				'current_page'=>START,
				'query'=>QUERY_RAW,
				'mode'=>MODE
				);
			$pages=false;
		}elseif (MODE=='news'){ 
			preg_match_all($config['regex']['news'],$page,$r);
			preg_match_all($config['regex']['pages'],$page,$p);
			$p=count($p[0]);
			$retour=array(
				'title'=>array_map('strip_tags',$r['title']),
				'description'=>array_map('strip_tags',$r['description']),
				'link'=>array_map('strip_tags',$r['link']),
				'thumbnail'=>$r['thumbnail'],
				'current_page'=>START,
				'nb_pages'=>$p,
				'query'=>QUERY_RAW,
				'mode'=>MODE
			);
			$pages=false;
		}elseif (MODE=='images'){
			preg_match_all($config['regex']['img'],$page,$r);
			//preg_match_all($config['regex']['pages'],$page,$p);
			$retour		=array(
				'urlimg'=>$r['link'],		
				'urlpage'=>$r['link'],
				'imgfilename'=>array_map('basename',$r['link']),
				'h'=>$r['h'],
				'w'=>$r['w'],
				'link'=>$r['link'],
				'thumbnail'=>$r['thumbnail'],
				'description'=>array_map('strip_tags',$r['info']),
				
			);
			$pages=false;
			//$pages=$p[1];
			unset($r);

		}elseif(MODE=="videos"){			
			preg_match_all($config['regex']['vid'],$page,$r);
			preg_match_all($config['regex']['vidthmbs'],$page,$t);
			preg_match_all($config['regex']['pages'],$page,$p);

			$p=count($p[0]);
			$retour=array(
				'site'=>$r['link'],
				'titre'=>array_map('strip_tags', $r['title']),
				'link'=>array_map('urldecode', $r['link']),
				'description'=>array_map('strip_tags', $r['description']),
				'thumbnail'=>$t[1],
				'w'=>$t[2],
				'nb_pages'=>$p-1,
				'current_page'=>START,
				'query'=>QUERY_RAW,
				'mode'=>MODE
			);
			$pages=false;
		}

		if (!empty($retour['link'])){
			foreach ($retour as $type => $items) {
				if (is_array($items)){
					foreach ($items as $nb => $data) {
						$arranged_array[$nb][$type]=$data;
					}
				}
			}
			$arranged_array['pages']=$pages;
			return $arranged_array;	
		}
		return false;
	}

#######################################################################################
#                                                                                     #
# █████  ██████ █   ██ █████  ██████ █████          ████  ██  ██ ██████ █████  ██  ██ #
# ██  ██ ██     ██  ██ ██  ██ ██     ██  ██        ██  ██ ██  ██ ██     ██  ██ ██  ██ #
# ██  ██ ██     ███ ██ ██  ██ ██     ██  ██        ██  ██ ██  ██ ██     ██  ██ ██  ██ #
# █████  █████  ██████ ██  ██ █████  █████         ██  ██ ██  ██ █████  █████   ████  #
# ██  ██ ██     ██ ███ ██  ██ ██     ██  ██        ██ ██  ██  ██ ██     ██  ██   ██   #
# ██  ██ ██     ██  ██ ██  ██ ██     ██  ██        ██  ██ ██  ██ ██     ██  ██   ██   #
# ██  ██ ██████ ██   █ █████  ██████ ██  ██         ███ █  ████  ██████ ██  ██   ██   #
#                                                                                     #
#######################################################################################

function render($data){
	global $config;
	if (!$data){ return;}
	echo '<ul start="'.START.'">';
	foreach ($data as $key => $item) {
		if (!empty($item['link'])){
			//$tpl_i=(string)$config['tpl'][MODE];	
			if (!empty($item['thumbnail'])){
				$item['thumbnail']=grab_thumbs($item['thumbnail']);
			}		
			if (!empty($item['description'])){
				$item['description']=highlight(QUERY_SANITIZED,$item['description']);
			}
			if (!empty($item['title'])){
				$item['title']=highlight(QUERY_SANITIZED,$item['title']);		
			}
		
			$item['higlightedlink']=highlight(QUERY_SANITIZED,urldecode($item['link']));		
			$item['wot']='<a class="wot-exclude wot" href="'.WOT_URL.$item['link'].'" title="View scorecard"> </a>';
			$keys=array_map(function($k){return '#'.$k;}, array_keys($item));

			echo str_replace($keys, 
				array_values($item), 
				$config['tpl'][MODE]);
		}		
		
		
	}
	echo '</ul>';
	pagination($data['pages']);

}