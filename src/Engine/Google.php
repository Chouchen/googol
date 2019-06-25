<?php

namespace Googol\Engine;

use DOMDocument;
use DOMXPath;
use Googol\Engine;
use Googol\Utils;

class Google extends Engine
{
    public static $templates = [
        'web'    => '<li class="result"><a rel="noreferrer" href="#link"><h3 class="title">#title</h3>#higlightedlink</a>#wot<p class="description">#description</p></li>',
        'images' => '<a class="image" style="background-image:url(#thumbnail)" rel="noreferrer" href="#link" title="#link"><div class="description">#description</div></a>',
        //'images'=>'<div class="image"><a rel="noreferrer" href="#image" title="#link">#thumbnail</a><div class="description">#width x #height<a class="source" href="#url" title="#title"> #url</a></div></div>',
        'videos' => '<div class="video box cols200-1fr" data-w="#w"><a class="thumb" rel="noreferrer" href="#link" title="#link"><img src="#thumbnail"/></a><div><h3>#titre</h3><p class="site">#site</p><p class="description">#description</p></div></div>',
        'news'   => '<div class="result box cols200-1fr"><a rel="noreferrer" href="#link"><img src="#thumbnail"/></a><div><a rel="noreferrer" href="#link"><h3 class="title">#title</h3>#higlightedlink</a>#wot<p class="description">#description</p></div></div>',
    ];

    public static $regexes = [
        /*
	'web'=>'#(?<=<h3 class="r"><a href="/url\?q=)([^&]+).*?>(.*?)</a>.*?(?<=<span class="st">)(.*?)(?=</span>)#s',
	*/
        'web'      => '#href="\/url\?q=(?<link>[^"]+)&sa=[^^]*?<div[^>]+>(?<title>[^^]*?)<\/div>[^^]*?<div[^>]+>(?<soustitre>[^^]*?)<\/div>[^^]+?<div[^>]+>(?<description>[^^]*?)\.\.\.[^^]*?<\/div>#s',
        'news'     => '#\/url\?q=(?<link>[^"]*?)&[^^]*?>(?<title>[^^]*?)<\/a>[^^]*?<span class="f">(?<date>[^^]*?)<\/span>[^^]*?<div class="st">(?<description>[^^]*?)<\/div>[^^]*?src="(?<thumbnail>[^"]*?)"#s',
        /*'vid'=>'#(?:<img.*?src="([^"]+)".*?width="([0-9]+)".*?)?<h3 class="r">[^<]*<a href="/url\?q=(.*?)(?:&|&).*?">(.*?)</a>.*?<cite[^>]*>(.*?)</cite>.*?<span class="(?:st|f)">(.*?)(?:</span></td>|</span><br></?div>)#',*/
        'vid'      => '#\/url\?q=(?<link>[^"]*?)&sa[^^]*?>(?<title>[^^]*?)<\/a>[^^]*?<span class="f">(?<description>[^^]*?)<\/span><\/td>#',
        'vidthmbs' => '#<img.*?src="([^"]+)".*?width="([0-9]+)"#',
        //'img'=>'#imgurl=(?P<imgurl>.*?)&amp;imgrefurl=(?P<srcurl>.*?)&amp;h=(?P<h>[0-9]+).*?w=(?P<w>[0-9]+).*?"id":"(?P<id>.*?)".*?"isu":"(?P<site>.*?)".*?"ity":"(?P<type>.*?)".*?"th":(?P<th>[0-9]+).*?"tu":"(?P<thmbsrc>.*?)".*?"tw":(?P<tw>[0-9]+)#',//LOCALREGEX
        'img'      => '#\/url\?q=(?<link>[^"]*?)&sa=[^^]*?height="(?<h>[0-9]*?)" src="(?<thumbnail>[^"]*?)" width="(?<w>[0-9]*?)"[^^]*?(?<info>[0-9]+ × [0-9]+ - [0-9]+.*?)<\/td>#',//LOCALREGEX
        //'img'=>'#style="background:(?P<color>rgb\([0-9]{1,3},[0-9]{1,3},[0-9]{1,3}\))".*?"id":"(?P<id>.*?)".*?"isu":"(?P<site>.*?)".*?"ity":"(?P<type>.*?)".*?"oh":(?P<h>[0-9]+).*?"ou":"(?P<imgurl>.*?)".*?"ow":(?P<w>[0-9]+).*?"ru":"(?P<srcurl>.*?)".*?"st":"(?P<desc>.*?)".*?"th":(?P<th>[0-9]+).*?"tu":"(?P<thmbsrc>.*?)".*?"tw":(?P<tw>[0-9]+)#',//SERVERREGEX
        'dataimg'  => '#\["(?P<id>.*?)","data:image\/jpeg;base64(?P<dataimg>.*?)"\]#',
        'pages'    => '#&start=([0-9]+)#',
    ];

