<?php 
	
##################################################################
#                                                                #
#  ████   ████  █   ██  ████  ██████  ████  █   ██ ██████  ████  #
# ██  ██ ██  ██ ██  ██ ██  ██ █ ██ █ ██  ██ ██  ██ █ ██ █ ██  ██ #
# ██     ██  ██ ███ ██  ██      ██   ██  ██ ███ ██   ██    ██    #
# ██     ██  ██ ██████   ██     ██   ██████ ██████   ██     ██   #
# ██     ██  ██ ██ ███    ██    ██   ██  ██ ██ ███   ██      ██  #
# ██  ██ ██  ██ ██  ██ ██  ██   ██   ██  ██ ██  ██   ██   ██  ██ #
#  ████   ████  ██   █  ████   ████  ██  ██ ██   █  ████   ████  #
#                                                                #
##################################################################
#############################################
#                                           #
#  ▒▒▒▒   ▒▒▒▒  ▒▒  ▒▒ ▒▒▒▒▒▒  ▒▒▒▒   ▒▒▒▒  #
# ▒▒  ▒▒ ▒▒  ▒▒ ▒▒▒ ▒▒ ▒▒       ▒▒   ▒▒     #
# ▒▒     ▒▒  ▒▒ ▒▒▒▒▒▒ ▒▒▒▒▒    ▒▒   ▒▒ ▒▒▒ #
# ▒▒  ▒▒ ▒▒  ▒▒ ▒▒ ▒▒▒ ▒▒       ▒▒   ▒▒  ▒▒ #
#  ▒▒▒▒   ▒▒▒▒  ▒▒  ▒▒ ▒▒      ▒▒▒▒   ▒▒▒▒  #
#                                           #
#############################################
    use Googol\Utils;

    define('OFFLINE', false); # for local testing only (don't touch)
	define('DEBUG', false); 	 # for debugging only (don't touch)
    define('LANGUAGE', isset($_GET['lang']) ? strip_tags($_GET['lang']) : Utils::lang());
	define('VERSION', 'v3.0a');
	define('USE_DISTANT_THUMBS', false);
	define('THEME', 'style_google.css');
	define('PAUSE_DURATION', 60); // minutes
	define('CONFIG_FILE', __DIR__.'/config.php'); // minutes
	define('RACINE', Utils::getRacine());
	define('USE_WEB_OF_TRUST', false);

################################
#                              #
# ▒     ▒  ▒▒▒▒   ▒▒▒▒   ▒▒▒▒  #
# ▒▒   ▒▒   ▒▒   ▒▒   ▒ ▒▒  ▒▒ #
# ▒▒▒ ▒▒▒   ▒▒     ▒▒   ▒▒     #
# ▒▒ ▒ ▒▒   ▒▒   ▒   ▒▒ ▒▒  ▒▒ #
# ▒▒   ▒▒  ▒▒▒▒   ▒▒▒▒   ▒▒▒▒  #
#                              #
################################
	define('MYURL', Utils::getRacine());
	define('LOGO1', '<em class="G">G</em><em class="o1">o</em>');
	define('LOGO2', '<em class="o2">o</em><em class="g">g</em><em class="o1">o</em><em class="l">l</em>');
	define('CAPCHA_DETECT', '<div id="recaptcha" class="g-recaptcha" data-sitekey=');
	define('SAFESEARCH_ON', '&safe=on');
	define('SAFESEARCH_IMAGESONLY', '&safe=images');
	define('SAFESEARCH_OFF', '&safe=off');
	define('SAFESEARCH_LEVEL', SAFESEARCH_OFF);// SAFESEARCH_ON, SAFESEARCH_IMAGESONLY, SAFESEARCH_OFF

########################
#                      #
# ▒▒  ▒▒ ▒▒▒▒▒  ▒▒▒▒   #
# ▒▒  ▒▒ ▒▒  ▒▒  ▒▒    #
# ▒▒  ▒▒ ▒▒▒▒▒   ▒▒    #
# ▒▒  ▒▒ ▒▒  ▒▒  ▒▒ ▒▒ #
#  ▒▒▒▒  ▒▒  ▒▒ ▒▒▒▒▒▒ #
#                      #
########################
	define('WOT_URL', 'http://www.mywot.com/scorecard/');
	define('GOOGLE_ROOT', 'https://www.google.com/search');

	define('GOOGLE_WEB', '?hl='.LANGUAGE.SAFESEARCH_LEVEL.'&source=lnms&id=hp&q=');
	define('GOOGLE_IMG', '?hl='.LANGUAGE.SAFESEARCH_LEVEL.'&source=lnms&tbm=isch&q=');
	define('GOOGLE_NEW', '?hl='.LANGUAGE.SAFESEARCH_LEVEL.'&source=lnms&tbm=nws&q=');
	define('GOOGLE_VID', '?hl='.LANGUAGE.SAFESEARCH_LEVEL.'&source=lnms&tbm=vid&q=');
	define('GOOGLE_MAP', 'https://www.google.fr/maps/place');
//https://www.google.com/search?q=test&safe=off&hl=fr-fr&source=lnms&tbm=isch&sa=X&ved=0ahUKEwjf5KH14fveAhUC1RoKHfEiAqQQ_AUIECgD