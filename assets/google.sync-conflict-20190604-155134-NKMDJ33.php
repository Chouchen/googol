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
	'images'=>'<div class="image"><div><a rel="noreferrer" href="#link" title="#link">#thumbs</a></div><div class="description">#W x #H<a class="source" href="#url" title="#url"> #site</a></div></div>',
	//'images'=>'<div class="image"><a rel="noreferrer" href="#image" title="#link">#thumbnail</a><div class="description">#width x #height<a class="source" href="#url" title="#title"> #url</a></div></div>',
	'videos'=>'<div class="video" ><h3><a rel="noreferrer" href="#link" title="#link">#titre</a></h3><a class="thumb" rel="noreferrer" href="#link" title="#link">#thumbs</a><p class="site">#site</p><p class="description">#description</p></div>',
	'news'=>'<li class="result"><a rel="noreferrer" href="#link"><h3 class="title">#title</h3>#higlightedlink</a>#wot<p class="description">#description</p></li>',
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
	'news'=>'#href="/url\?q=(?P<url>[^^]*?)&sa=U&ved=[^^]*?">(?P<title>[^^]*?)<\/a>[^^]*?<span class="st">(?<description>[^^]*?)<\/span#s',
	'vid'=>'#(?:<img.*?src="([^"]+)".*?width="([0-9]+)".*?)?<h3 class="r">[^<]*<a href="/url\?q=(.*?)(?:&|&).*?">(.*?)</a>.*?<cite[^>]*>(.*?)</cite>.*?<span class="(?:st|f)">(.*?)(?:</span></td>|</span><br></?div>)#',
	'vidthmbs'=>'#<img.*?src="([^"]+)".*?width="([0-9]+)"#',
	//'img'=>'#imgurl=(?P<imgurl>.*?)&amp;imgrefurl=(?P<srcurl>.*?)&amp;h=(?P<h>[0-9]+).*?w=(?P<w>[0-9]+).*?"id":"(?P<id>.*?)".*?"isu":"(?P<site>.*?)".*?"ity":"(?P<type>.*?)".*?"th":(?P<th>[0-9]+).*?"tu":"(?P<thmbsrc>.*?)".*?"tw":(?P<tw>[0-9]+)#',//LOCALREGEX 
	'img'=>'#\/url\?q=(?<site>[^^]*?)sa=[^^]*?height="(?<h>[0-9]+)[^^]*?src="(?<thmbsrc>[^"]+)[^^]*?width="(?<w>[0-9]+)[^^]*?<\/a>(?<info>[^^]*?)<\/td>#',//LOCALREGEX 
	//'img'=>'#style="background:(?P<color>rgb\([0-9]{1,3},[0-9]{1,3},[0-9]{1,3}\))".*?"id":"(?P<id>.*?)".*?"isu":"(?P<site>.*?)".*?"ity":"(?P<type>.*?)".*?"oh":(?P<h>[0-9]+).*?"ou":"(?P<imgurl>.*?)".*?"ow":(?P<w>[0-9]+).*?"ru":"(?P<srcurl>.*?)".*?"st":"(?P<desc>.*?)".*?"th":(?P<th>[0-9]+).*?"tu":"(?P<thmbsrc>.*?)".*?"tw":(?P<tw>[0-9]+)#',//SERVERREGEX 
	'dataimg'=>'#\["(?P<id>.*?)","data:image\/jpeg;base64(?P<dataimg>.*?)"\]#',
	'pages'=>'#&start=([0-9]+)|&start=([0-9]+)#',
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
		$page=preg_replace('#<!doctype html>|<html[^^]+?-->|<head>[^^]+?<\/head>|<body[^^]+?<div id="main">|<style>[^^]+?<\/style>|<script[^µ]+?<\/script>|<footer>[^µ]+?<\/body>#','',$page);
		file_put_contents('_last_downloaded_page.html',$page);		

		if (MODE=='web'){ 
			preg_match_all($config['regex']['web'], $page, $data);
			//preg_match_all($config['regex']['pages'],$page,$p);
			$retour=array(
				'link'=>$data['link'],
				'title'=>array_map('strip_tags',$data['title']),
				'description'=>array_map('strip_tags',$data['description']),
				'nb_pages'=>'NBPAGES',# !!!!!!!!!!!!!!!!!!!!!!!,
				'current_page'=>START,
				'query'=>QUERY_RAW,
				'mode'=>MODE
				);
		}elseif (MODE=='news'){ 
			preg_match_all($config['regex']['news'],$page,$r);
			preg_match_all($config['regex']['pages'],$page,$p);
			$p=count($p[2]);
			$retour=array(
				'title'=>array_map('strip_tags',$r['title']),
				'description'=>array_map('strip_tags',$r['description']),
				'link'=>array_map('strip_tags',$r['url']),
				'current_page'=>START,
				'nb_pages'=>$p,
				'query'=>QUERY_RAW,
				'mode'=>MODE
			);
		}elseif (MODE=='images'){
			/*
			$page=str_ireplace(
				array('\u003c','\u003e','\u003d','u003c','u003e','u003d'),
				array('<','>','=','<','>','='),
				stripslashes($page)
			);
	*/
			preg_match_all($config['regex']['img'],$page,$r);
			$results=array();

			foreach($r[2] as $key=>$item){					
				$results[$key]['urlimg']=$r['imgurl'][$key];				
				$results[$key]['urlpage']=$r['srcurl'][$key];
				$results[$key]['imgfilename']=basename($r['imgurl'][$key]);
				$results[$key]['h']=$r['h'][$key];
				$results[$key]['w']=$r['w'][$key];
				$results[$key]['th']=$r['th'][$key];
				$results[$key]['tw']=$r['tw'][$key];
				$results[$key]['id']=$r['id'][$key];
				$results[$key]['site']=$r['site'][$key];
				if (!empty($data[$results[$key]['id']])){
					$results[$key]['datatbm']=$data[$results[$key]['id']];
				}else{
					$results[$key]['urltmb']=$r['thmbsrc'][$key];
				}
				
			}
			unset($r);
			$retour=array();$key=0;
			foreach ($results as $id=>$result){				
				foreach($result as $k=>$r){
					$retour[$k][$key]=$result[$k];
				}				
				$retour['id'][$key]=$id;
				$key++;
			}
			$retour['query']=QUERY_RAW;
			$retour['mode']=MODE;
		}elseif(MODE=="videos"){			
			preg_match_all($config['regex']['vid'],$page,$r);
			preg_match_all($config['regex']['pages'],$page,$p);
			$p=count($p[2]);
			$retour=array(
				'site'=>$r[5],
				'titre'=>$r[4],
				'links'=>array_map('urldecode', $r[3]),
				'description'=>$r[6],
				'thumbs'=>$r[1],
				'thumbs_w'=>$r[2],
				'nb_pages'=>$p,
				'current_page'=>START,
				'query'=>QUERY_RAW,
				'mode'=>MODE
			);
		}




		if (!empty($retour['link'])){
			foreach ($retour as $type => $items) {
				if (is_array($items)){
					foreach ($items as $nb => $data) {
						$arranged_array[$nb][$type]=$data;
					}
				}
			}

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
		if (!empty($item['link'])){
			$item['higlightedlink']=highlight(QUERY_SANITIZED,urldecode($item['link']));		
		}
		
		$item['wot']='<a class="wot-exclude wot" href="'.WOT_URL.$item['link'].'" title="View scorecard"> </a>';

		$keys=array_map(function($k){return '#'.$k;}, array_keys($item));
//aff($keys,$item,$config['tpl']);
		echo str_replace($keys, 
			array_values($item), 
			$config['tpl'][MODE]);
	}
	echo '</ul>';
}