    /**
     * @return array
     */
    public static function colors()
    {
        return [
            ''                       => Utils::msg('Color'),
            'ic:trans'               => 'Transparent',
            'ic:gray'                => Utils::msg('Black_and_white'),
            'ic:color'               => Utils::msg('Color'),
            'ic:specific,isc:red'    => 'red',
            'ic:specific,isc:orange' => 'orange',
            'ic:specific,isc:yellow' => 'yellow',
            'ic:specific,isc:pink'   => 'pink',
            'ic:specific,isc:white'  => 'white',
            'ic:specific,isc:gray'   => 'gray',
            'ic:specific,isc:black'  => 'black',
            'ic:specific,isc:brown'  => 'brown',
            'ic:specific,isc:green'  => 'green',
            'ic:specific,isc:teal'   => 'teal',
            'ic:specific,isc:blue'   => 'blue',
        ];
    }

    public static function sizes()
    {
        return [
            ''                 => Utils::msg('size'),
            'isz:l'            => Utils::msg('Big'),
            'isz:m'            => Utils::msg('Medium'),
            'isz:i'            => Utils::msg('Icon'),
            'isz:lt,islt:vga'  => '>  640x 480',
            'isz:lt,islt:svga' => '>  800x 600',
            'isz:lt,islt:xga'  => '> 1024x 768',
            'isz:lt,islt:2mp'  => '> 1600x1200 2mpx',
            'isz:lt,islt:4mp'  => '> 2272x1704 4mpx',
            'isz:lt,islt:6mp'  => '> 2816x2112 6mpx',
            'isz:lt,islt:8mp'  => '> 3264x2448 8mpx',
            'isz:lt,islt:10mp' => '> 3648x2736 10mpx',
            'isz:lt,islt:12mp' => '> 4096x3072 12mpx',
            'isz:lt,islt:15mp' => '> 4480x3360 15mpx',
            'isz:lt,islt:20mp' => '> 5120x3840 20mpx',
            'isz:lt,islt:40mp' => '> 7216x5412 40mpx',
            'isz:lt,islt:70mp' => '> 9600x7200 70mpx',
        ];
    }

    /**
     * @param $page
     *
     * @return bool
     */
    public static function isBannished($page)
    {
        return (boolean)stripos($page, CAPCHA_DETECT);
    }

    public static function getGoogleVed()
    {
        preg_match('#data-ved="(?P<VED>[^"]+)"#', self::file_curl_contents(GOOGLE_ROOT), $ved);
        if (!empty($ved['VED'])) {
            return $ved['VED'];
        }
    }

    /**
     * @param $query
     *
     * @return bool|string
     */
    public static function getGooglePage($query)
    {
        $query = str_replace(' ', '+', urlencode($query));
        $url = '';
        if (MODE === 'web') {
            $url = sprintf('%s%s%s&start=%s&num=100', GOOGLE_ROOT, GOOGLE_WEB, $query, START);
        } elseif (MODE === 'news') {
            $url = sprintf('%s%s%s&start=%s&num=100', GOOGLE_ROOT, GOOGLE_NEW, $query, START);
        } elseif (MODE === 'images') {
            if (defined('FILTRE')) {
                if (empty(FILTRE)) {
                    $f = '&tbs='.FILTRE;
                } else {
                    $f = '&'.FILTRE;
                }
            } else {
                $f = '';
            }
            $url = sprintf('%s%s%s%s&start=%s&num=100', GOOGLE_ROOT, GOOGLE_IMG, $query, $f, START);
        } elseif (MODE === 'videos') {
            $url = sprintf('%s%s%s&start=%s', GOOGLE_ROOT, GOOGLE_VID, $query, START);
        } elseif (MODE === 'map') {
            $url = sprintf('%s/%s', GOOGLE_MAP, urlencode($query));
            header('Location:'.$url);
        }
        $url .= '&ved='.$_SESSION['GOOGLE_VED'];
        $content = self::file_curl_contents($url,false);
        file_put_contents('gogimg.txt', $content);

        return $content;
    }

    public function link2YoutubeUser($desc, $link)
    {
        if (false !== stripos($link, 'youtube.com')) {
            $desc=preg_replace('#([Aa]jout[^ ]+ par )([^<]+)#','$1<a rel="noreferrer" href="http://www.youtube.com/user/$2?feature=watch">$2</a>',$desc);
        }

        return $desc;
    }

