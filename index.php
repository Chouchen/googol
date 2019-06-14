<?php 
########################################################################################
#                                                                                      #
#    ████████      ████████      ████████      ████████      ████████    ████████      #
#  ████    ████  ████    ████  ████    ████  ████    ████  ████    ████    ████        #
#  ████          ████    ████  ████    ████  ████          ████    ████    ████        #
#  ████  ██████  ████    ████  ████    ████  ████  ██████  ████    ████    ████        #
#  ████    ████  ████    ████  ████    ████  ████    ████  ████    ████    ████        #
#  ████    ████  ████    ████  ████    ████  ████    ████  ████    ████    ████  ████  #
#    ████████      ████████      ████████      ████████      ████████    ████████████  #
#                                                                                      #
########################################################################################

#######################################
#                                     #
#  ████  █   ██ █████  ██████ ██   ██ #
#   ██   ██  ██ ██  ██ ██     ██   ██ #
#   ██   ███ ██ ██  ██ ██      ██ ██  #
#   ██   ██████ ██  ██ █████    ███   #
#   ██   ██ ███ ██  ██ ██      ██ ██  #
#   ██   ██  ██ ██  ██ ██     ██   ██ #
#  ████  ██   █ █████  ██████ ██   ██ #
#                                     #
#######################################
	session_start();
	function lang($default='fr-fr'){
		if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
			return strtolower(strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']));
		}else{return $default;}
	}

	if (isset($_GET['lang'])){$langue=strip_tags($_GET['lang']);}else{$langue=lang();}

	require_once('assets/constants.php');
	require_once('assets/config.php');
	if (is_file('locale/'.LANGUAGE.'.php')){include('locale/'.LANGUAGE.'.php');}

	if (!USE_DISTANT_THUMBS){ 		
		if (!isset($_SESSION['ID'])){$_SESSION['ID']=uniqid();}
		define('UNIQUE_THUMBS_PATH','thumbs/'.$_SESSION['ID']);
		if (!is_dir('thumbs')){mkdir('thumbs');}// crée le dossier thumbs si nécessaire
	}

	$selected_logo_font=glob('assets/fontslogo/*.woff');
	$selected_logo_font=basename($selected_logo_font[array_rand($selected_logo_font)]);
	$selected_logo_fontfamily=trim(preg_replace('#[^a-zA-Z]| #','_',$selected_logo_font));

	clear_cache();// vire les thumbs de plus de trois minutes
	include('assets/get.php');

	#######################################################################################
	#                                                                                     #
	#  ░░░░  ░░░░░░        ░░░░░   ░░░░  ░░  ░░ ░░  ░░  ░░░░   ░░░░  ░░  ░░ ░░░░░░ ░░░░░  #
	#   ░░   ░░            ░░  ░░ ░░  ░░ ░░░ ░░ ░░░ ░░   ░░   ░░   ░ ░░  ░░ ░░     ░░  ░░ #
	#   ░░   ░░░░░         ░░░░░  ░░░░░░ ░░░░░░ ░░░░░░   ░░     ░░   ░░░░░░ ░░░░░  ░░  ░░ #
	#   ░░   ░░            ░░  ░░ ░░  ░░ ░░ ░░░ ░░ ░░░   ░░   ░   ░░ ░░  ░░ ░░     ░░  ░░ #
	#  ░░░░  ░░            ░░░░░  ░░  ░░ ░░  ░░ ░░  ░░  ░░░░   ░░░░  ░░  ░░ ░░░░░░ ░░░░░  #
	#                                                                                     #
	#######################################################################################
	if (!isset($_SESSION['GOOGLE_VED'])){
		$_SESSION['GOOGLE_VED']=getGoogleVed();
	}
	define('VED',$_SESSION['GOOGLE_VED']);
	
	if ($q_raw){
		$google_page=getGooglePage(QUERY_RAW);
		
		if (isBannished($google_page)){
			define('SOURCE','duckduckgo');			
			include('assets/duckduckgo.php');
			$data=getDdgData(START,MODE);
		}else{
			define('SOURCE','google');
			if ($q_raw){
				include('assets/google.php');
				$data=parsePage($google_page);
			}
		}
	}

################################
#                              #
# ██  ██ ██████ █     █ ████   #
# ██  ██ █ ██ █ ██   ██  ██    #
# ██  ██   ██   ███ ███  ██    #
# ██████   ██   ███████  ██    #
# ██  ██   ██   ██ █ ██  ██    #
# ██  ██   ██   ██   ██  ██ ██ #
# ██  ██  ████  ██   ██ ██████ #
#                              #
################################

?>
<!DOCTYPE html>
<html dir="ltr" lang="fr">
<head>
	<title><?php echo $title;?> </title>
	<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="assets/favicon.png" />
	<link rel="stylesheet" type="text/css" href="assets/<?php echo THEME;?>"  media="screen" />
	<link rel="search" type="application/opensearchdescription+xml" title="<?php echo msg('Googol - google without lies'); ?>" href="<?php echo RACINE;?>/googol.xml">
	<style>
		@font-face {
		    font-family: '<?php echo $selected_logo_fontfamily;?>';
		    font-style: normal;
		    font-weight: 400;
		    src: local('<?php echo $selected_logo_fontfamily;?>'), url('assets/fontslogo/<?php echo $selected_logo_font;?>') format('woff');
		}
		header em, .footerlogo em{
			font-family: '<?php echo $selected_logo_fontfamily;?>'!important;
			font-weight: initial;

	}
	</style>
	<!--[if IE]><script> document.createElement("article");document.createElement("aside");document.createElement("section");document.createElement("footer");</script> <![endif]-->
