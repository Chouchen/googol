<?php

namespace Googol\Engine;

use Googol\Engine;
use Googol\Utils;

define('FILTER',SIZE.',,,'.COLOR);
define('REGEX_VQD','#vqd=\'(?P<vqd>[^\']+)#');
define('PAGE_VQD','https://duckduckgo.com/?q='.QUERY_RAW);
define('VQD', Duckduckgo::getVed());
define('LINK_IMG','https://duckduckgo.com/i.js?l='.strtolower(LANGUAGE).'&o=json&q='.QUERY_RAW.'&vqd='.VQD.'&f='.FILTER.'&p=-1&s=');
define('LINK_WEB','https://duckduckgo.com/d.js?l='.strtolower(LANGUAGE).'&o=json&q='.QUERY_RAW.'&vqd='.VQD.'&f=,,,&p=-1&s=');
define('LINK_VID','https://duckduckgo.com/v.js?strict=1&l='.strtolower(LANGUAGE).'&o=json&q='.QUERY_RAW.'&vqd='.VQD.'&f=,,,&p=-1&s=');
define('LINK_NEW','https://duckduckgo.com/news.js?strict=1&l='.strtolower(LANGUAGE).'&o=json&q='.QUERY_RAW.'&vqd='.VQD.'&f=,,,&p=-1&s=');

class Duckduckgo extends Engine
{
    public static $templates = [
        'web'    => '<li class="result"><a rel="noreferrer" href="#u"><h3 class="title">#t</h3>#z</a>#wot<p class="description">#a</p></li>',
        'images' => '
	<div class="image">
		<a rel="noreferrer" class="pic" href="#image" style="background-image:url(#thumbnail)"></a>
		<span class="description">
			#width x #height
			<a class="source" href="#url" title="#url"> 
				source
			</a>
		</span>
	</div>',
        //'images'=>'<div class="image"><a rel="noreferrer" href="#image" title="#link">#thumbnail</a><div class="description">#width x #height<a class="source" href="#url" title="#title"> #url</a></div></div>',
        'videos' => '<div class="video" ><h3><a rel="noreferrer" href="https://youtube.com/watch?v=#id" title="#title">#title</a></h3><a rel="noreferrer" class="pic" href="https://youtube.com/watch?v=#id" style="background-image:url(#medium)"></a><p class="site">#provider</p><p class="description">#description</p></div>',
        'news'   => '<li class="result"><a rel="noreferrer" href="#url"><h3 class="title">#title</h3>#relative_time</a><p class="description">#excerpt</p></li>',
    ];

    public static function colors()
    {
        return [
            ''                    => Utils::msg('Color'),
            'color2-bw'           => Utils::msg('Black_and_white'),
            'color2-color'        => Utils::msg('Color'),
            'color2-FGcls_RED'    => 'red',
            'color2-FGcls_ORANGE' => 'orange',
            'color2-FGcls_YELLOW' => 'yellow',
            'color2-FGcls_PINK'   => 'pink',
            'color2-FGcls_WHITE'  => 'white',
            'color2-FGcls_GRAY'   => 'gray',
            'color2-FGcls_BLACK'  => 'black',
            'color2-FGcls_BROWN'  => 'brown',
            'color2-FGcls_GREEN'  => 'green',
            'color2-FGcls_PURPLE' => 'purple',
            'color2-FGcls_BLUE'   => 'blue',
        ];
    }

    public static function sizes()
    {
        return [
            ''                         => Utils::msg('size'),
            'size:imagesize-large'     => Utils::msg('Big'),
            'size:imagesize-medium'    => Utils::msg('Medium'),
            'size:imagesize-wallpaper' => Utils::msg('Wallpaper'),
        ];
    }


    public static function getVed()
    {
        $vqdpage = self::file_curl_contents(PAGE_VQD);
        preg_match(REGEX_VQD, $vqdpage,$vqd);
        return $vqd['vqd'];
    }

    public static function getDdgData($page=0,$mode='web')
    {
        $link = '';
        if ($mode === 'web') {
            $link = LINK_WEB;
        } elseif ($mode === 'images') {
            $link = LINK_IMG;
        } elseif ($mode === 'videos') {
            $link = LINK_VID;
        } elseif ($mode === 'news') {
            $link = LINK_NEW;
        }
        $data = json_decode(self::file_curl_contents($link.$page),true);
        if ($data) {
            return $data['results'];
        }

        return null;
    }

    public static function render($data)
    {
        $config = Utils::getConfig();
        if (!$data){
            return;
        }
        echo '<ul start="'.START.'">';
        foreach ($data as $key => $item) {
            $tpl_i = $config['tpl'][MODE];

            if (!empty($item['thumbnail'])){
                $item['thumbnail'] = self::grab_thumbs($item['thumbnail']);
            }
            if (!empty($item['images']['medium'])){
                $item['medium'] = self::grab_thumbs($item['images']['medium']);
            }
            if (!empty($item['t'])){
                $item['t'] = self::highlight(QUERY_SANITIZED,$item['t']);
            }
            if (!empty($item['u'])){
                $item['z'] = self::highlight(QUERY_SANITIZED,$item['u']);
                $keys[] = '#z';
            }
            if (!empty($item['i'])) {
                $item['wot'] = '<a class="wot-exclude wot" href="'.WOT_URL.$item['i'].'" title="View scorecard"> </a>';
                $keys[] = '#wot';
            }
            $keys=array_map(function($k){return '#'.$k;}, array_keys($item));
            $tpl_i=str_replace($keys, array_values($item), $tpl_i);
            echo $tpl_i;
        }
        echo '</ul>';
    }

    public static function parsePage($page)
    {
        // TODO: Implement parsePage() method.
    }
}