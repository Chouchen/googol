<?php

namespace Googol;

class Utils
{
    public static $config;

    /**
     * @param       $m
     * @param array $lang
     *
     * @return mixed
     */
    public static function msg($m, $lang = [])
    {
        if (isset($lang[$m])) {
            return $lang[$m];
        }

        return $m;
    }

    /**
     * @param string $default
     *
     * @return string
     */
    public static function lang($default='fr-fr')
    {
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return strtolower(strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']));
        }

        return $default;
    }

    /**
     * @return bool
     */
    public static function protocolIsHTTPS()
    {
        return (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) === 'on') ?
            true :
            (!empty($_SERVER['HTTP_SSL']) && strtolower($_SERVER['HTTP_SSL']) === 'on');
    }

    /**
     * @param      $site
     * @param bool $reset
     *
     * @return bool
     */
    public static function checkSite(&$site, $reset = true)
    {
        $site = preg_replace('#([\'"].*)#', '', $site);
        # Méthode Jeffrey Friedl - http://mathiasbynens.be/demo/url-regex
        # modifiée par Amaury Graillat pour prendre en compte la valeur localhost dans l'url
        if (preg_match('@\b((ftp|https?)://([-\w]+(\.\w[-\w]*)+|localhost)|(?:[a-z0-9](?:[-a-z0-9]*[a-z0-9])?\.)+(?: com\b|edu\b|biz\b|gov\b|in(?:t|fo)\b|mil\b|net\b|org\b|[a-z][a-z]\b))(\:\d+)?(/[^.!,?;"\'<>()\[\]{}\s\x7F-\xFF]*(?:[.!,?]+[^.!,?;"\'<>()\[\]{}\s\x7F-\xFF]+)*)?@iS', $site)) {
            return true;
        }

        if ($reset) {
            $site='';
        }

        return false;
    }

    /**
     * @param bool $truncate
     *
     * @return bool|mixed|string
     */
    public static function getRacine($truncate = false)
    {
        $protocol = self::protocolIsHTTPS() ? 'https://' : 'http://';
        $servername = $_SERVER['HTTP_HOST'];
        $serverport = (preg_match('/:\d+/', $servername) OR $_SERVER['SERVER_PORT']) === '80' ? '' : ':'.$_SERVER['SERVER_PORT'];
        $dirname = preg_replace('/\/(core|plugins)\/(.*)/', '', dirname($_SERVER['SCRIPT_NAME']));
        $racine = rtrim($protocol.$servername.$serverport.$dirname, '/').'/';
        $racine = str_replace(array('webroot/','install/'), '', $racine);
        if (!self::checkSite($racine, false)) {
            die('Error: wrong or invalid url');
        }
        if ($truncate) {
            $root = substr($racine,strpos($racine, '://')+3,strpos($racine,basename($racine))+4);
            $racine = substr($root,strpos($root,'/'));
        }

        return $racine;
    }

    /**
     * @param $first
     * @param $second
     */
    public static function is_active($first, $second)
    {
        echo $first === $second ? 'active' : '';
    }

    /**
     * @return array
     */
    public static function getConfig()
    {
        if (null !== self::$config) {
            return self::$config;
        }

        self::$config = include CONFIG_FILE;

        return self::$config;
    }

    /**
     * @param string $query
     */
    public static function alternatesMotors($query)
    {
        foreach (self::getConfig()['alternatives'] as $name => $url) {
            echo '<li class="alternate"><a class="alternate_searchengine" href="'.$url.$query.'" title="'.self::msg('Redirect to').' '.$name.'">'.$name.'</a></li>';
        }
    }

    /**
     * @param string $q
     */
    public static function handle_bangs($q)
    {
        foreach (self::getConfig()['bangs'] as $bang=>$url) {
            if (stripos($q, strtolower($bang)) === 0) {
                header('location: '.$url.str_replace($bang,'',$q));
                exit();
            }
        }
    }

    /**
     * @return string
     */
    public static function return_safe_search_level()
    {
        if (SAFESEARCH_LEVEL === SAFESEARCH_ON) {
            return '<b class="ss_on">'.Utils::msg('Filter on').'</b>';
        }
        if (SAFESEARCH_LEVEL === SAFESEARCH_OFF) {
            return '<b class="ss_off">'.Utils::msg('Filter off').'</b>';
        }
        if (SAFESEARCH_LEVEL === SAFESEARCH_IMAGESONLY) {
            return '<b class="ss_images">'.Utils::msg('Filter images only').'</b>';
        }

        return '';
    }

    public static function add_search_engine()
    {
        if (!is_file('googol.xml')) {
            file_put_contents('googol.xml', '<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/"
			  xmlns:moz="http://www.mozilla.org/2006/browser/search/">
			  <ShortName>Googol</ShortName>
			  <Description>'.Utils::msg('Googol - google without lies').'</Description>
			  <InputEncoding>UTF-8</InputEncoding>
			  <Image width="32" height="32">data:image/png;base64,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</Image>
			  <Url type="text/html" method="get" template="'.RACINE.'">
			  <Param name="q" value="{searchTerms}"/>
			  </Url>
			  <moz:SearchForm>'.RACINE.'</moz:SearchForm> 
			</OpenSearchDescription>');
        }
    }
}