    /**
     * @param string $str
     *
     * @return mixed
     */
    public function my_htmlspecialchars($str)
    {
        return str_replace(
            array('&', '<', '>', '"'),
            array('&amp;', '&lt;', '&gt;', '&quot;'),
            $str
        );
    }

    /**
     * @param bool $stop
     */
    public function aff($stop=true)
    {
        $dat=debug_backtrace();
        $vars=func_get_args();
        $origin='';
        foreach ($vars as $name=>$val){
            ob_start();
            var_dump($vars[$name]);
            $var_dump = ob_get_clean();
            $var_dump = nl2br(htmlentities($var_dump));
            $var_dump = preg_replace('#(array|string|integer|int|object|float)(\([^\)]*?\))#','<em style="color:#0BF">$1</em> <em style="color:#0EF">$2</em>',$var_dump);
            $var_dump = preg_replace('#(bool)\((true)\)#','<em style="color:#0BF">$1</em> (<em style="color:#4F0">$2</em>)',$var_dump);
            $var_dump = preg_replace('#(bool)\((false)\)#','<em style="color:#0BF">$1</em> (<em style="color:#F40">$2</em>)',$var_dump);
            $var_dump = preg_replace('#\[([^\)]*?)\]#','<em style="color:#Fda">$1</em>',$var_dump);
            $var_dump = preg_replace('#( "([^"]+)")#','<em style="color:#Fb0">$1</em>',$var_dump);
            $var_dump = preg_replace('#(\{)#','<ul>',$var_dump);
            $var_dump = preg_replace('#\=\>\<br\s?\/\>#','&nbsp;&nbsp;&nbsp;<span style="color:white">=></span>&nbsp;&nbsp;&nbsp;',$var_dump);
            $var_dump = preg_replace('#(\})#','</ul>',$var_dump);
            $var_dump = preg_replace('#(NULL)#','<em style="color:#F00">$1</em>',$var_dump);

            $origin='<table>';
            echo '<div style="background-color:rgba(0,0,0,0.8);color:red;padding:5px"><h2>Arret ligne <em><strong style="color:white;font-weight:bold">'.$dat[0]['line'].'</strong></em> dans le fichier <em style="color:white;font-weight:bold">'.$dat[0]['file'].'</em></h2>';
            echo '<h3>Variable <strong>N°'.($name+1).'</strong></h3>';
            echo '<div style="background-color:rgba(0,0,0,0.8);color:#fff;padding:10px">'.$var_dump.'</div>';
        }
        foreach ($dat as $num => $data) {
            $dir = dirname($data['file']).'/';
            $fil = basename($data['file']);
            $origin .= '
                <tr>
                    <td style="width:50%">
                        <span style="color:white">'.$num.' - </span>
                        <em style="color:#888">'.$dir.'</em>
                    </td>
                    <td style="max-width:10%">
                        <em style="color:white;font-weight:bold">'.$fil.'</em>
                    </td>
                    <td style="max-width:10%"> 
                        <em style="color:lightblue;font-weight:bold">l. '.$data['line'].'</em> 
                    </td>
                    <td style="max-width:10%">
                        <em style="color:yellow;font-weight:bold">'.$data['function'].'()</em>
                    </td>
                </tr>';
        }
        $origin.='</table>';
        echo '<div style="background-color:rgba(0,0,0,0.8);color:#aaa;padding:10px"><h3> Pile d\'appels </h3>'.$origin.'</div></div>';
        exit();
    }

    public static function render($data)
    {
        if (!$data){ return;}
        echo '<ul start="'.START.'">';
        foreach ($data as $key => $item) {
            if (!empty($item['link'])){
                //$tpl_i=(string)$config['tpl'][MODE];
                if (!empty($item['thumbnail'])){
                    $item['thumbnail'] = self::grab_thumbs($item['thumbnail']);
                }
                if (!empty($item['description'])){
                    $item['description'] = self::highlight(QUERY_SANITIZED,$item['description']);
                }
                if (!empty($item['title'])){
                    $item['title'] = self::highlight(QUERY_SANITIZED,$item['title']);
                }

                $item['higlightedlink'] = self::highlight(QUERY_SANITIZED,urldecode($item['link']));
                $item['wot']='<a class="wot-exclude wot" href="'.WOT_URL.$item['link'].'" title="View scorecard"> </a>';
                $keys=array_map(function($k){return '#'.$k;}, array_keys($item));

                echo str_replace($keys,
                    array_values($item),
                    self::$templates[MODE]);
            }


        }
        echo '</ul>';
        self::pagination($data['pages']);
    }

