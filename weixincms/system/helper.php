<?php
/** .-------------------------------------------------------------------
 * | 函数库
 * '-------------------------------------------------------------------*/
//检测函数是否已经存在，如果不存在，则声明url函数
if ( !function_exists( 'url' ) ) {
    /**
     * 跳转模块url跳转函数
     * @param $url				跳转地址：控制器.方法
     * @param string $module	跳转模块	 默认都get中m参数
     *
     * @return string
     */
    function url ( $url , $module = '', $args = [])
    {
        //如果$model这个参数为真，说明调用url时候，有传$module这个参数，以传入的为准
        //如果没有穿第二个参数，默认使用get参数中m参数的值
        $module = $module ? :Request::get('m');
        //p($module);//base
        //p($url);//base.index
        //return "?m=base&action=controller/base/index";
        //将拼接完成的完整路径返回出去。
        return __ROOT__ ."?m=".$module."&action=controller/" . str_replace('.','/',$url). '&' . http_build_query($args);
    }

}