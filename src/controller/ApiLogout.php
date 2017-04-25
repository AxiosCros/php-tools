<?php
/**
 * @author: Axios
 *
 * @email: axioscros@aliyun.com
 * @blog:  http://hanxv.cn
 * @datetime: 2017/4/7 14:51
 */

namespace axios\tpr\controller;

use think\Request;

class ApiLogout extends ApiBase{
    function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->commonFilter('logout');//公共过滤
    }
}