<?php
/**
 * Created by PhpStorm.
 * User: Dave
 * Date: 04.01.14
 * Time: 14:59
 */

namespace module\filemanager\controller;


class filesize {

    public function format_filesize($size) {
        $arr_units = array(
            'KB',
            'MB',
            'GB',
            'TB',
            'TB'
        );
        for ($i = 0; $size > 1024; $i++) {
            $size /= 1024;
        }
        return number_format($size, 2, ',', '').' '.$arr_units[$i];
    }
} 