    protected static function parse_web($page)
    {
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($page);
        libxml_use_internal_errors();

        $xpath = new DOMXpath($doc);
        $elements = $xpath->query("//div[@id='main']/div");

        $links = [];
        $titles = [];
        $descriptions = [];

        if (false !== $elements) {
            // On ignore les 3 premières div inutiles
            for ($i = 3, $l = $elements->length; $i < $l; $i++) {
                $el = $elements->item($i);
                // On ne prend pas les div "séparatrices" vides
                if ($el === null || !$el->hasChildNodes()) {
                    continue;
                }
                $a = $el->firstChild->firstChild->firstChild;
                // On ne prend pas les liens non liés à la recherche
                if (null === $a || !$a->hasAttributes()) {
                    continue;
                }
                $link = (string)$a->attributes->item(0)->nodeValue;
                preg_match('#^\/url\?q=([^&]+).*$#', $link, $r);
                if (!isset($r[1])) {
                    continue;
                }
                $links[] = $r[1];
                $a_children = $a->childNodes;
                $titles[] = $a_children->item(0)->textContent;
                $description = $el->firstChild->childNodes->item(2);
                $descriptions[] = null === $description ? '' : $description->textContent;
            }

            return [
                'link'        => $links,
                'title'       => array_map('strip_tags', $titles),
                'description' => array_map('strip_tags', $descriptions),
            ];
        }

        return [
            'links' => [], 'titles' => [], 'descriptions' => [],
        ];
    }

    public static function parsePage($page)
    {
        if (OFFLINE) {
            $page = file_get_contents(MODE.'_last_downloaded_page.html');
        } elseif (DEBUG) {
            file_put_contents(MODE.'_last_downloaded_page.html',$page);
        }

        if (MODE === 'web') {
            preg_match_all(self::$regexes['pages'],$page,$p);
            $p = count($p[0]);

            $retour = array_merge(
                self::parse_web($page),
                [
                    'nb_pages'     => $p,
                    'current_page' => START,
                    'query'        => QUERY_RAW,
                    'mode'         => MODE,
                ]
            );
            $pages = false;
        } elseif (MODE === 'news') {
            preg_match_all(self::$regexes['news'],$page,$r);
            preg_match_all(self::$regexes['pages'],$page,$p);
            $p = count($p[0]);
            $retour = [
                'title'        => array_map('strip_tags', $r['title']),
                'description'  => array_map('strip_tags', $r['description']),
                'link'         => array_map('strip_tags', $r['link']),
                'thumbnail'    => $r['thumbnail'],
                'nb_pages'     => $p,
                'current_page' => START,
                'query'        => QUERY_RAW,
                'mode'         => MODE,
            ];
            $pages = false;
        } elseif (MODE === 'images') {
            preg_match_all(self::$regexes['img'],$page,$r);
            //preg_match_all(self::$regexes['pages'],$page,$p);
            $retour = [
                'urlimg'      => $r['link'],
                'urlpage'     => $r['link'],
                'imgfilename' => array_map('basename', $r['link']),
                'h'           => $r['h'],
                'w'           => $r['w'],
                'link'        => $r['link'],
                'thumbnail'   => $r['thumbnail'],
                'description' => array_map('strip_tags', $r['info']),
            ];
            $pages = false;
            unset($r);

        } elseif (MODE === 'videos') {
            preg_match_all(self::$regexes['vid'], $page, $r);
            preg_match_all(self::$regexes['vidthmbs'], $page, $t);
            preg_match_all(self::$regexes['pages'], $page, $p);

            $p = count($p[0]);
            $retour = [
                'site'         => $r['link'],
                'titre'        => array_map('strip_tags', $r['title']),
                'link'         => array_map('urldecode', $r['link']),
                'description'  => array_map('strip_tags', $r['description']),
                'thumbnail'    => $t[1],
                'w'            => $t[2],
                'nb_pages'     => $p - 1,
                'current_page' => START,
                'query'        => QUERY_RAW,
                'mode'         => MODE,
            ];
            $pages = false;
        }

        if (!empty($retour['link'])) {
            foreach ($retour as $type => $items) {
                if (is_array($items)) {
                    foreach ($items as $nb => $data) {
                        $arranged_array[$nb][$type] = $data;
                    }
                }
            }
            $arranged_array['pages'] = $pages;
            return $arranged_array;
        }
        return false;
    }
}
