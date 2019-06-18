<?php

namespace Googol;

abstract class Engine
{
    public static $templates = [];
    public static $regexes = [];

    abstract public static function colors();
    abstract public static function sizes();
    abstract public static function render($data);
    abstract public static function parsePage($page);

    public static function file_curl_contents($url, $pretend = true)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Charset: UTF-8'));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,  FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        if (!ini_get('safe_mode') && !ini_get('open_basedir')) {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        }
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        if ($pretend){curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; Android 4.4.2; Che2-L11 Build/HonorChe2-L11) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/30.0.0.0 Mobile Safari/537.36');}
        curl_setopt($ch, CURLOPT_REFERER, 'http://google.com');
        $data = curl_exec($ch);
        $response_headers = curl_getinfo($ch);
        // Google seems to be sending ISO encoded page + htmlentities, why??
        if ($response_headers['content_type'] === 'text/html; charset=ISO-8859-1') {
            $data = html_entity_decode(iconv('ISO-8859-1', 'UTF-8//TRANSLIT', $data));
        }
        curl_close($ch);

        return $data;
    }

    public static function highlight($words = '', $str = '')
    {
        if (empty($str)) {
            return null;
        }
        if (empty($words)) {
            return $str;
        }

        $words = explode(' ', $words);
        $regex = '#\\b(\\w*)(';
        $sep = '';
        foreach ($words as $word) {
            $regex .= $sep . preg_quote($word, '#');
            $sep = '|';
        }
        $regex .= ')(\\w*)\\b#i';

        return preg_replace($regex, '\\1<span class="highlighted">\\2</span>\\3', $str);
    }

    public static function grab_thumbs($link)
    {
        $local = 'thumbs/'.md5($link).'.jpg';

        if (is_file($local)) {
            return $local;
        }

        if ($thumb = self::file_curl_contents($link)) {
            file_put_contents($local, $thumb);
            return $local;
        }

        return $link;
    }

    /**
     * @return string
     */
    public static function doQuery()
    {
        $query = sprintf('%s?q=%s&mod=%s&lang=%s', RACINE, QUERY_RAW, MODE, LANGUAGE);
        if (COLOR) {
            $query.='&couleur='.COLOR;
        }
        if (SIZE) {
            $query.='&taille='.SIZE;
        }

        return $query;
    }

    public static function pagination($pages)
    {
        $previous = $next = '';
        if ($pages) {
            $nbpages = (count($pages)-1) * 20;

            if (START > 0) {
                $previous = '<a href="'.self::doQuery().'&start='.(START-20).'">'.Utils::msg('previous').'</a> ';
            }
            if (START<$nbpages) {
                $next = ' <a href="'.self::doQuery().'&start='.(START+20).'">'.Utils::msg('next').'</a>';
            }
            $echo = '<div class="pagination box">'.$previous.'<a href="'.self::doQuery().'"><em class="g">G</em></a>';
            foreach ($pages as $start) {
                if ($start === START){
                    $active=' class="active" ';
                } else {
                    $active='';
                }
                $echo.='<a '.$active.' href="'.self::doQuery().'&start='.$start.'" title="'.$start.'"><em class="o1">o</em></a>';
            }
            $echo .= LOGO2;
            echo $echo.$next.'</div>';
        } elseif (MODE === 'images') {
            echo '<a class="button box" href="'.self::doQuery().'&start='.(START+20).'">'.Utils::msg('next').'</a>';
        } else {
            echo '<a class="button box" href="'.self::doQuery().'&start='.(START+10).'">'.Utils::msg('next').'</a>';
        }
    }
}