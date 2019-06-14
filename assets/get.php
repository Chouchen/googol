<?php
########################
#                      #
#  ████  ██████ ██████ #
# ██  ██ ██     █ ██ █ #
# ██     ██       ██   #
# ██ ███ █████    ██   #
# ██  ██ ██       ██   #
# ██  ██ ██       ██   #
#  ████  ██████  ████  #
#                      #
########################	

	if (isset($_GET['mod'])){
		define('MODE',strip_tags($_GET['mod']));
	}else{
		define('MODE','web');
	}

	if (isset($_GET['start'])){
		define('START',intval(strip_tags($_GET['start'])));
	}else{
		define('START',0);
	}

	if (!empty($_GET['couleur'])){
		define('COLOR',strip_tags($_GET['couleur']));		
	}else{
		define('COLOR','');
	}
	if (!empty($_GET['taille'])){
		define('SIZE',strip_tags($_GET['taille']));
	}else{
		define('SIZE','');
	}

	if (isset($_GET['q'])){
		handle_bangs($_GET['q']);
		$q_raw=$_GET['q'];
		$q_txt=strip_tags($_GET['q']);
		DEFINE('QUERY_RAW',$q_raw);
		DEFINE('QUERY_SANITIZED',$q_txt);
		$title=$q_txt.' - Googol '.msg('search ');
		$noqueryclass='';
	}else{
		$q_txt=$q_raw='';$title=msg('Googol - google without lies');
		$noqueryclass=' noqueryclass ';
	}

	if (!empty($_GET['next'])){
		# load more button -> ajax load, don't add html page
		render(parsePage($q_raw,START));
		exit();
	}
/*	if (!empty($_GET['getpicfrom'])){
		# extract pic url from the picsearch info page
		preg_match('#href="(.*?)">Full-size image<\/a>#', file_curl_contents(urldecode($_GET['getpicfrom'])),$r);
		if (!empty($r[1])){
			header('location: '.$r[1]);
			exit();
		}
		header('location: '.urldecode($_GET['getpicfrom']));
		exit();
	}
	*/