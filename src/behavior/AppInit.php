<?php
// +----------------------------------------------------------------------
// | TPR [ Design For Api Develop ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017-2017 http://hanxv.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: axios <axioscros@aliyun.com>
// +----------------------------------------------------------------------

namespace axios\tpr\behavior;

use think\Lang;
use think\Request;

class AppInit {
    public $param;
    public $request;
    function __construct()
    {
        $this->request = Request::instance();
        $this->param = $this->request->param();
    }

    public function run(){
        $this->lang();
    }

    public function lang(){
        Lang::detect();
        $this->request->langset(Lang::range());
        $lang_path = defined('LANG_PATH')?LANG_PATH:CONF_PATH.'lang'.DIRECTORY_SEPARATOR;
        $lastString = substr($lang_path,-1);
        if($lastString!=DS){
            $lang_path .= DS;
        }
        Lang::load($lang_path. $this->request->langset() . EXT);
    }

}