</head>
<body class="<?php echo MODE;?>">
<div id="main" class="main">
	<header>
		<div class="lang">
			<a class="<?php is_active(LANGUAGE,'fr-fr'); ?>" href="?lang=fr-fr">FR</a> 
			<a class="<?php is_active(LANGUAGE,'us-en'); ?>" href="?lang=us-en">EN</a>
		</div>
		<form action="" method="get" >			
				<div class="logo <?php echo $noqueryclass;?>"><a href="<?php echo RACINE;?>"><?php echo LOGO1.LOGO2; ?></a></div>
				<h4 class="subtitle"><?php echo msg('No spy, no lie');?></h4>
				<div class="box">
					<div class="query_form">
						<input type="text" name="q" placeholder="<?php echo msg('Search'); ?>" value="<?php  echo $q_txt; ?>"/>					
						<?php

							if (MODE!=''){echo '<input type="hidden" name="mod" value="'.MODE.'"/>';}
							if (MODE=='images'){
								// ajout des options de recherche d'images
								// couleur
								
								echo '<span class="options"><span class="hidearrow"><select id="color_selection" name="couleur" title="'.msg('Select a color').'">';
								foreach ($config['colors'] as $get=>$color){
									if ($get==COLOR){$sel=' selected ';}else{$sel='';}
									echo '<option value="'.$get.'" class="'.$color.'"'.$sel.'>'.msg($color).'</option>';
								}
								echo '</select></span><span class="hidearrow">';
								unset($colors);
								// tailles
								
								echo '<select id="size_selection" name="taille" title="'.msg('Select a size').'">';
								foreach ($config['sizes'] as $get=>$size){
									if ($get==SIZE){$sel=' selected ';}else{$sel='';}
									echo '<option value="'.$get.'"'.$sel.'>'.$size.'</option>';
								}
								echo '</select></span></span>';
							}

						?>
						<button><img src="assets/loupewhite.svg"/></button>
					</div>
					<nav>
						<?php 
							if (MODE=='web'){echo '<li class="active">Web</li>';}else{echo '<li><a href="?q='.urlencode($q_raw).'&lang='.$langue.'">Web</a></li>';}
							if (MODE=='images'){echo '<li class="active">'.msg('Images').'</li>';}else{echo '<li><a href="?q='.urlencode($q_raw).'&mod=images&lang='.$langue.'">'.msg('Images').'</a></li>';}
							if (MODE=='videos'){echo '<li class="active">'.msg('Videos').'</li>';}else{echo '<li><a href="?q='.urlencode($q_raw).'&mod=videos&lang='.$langue.'">'.msg('Videos').'</a></li>';}
							if (MODE=='news'){echo '<li class="active">'.msg('News').'</li>';}else{echo '<li><a href="?q='.urlencode($q_raw).'&mod=news&lang='.$langue.'">'.msg('News').'</a></li>';}
							alternatesMotors($q_txt);
						?>	
					</nav>	
				</div>	
			<input type="hidden" name="lang" value="<?php echo LANGUAGE;?>"/>

			
		</form>

	</header>
	<div class="msg nomobile <?php echo $noqueryclass;?>">
			<?php 
				if (defined('SOURCE') && SOURCE!='google'){
					echo msg('Google banned this server for a while so we will use duckduckgo instead'); 
					if (MODE!='web'){	echo '<br/>'.msg('The thumbnails are temporarly stored in this server');	} 
					
				}else{
					echo msg('Search anonymously on Google (direct links, fake referer, no ads)'); 
					if (MODE!='web'){	echo '<br/>'.msg('The thumbnails are temporarly stored in this server to hide your ip from Google…');	} 
				}
				
			?> 
		</div>
	<aside class="<?php echo $noqueryclass.' '.MODE.' '.SOURCE;?>" id="list">
		<?php if (!empty($data)){render($data);}elseif ($q_raw){echo '<div class="box error dialog">'.msg('no results for').' '.QUERY_RAW.'</div>';} ?>
	</aside>
	<footer>
		<span class="version"> <?php echo return_safe_search_level(); ?> </span>
			
			<span class="nomobile infos">
				<a href="<?php echo RACINE;?>">Googol <?php echo strip_tags(VERSION);?></a> <?php echo msg('by');?> 
				<a href="http://warriordudimanche.net">Bronco - warriordudimanche.net</a> 
				<a href="https://github.com/broncowdd/googol" title="<?php echo msg('on GitHub');?>" class=" wot-exclude "> GitHub </a>
			</span>
	</footer>
	<?php if(USE_WEB_OF_TRUST){echo '<script type="text/javascript" src="http://api.mywot.com/widgets/ratings.js"></script>';}?> 
		<script language="javascript"> 
			list=document.getElementById('list');
			function get(url){	
				request = new XMLHttpRequest();
				request.open('GET', url, false);
				request.send();
				
				if (request.readyState==4 && request.status==200){return request.responseText;}					
				
			}
			function change_class(classe) { 
				var btn = document.getElementById("color_selection"); 
				btn.className= classe; 
			} 
			function load_more(obj,start){		
				obj.innerHTML="<?php echo msg('loading...');?>";
				if (start==1){start++;}
				more=get("<?php 
					$lacouleur=$lataille='';
					if (!empty($couleur)){$lacouleur='&couleur='.$couleur;}
					if (!empty($taille)){$lataille='&taille='.$taille;}
					echo RACINE.'?q='.$q_raw.'&next=true&mod=images'.$lacouleur.$lataille.'&start=';

				?>"+start);
				obj.parentNode.removeChild(obj);
				content=list.innerHTML;
				list.innerHTML=content+more;
			}
			iframe=document.querySelectorAll('body.images>div[style]')[0];
			if (iframe){iframe.style='display:none;';}
		</script>
	</div>
</body>
</html>
<?php add_search_engine(); ?>
