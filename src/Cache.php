<?php

namespace Googol;

class Cache
{
    public static function clear_cache($delay = 180)
    {
        $fs = glob('thumbs/*');
        if (!empty($fs)) {
            foreach ($fs as $file) {
                if (@date('U')-@date(filemtime($file)) > $delay) {
                    unlink($file);
                }
            }
        }
    }
}
