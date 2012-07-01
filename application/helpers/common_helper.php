<?php

/**
 * 函数库
 *
 * @author mawenpei<mawenpei@duankou.com>
 * @date <2012-02-10>
 *
 */
/**
 * 请求远程SOAP服务
 *
 * @author mawenpei<mawenpei@duankou.com>
 * @date <2012/02/14>
 */
function call_soap($app, $module, $method, $params = array(), $server_url = '') {
    if (empty($server_url)) {
        $web_url = config_item('server_url') . $app;
    } else {
        $web_url = $server_url;
    }
    if (!class_exists('SoapClient')) {
        require_cache(APPPATH . 'libraries' . DS . 'Nusoap' . DS . 'nusoap.php');
    }

    $client = new SoapClient($web_url);
    $client -> decode_utf8 = false;
    $client -> xml_encoding = 'utf-8';

    $err = $client -> getError();
    if ($err) {
        print_r($err);
    }
    //echo '<h2>DeBug</h2>';
    //echo $client->debug_str.'<br/>';
    //echo $client->request.'<br/>';
    //echo $client->response;
    return $client -> call('do_call', array($module, $method, $params));
}

/**
 * 加载文件
 * 如果文件已经加载则直接返回
 */
function require_cache($filename) {
    static $_importFiles = array();
    $key = md5($filename);
    if (!isset($_importFiles[$key])) {
        if (file_exists($filename)) {
            require $filename;
            $_importFiles[$key] = true;
        } else {
            log_message('error', 'file not found:' . $filename);
            show_error('file not found:' . $filename);
        }
    }
    return $_importFiles[$key];
}

/**
 * 生成统一的URL,支持不同的模式和路由
 *
 * @author mawenpei<mawenpei@duankou.com>
 * @date <2012/02/14>
 *
 * @edit by guoshaobo@<2012/04/02>
 * @添加一个参数,用来控制页面是否跳转为当前域名;
 *
 * @param string $uri 路由参数格式[应用/控制器/方法]
 * @param string $local	TRUE表示不跳转,false表示跳转到dev
 * @param array  $params
 */
function mk_url($uri = '', $params = array(), $local = true, $return = true) {
    if (substr($uri, 0, 4) == 'http') {
        $realurl = $uri;
    } else {
        $tmp = explode('/', $uri);
        $app = $tmp[0];
        $controller = $tmp[1];
        $method = isset($tmp[2]) ? $tmp[2] : 'index';
        if (!in_array($app, array('main', 'front'))) {
            if($local)
            {
                $app = 'single/' . $app;
            }
            else 
            {
                $app = 'web/' . $app;
            }
        }
        $domain = $local ? WEB_ROOT : WEB_DUANKOU_ROOT;
        $realurl = $domain . $app . '/' . 'index.php?c=' . $controller . '&m=' . $method;
    }
    if (is_array($params) && count($params) > 0) {
        foreach ($params as $key => $value) {
            $realurl .= '&' . $key . '=' . $value;
        }
    } elseif (is_string($params) && strlen($params)) {
        $realurl .= '&' . $params;
    }
    if ($return) {
        return $realurl;
    } else {
        echo $realurl;
    }
}

// 获取客户端IP地址
function get_client_ip() {
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
        $ip = getenv("REMOTE_ADDR");
    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
        $ip = $_SERVER['REMOTE_ADDR'];
    else
        $ip = "unknown";
    return ($ip);
}

/**
 * 获取SessionID
 *
 * @author mawenpei<mawenpei@duankou.com>
 * @date <2012/02/14>
 */
function get_sessionid() {
    if (!get_cookie('sessionid')) {
        require_cache(APPPATH . 'libraries' . DS . 'Session.php');
        $sessionid = Session::get_id();
//        $sessionid = call_soap('session', 'Index', 'getCookieId', array());
        set_cookie('sessionid', $sessionid);
    } else {
        $sessionid = get_cookie('sessionid');
    }
    return $sessionid;
}
/**
 * 设置Session
 *
 * @author mawenpei<mawenpei@duankou.com>
 * @date <2012/02/14>
 * @param string key 键名
 * @param mix value 键值
 * @param int ttl 有效期
 */
function set_session($key, $value, $ttl = null) {
    $sessionid = get_sessionid();
    require_cache(APPPATH . 'libraries' . DS . 'Session.php');
    $session = Session::getInstance();
    return $session->setData($sessionid, $key, $value, $ttl);
//    return call_soap('session', 'Index', 'setData', array($sessionid, $key, $value, $ttl));
}

/**
 * 获取Session
 *
 * @author mawenpei<mawenpei@duankou.com>
 * @date <2012/02/14>
 * @param string $key 键名
 *
 */
function get_session($key) {
    $sessionid = get_sessionid();
    if (!$sessionid) {
        return null;
    } else {
        require_cache(APPPATH . 'libraries' . DS . 'Session.php');
        $session = Session::getInstance();
        return $session->getData($sessionid, $key);
    }
//    if (!$sessionid)
//        return null;
//    return call_soap('session', 'Index', 'getData', array($sessionid, $key));
}

/**
 * 删除Session
 *
 * @author mawenpei<mawenpei@duankou.com>
 * @date <2012/02/14>
 */
function delete_session($key) {
    $sessionid = get_sessionid();
    if (!$sessionid) {
        return null;
    } else {
        require_cache(APPPATH . 'libraries' . DS . 'Session.php');
        $session = Session::getInstance();
        return $session->delData($sessionid, $key);
    }
//    if (!$sessionid)
//        return null;
//    return call_soap('session', 'Index', 'delData', array($sessionid, $key));
}

/**
 * 设置缓存
 *
 * @author mawenpei<mawenpei@duankou.com>
 * @date <2012/02/14>
 */
function set_cache($key, $data, $ttl = 0, $group = '') {
    require_cache(APPPATH . 'libraries' . DS . 'CacheMemcache.php');
    $memcache = new CacheMemcache();
    return $memcache->setData($key, $data, $ttl, $group);
    
//    $params = array();
//    $params['key'] = $key;
//    $params['data'] = $data;
//    $params['ttl'] = $ttl;
//    $params['group'] = $group;
//    return call_soap('cache', 'Memcache', 'set', $params);
}

/**
 * 获取缓存
 *
 * @author mawenpei<mawenpei@duankou.com>
 * @date <2012/02/14>
 */
function get_cache($key, $group = '') {
    require_cache(APPPATH . 'libraries' . DS . 'CacheMemcache.php');
    $memcache = new CacheMemcache();
    return $memcache->getData($key, $group);
    
//    $params = array();
//    $params['key'] = $key;
//    $params['group'] = $group;
//    return call_soap('cache', 'Memcache', 'get', $params);
}

/**
 * 删除缓存
 *
 * @author mawenpei<mawenpei@duankou.com>
 * @date <2012/02/14>
 */
function delete_cache($key, $group = '') {
    require_cache(APPPATH . 'libraries' . DS . 'CacheMemcache.php');
    $memcache = new CacheMemcache();
    return $memcache->rmData($key, $group);
    
//    $params = array();
//    $params['key'] = $key;
//    $params['group'] = $group;
//    return call_soap('cache', 'Memcache', 'rm', $params);
}

/**
 * 设置Cookie
 *
 * @author mawenpei<mawenpei@duankou.com>
 * @date <2012/02/14>
 */
function set_cookie($name, $value, $expire = '', $path = '', $domain = '') {
    require_cache(APPPATH . 'libraries' . DS . 'Cookie.class.php');
    return Cookie::set($name, $value, $expire, $path, $domain);
}

/**
 * 读取Cookie
 *
 * @author mawenpei<mawenpei@duankou.com>
 * @date <2012/02/14>
 */
function get_cookie($name) {
    require_cache(APPPATH . 'libraries' . DS . 'Cookie.class.php');
    if (!Cookie::is_set($name))
        return null;
    return Cookie::get($name);
}

/**
 * 删除Cookie
 *
 * @author mawenpei<mawenpei@duankou.com>
 * @date <2012/02/14>
 */
function delete_cookie($name) {
    require_cache(APPPATH . 'libraries' . DS . 'Cookie.class.php');
    Cookie::delete($name);
}

/**
 * 清除Cookie
 *
 * @author mawenpei<mawenpei@duankou.com>
 * @date <2012/02/14>
 */
function clear_cookie() {
    require_cache(APPPATH . 'libraries' . DS . 'Cookie.class.php');
    Cookie::clear();
}

/**
 * 友好的时间显示
 *
 * @param int    $sTime 待显示的时间
 * @param string $type  类型. mohu | full | ymd | other
 * @return string
 */
function friendlyDate($sTime, $type = 'mohu')
{
    //sTime=源时间，cTime=当前时间，dTime=时间差
    $cTime = time();
    $todayTime = mktime('0', '0', '0', date('m'), date('d'), date('Y'));
    $yestodayTime = mktime('0', '0', '0', date('m'), date('d') - 1, date('Y'));
    $tommrrowTime = mktime('0', '0', '0', date('m'), date('d') + 1, date('Y'));
    $weekTime = $todayTime - date('w', $cTime) * 86400;
    $dTime = $cTime - $sTime;
    
    if ($type == 'mohu')
    {
		if($dTime< 10)
	   	{
			return '刚刚';
	   	}
       if (10 < $dTime && $dTime < 60)
       {
           return (ceil($dTime) + 0) . " 秒前";
       }
       elseif ($dTime < 3600)
       {
           return intval($dTime / 60) . " 分钟前";
       }
       //时间在今天0点到明天0点之间
       elseif ($sTime < $tommrrowTime && $sTime > $todayTime)
       {
           $h = intval($dTime / 3600);
           if (ceil($dTime % 3600 / 60) > 30)
           {
               $h ++;
           }
           if ($h >= 3)
           {
               return "今天  " . date('H:i', $sTime);
           }
           return $h . " 小时前";
       }
       //时间在本周0点到今天0点之间
       elseif ($sTime < $todayTime && $sTime > $weekTime)
       {
           //时间在今天0点到昨天0点之间
           if ($sTime > $yestodayTime && $sTime < $todayTime)
           {
               return "昨天 " . date('H:i', $sTime);
           }
           //时间在前天0点到昨天0点之间
           elseif ($sTime > ($yestodayTime - 86400) && $sTime < $yestodayTime)
           {
               return "前天 " . date('H:i', $sTime);
           }
           //其他
           else
           {
                return date("Y年n月j日H:i", $sTime);
           }
       }
       else
       {
           return date("Y年n月j日H:i", $sTime);
       }
    }
    elseif ($type == 'full')
    {
        return date("Y-m-d , H:i:s", $sTime);
    }
    elseif ($type == 'ymd')
    {
        return date("Y-m-d", $sTime);
    }
    else
    {
        if ($dTime < 60)
        {
            return $dTime . "秒前";
        }
        elseif ($dTime < 3600)
        {
            return intval($dTime / 60) . "分钟前";
        }
        elseif ($sTime < $tommrrowTime && $sTime > $todayTime)
        {
            return intval($dTime / 3600) . "小时前";
        }
        else
        {
            return date("Y-m-d H:i", $sTime); /*葛飞超 2012-01-12 去掉 秒*/
        }
    }
}

/**
 * 未来时间显示
 * @param unknown_type $stime
 */
function friendlyDateAfter($stime) {
    $cTime = time();
    $nowTime = mktime(date('H'), date('i'), date('s'), date('m'), date('d'), date('Y'));
    $todayTime = mktime('0', '0', '0', date('m'), date('d'), date('Y'));
    $tommrrowTime = $todayTime + 86400;
    $afterTommrrowTime = $tommrrowTime + 86400;
    $tTommrrowTime = $afterTommrrowTime + 86400;
    $weekTime = $todayTime - date('w', $cTime) * 86400;
    $nextWeekTime = $weekTime + 7 * 86400;
    $nNextWeekTime = $nextWeekTime + 7 * 86400;
    $dtime = $stime - $cTime;
    $week = array('日  ', '一  ', '二  ', '三  ', '四 ', '五  ', '六  ');
    //一分钟以内
    if ($dtime > 0 && $dtime < 60) {
        return $dtime . ' 秒以后';
        //一小时以内
    } elseif ($dtime > 60 && $dtime < 3600) {
        return floor($dtime / 60) . ' 分钟以后';
        //今天之内
    } elseif ($dtime > 3600 && $stime < $tommrrowTime) {
        $h = floor($dtime / 60 / 60);
        if ($h > 3) {
            return "今天  " . date('H:i', $stime);
        }
        return $h . '小时以后';
    }
    //今天和明天之间
    elseif ($stime > $tommrrowTime && $stime < $afterTommrrowTime) {
        return '明天 ' . date('H:i', $stime);
    }
    //明天和后天之间
    elseif ($stime > $afterTommrrowTime && $stime < $tTommrrowTime) {
        return '后天 ' . date('H:i', $stime);
    }
    //后天和本周六之间
    elseif ($stime > $tTommrrowTime && $stime < $nextWeekTime) {
        return '本周' . $week[date('w', $stime)] . date('H:i', $stime);
    }
    //本周和下周之间
    elseif ($stime > $nextWeekTime && $stime < $nNextWeekTime) {
        return '下周' . $week[date('w', $stime)] . date('H:i', $stime);
    } else {
        return date("Y年m月d日H:i", $stime);
    }

}

/**
 * 输出Widget
 * @param string $name
 * @param array  $data
 * @return bool $return 是否返回
 */
function widget($name, $data = array(), $return = FALSE) {
    $class = strtolower($name);
    static $_widgets = array();
    if (!isset($_widgets[$name])) {
        if (!class_exists('MY_Widget', false)) {
            require_cache(APPPATH . 'core' . DS . 'MY_Widget' . EXT);
        }
        if (!class_exists($class, false)) {
            $filepath = APPPATH . 'widgets' . DS . $class . EXT;
            if (file_exists($filepath)) {
                require_cache($filepath);
            } else {
            }
        }
        $_widgets[$name] = new $class();
    }
    $widget = $_widgets[$name];
    $content = $widget -> render($data);
    if ($return) {
        return $content;
    }
    echo $content;
}

/*
 +------------------------------------
 * author chenxujia
 * data 2012-03-22
 * @param string $key post值
 * @return string
 +------------------------------------
 */

function P($key = '',$filter=true) {
    if (empty($key)) {
        return '';
    }
    $ci = &get_instance();
    $get_post = $ci -> input -> post($key, TRUE);

    if($filter=== FALSE)
    {
        return $get_post;
    }
    if (get_magic_quotes_gpc()) {
        $get_post = stripcslashes_deep($get_post);
    }

    if (is_string($get_post)) {
        return shtmlspecialchars(trim($get_post));
    } else {
        return shtmlspecialchars($get_post);
    }
}

function stripcslashes_deep($var) {
    if (is_array($var) && $var) {
        foreach ($var as $k => $v) {
            $var[$k] = stripcslashes_deep($v);
        }
        return $var;
    } else if (is_string($var)) {
        return stripcslashes($var);
    } else {
        return "";
    }
}

/**
 +----------------------------------------------------------
 * 字符串截取，支持中文和其它编码
 +----------------------------------------------------------
 * @static
 * @access public
 +----------------------------------------------------------
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 +----------------------------------------------------------
 * @return string
 +----------------------------------------------------------
 */
function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true) {
    if (function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif (function_exists('iconv_substr')) {
        $slice = iconv_substr($str, $start, $length, $charset);
    } else {
        $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("", array_slice($match[0], $start, $length));
    }
    if ($suffix && $str != $slice)
        return $slice . "...";
    return $slice;
}
/**
 * 获取用户头像
 */
function get_avatar($uid, $size = 's') {
	require_cache(APPPATH . 'core' . DS . 'MY_Redis' . EXT);
	$redis = MY_Redis::getInstance();
    $v = '?v=' . time();    
    $fname = @rtrim($redis -> get('avatar:' . $uid), '.jpg');
    if (empty($fname))
        return MISC_ROOT . 'img/default/avatar_' . $size . '.gif';
	$flag = $redis -> get('avatar:is_default' . $uid);
	if (empty($flag) || $flag == 2) 
        return MISC_ROOT . 'img/default/avatar_' . $size . '.gif';     
    return $fpath = 'http://' . config_item('fastdfs_host') . '/' . config_item('fastdfs_group') . '/' . $fname . '_' . $size . '.jpg'.$v;
}

/**
 * 获取网页头像
 */
function get_webavatar($uid, $size = 's', $webid = '') {
	require_cache(APPPATH . 'core' . DS . 'MY_Redis' . EXT);
    if (empty($uid))
        return false;
    $v = '?v=' . time();
    $redis = MY_Redis::getInstance();
    $fname = @rtrim($redis -> get('avatar:' . $uid), '.jpg');
    if (empty($fname))
        return MISC_ROOT . 'img/default/web_' . $size . '.gif';
    $flag = $redis -> get('avatar:web_is_default' . $webid);
    //2 是默认头像 3不是默认头像
    if (empty($flag) || $flag == 2)
        return MISC_ROOT . 'img/default/web_' . $size . '.gif';
    return $fpath = 'http://' . config_item('fastdfs_host') . '/' . config_item('fastdfs_group') . '/' . $fname . '_' . $webid . '_' . $size . '.jpg'.$v;

}

/**
 * 获取用户资料信息
 * @param int/string $uid
 * @author fbbin
 * @return array
 */
function getUserInfo( $uids )
{
	$_uid = $uids;
	if( is_string( $uids ) )
	{
		$uids = array($uids);
	}
	require_cache(APPPATH . 'core' . DS . 'MY_Redis' . EXT);
	if (empty($uids))
	{
		return false;
	}
	$oRedis = MY_Redis::getInstance();
	$aResults = array();
	foreach ($uids as $uid)
	{
		$aResults[$uid] = $oRedis->hMGet('user:'.$uid, array('id','name','dkcode'));
		$aResults[$uid]['uid'] = $aResults[$uid]['id'];
		$aResults[$uid]['username'] = $aResults[$uid]['name'];
		unset($aResults[$uid]['id'], $aResults[$uid]['name']);
	}
	return !is_array($_uid) ? array_pop($aResults) : $aResults;
}

/**
 * 检测是否有头像
 */
function exist_avatar($uid) {
	require_cache(APPPATH . 'core' . DS . 'MY_Redis' . EXT);
    if (empty($uid))
        return false;
    $v = '?v=' . time();
	$redis = MY_Redis::getInstance();   
    $flag = $redis -> get('avatar:is_default' . $uid);

    //2 是默认头像 3不是默认头像
    if (empty($flag) || $flag == 2) {
        return false;
    } else {
        return true;
    }
}

/**
 * 检查远程文件是否存在
 */
function check_remote_file($url) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_NOBODY, true);
    $result = curl_exec($curl);
    $found = false;
    if ($result !== false) {
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($status == 200) {
            $found = true;
        }
    }
    curl_close($curl);
    return $found;
}

function get_uuid() {
    $chars = md5(uniqid(mt_rand(), true));
    $uuid = substr($chars, 0, 8) . '-';
    $uuid .= substr($chars, 8, 4) . '-';
    $uuid .= substr($chars, 12, 4) . '-';
    $uuid .= substr($chars, 16, 4) . '-';
    $uuid .= substr($chars, 20, 16);
    return $uuid;
}

/**
 * 产生36位uuid
 *
 * @author chenjiali
 * @date 2011/09/07
 * @access public
 * @return string
 */
function json_encodes($status = 1, $msg = 'success', $param = null) {
    $arr['status'] = $status;
    //if (is_string($param)) {
    $arr['data'] = $param;
    //} elseif (is_array($param)) {
    // $arr = array_merge($arr, $param);
    //}
    $arr['msg'] = $msg;
    echo json_encode($arr);
    exit();
}

/**
 * 此方法已不加载语言包
 * 兼容原有的code
 * @modify by zengmingming
 */
function L($item) {
    return $item;
}

function filterKeys(array $keys, array $oldVals) {//过滤没有修改的数据
    if (!$keys && $oldVals) {
        return false;
    }
    $returns = array();
    foreach ($keys as $key => $value) {
        if (isset($_POST[$key]) && ($_POST[$key] !== $oldVals[$value])) {
            $returns[] = $key;
        }
    }
    return $returns;
}

/**
 * 获取婚姻关系
 * @author chenxujia
 * @date 2012/03/21
 * @access public
 * @return string
 */
function getIsMarry($num) {
    $marry = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
    if (!in_array($num, $marry)) {
        return false;
    }
    switch ($num) {
        case 0 :
            return '保密'; break;
        case 1 :
            return '单身'; break;
        case 2 :
            return '正在恋爱中';break;
        case 3 :
            return '已订婚'; break;
        case 4 :
            return '已婚'; break;
        case 5 :
            return '关系复杂'; break;
        case 6 :
            return '开放式的交往关系'; break;
        case 7 :
            return '丧偶'; break;
        case 8 :
            return '分居'; break;
        case 9 :
            return '离婚';break;
    }
}

/**
 * 获取post的值
 *
 * @modify bohailiang
 * @date   2012/4/1
 * @param  $keys          array
 * @param  $usefulKeys    array
 * @access public
 * @return true / false
 */
function getKeyVals(array $keys, array $usefulKeys) {
    if (!($keys && $usefulKeys)) {
        return false;
    }
    $keyVals = array();
    foreach ($usefulKeys as $value) {
        $post_value = P($value,FALSE);
        if (isset($keys[$value])) {
            $keyVals[$keys[$value]] = $post_value;
            //vlaue可能是数组 不能简单的用P函数处理
        }
    }
    return $keyVals;
}

/**
 * date 2011-9-22
 * author tianyongchun
 */
function is_email($email) {
    if (preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email) && strlen($email) >= 6 && strlen($email) <= 50) {
        return true;
    }
    return false;
}

/**
 * @author  hujiashan
 * @data    2012/3/23
 * 判断手机号是否正确
 * @param string $mobile
 * 正确 返回true 错误 false
 */
function is_mobile($mobile) {
    return preg_match('/^1[3458][\d]{9}$/', $mobile);
}

/**
 * @author  hujiashan
 * 检查字符串是否是UTF8编码
 * @param string $string
 */
function is_utf8($string) {
    return preg_match('%^(?:
		 [\x09\x0A\x0D\x20-\x7E]            # ASCII
	   | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
	   |  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
	   | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
	   |  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
	   |  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
	   | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
	   |  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
   )*$%xs', $string);
}

/**
 * @author hujiashan
 * 检查字符串是否是中文
 * @param string $string
 */
function is_chinese($string) {

    return preg_match("/^([\x80-\xff])+$/", $string);
}

/**
 * pwd加密
 *
 * @author chenjiali
 * @date 2011/09/17
 * @access public
 * @param $pwd 密码
 */
if (!function_exists('pwd_encrypt')) {

    function pwd_encrypt($pwd = null) {
        if (!$pwd) {
            return false;
        }
        $pwd = round(strlen($pwd) / 4) . $pwd . round(strlen($pwd) / 6);
        $salt = substr($pwd, 0, 2);
        $pwd = md5(crypt($pwd, $salt));
        return $pwd;
    }

}
/**
 * 产生注册邮件认证专用的hashcode
 *
 * @author chenjiali
 * @date 2011/09/07
 * @access public
 * @return string
 */
if (!function_exists('get_hashcode')) {

    function get_hashcode() {
        $chrs = '1234567890qwertyuiopasdfghjklzxcvbnmABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str = "";
        for ($i = 0; $i < 8; $i++) {
            $str .= $chrs{mt_rand(0, strlen($chrs) - 1)};
        }
        $hashcode = md5($str . round(time() / 5) . time());
        return $hashcode;
    }

}

function create_qa_select($selected = '0') {
    $list = array('1' => '填写一部电影', '2' => '填写一个演员', '3' => '填写一个卡通形象', '4' => '填写一首歌曲', '5' => '填写一部电视剧');
    $html = '';
    foreach ($list as $key => $one) {
        if ($key == $selected) {
            $html .= '<option value="' . $key . '" selected>' . $one . '</option>';
        } else {
            $html .= '<option value="' . $key . '">' . $one . '</option>';
        }
    }
    echo $html;
}

/**
 * 取消HTML代码替换原有的htmlspecialchars，支持数组
 * @ pragma string 需要处理的字符串
 * @author fbbin
 */
function shtmlspecialchars($string) {
    if (is_array($string)) {
        foreach ($string as $key => $val) {
            $string[$key] = shtmlspecialchars($val);
        }
    } else {
        //$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1', str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;', '&nbsp;'), $string));
        $string = htmlspecialchars($string);
    }
    //完全过滤JS
    $string = preg_replace('/<script?.*\/script>/', '********', $string);
    return $string;
}

/**
 * 自动创建链接
 * @ pragma string 需要处理的字符串
 * @author fbbin
 */
function autoLink($text, $target = '_blank', $nofollow = true) {
    $urls = autolink_find_URLS($text);
    if (!empty($urls)) {
        array_walk($urls, 'autolink_create_html_tags', array('target' => $target, 'nofollow' => $nofollow));
        $text = strtr($text, $urls);
    }
    return $text;
}

function autolink_find_URLS($text) {
    $scheme = '(http:\/\/|https:\/\/)';
    $www = 'www\.';
    $ip = '\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}';
    $subdomain = '[-a-z0-9_]+\.';
    $name = '[a-z][-a-z0-9]+\.';
    $tld = '[a-z]+(\.[a-z]{2,2})?';
    $the_rest = '\/?[a-z0-9._\/~#&=;%+?-]+[a-z0-9\/#=?]{1,1}';
    $pattern = "$scheme?(?(1)($ip|($subdomain)?$name$tld)|($www$name$tld))$the_rest";
    $pattern = '/' . $pattern . '/is';
    $c = preg_match_all($pattern, $text, $m);
    unset($text, $scheme, $www, $ip, $subdomain, $name, $tld, $the_rest, $pattern);
    if ($c) {
        return (array_flip($m[0]));
    }
    return array();
}

function autolink_create_html_tags(&$value, $key, $other = null) {
    $target = $nofollow = null;
    $url = $key;
    if (strpos($key, 'http://') === false) {
        $url = 'http://' . $key;
    }
    if (is_array($other)) {
        $target = $other['target'] ? " target=\"$other[target]\"" : null;
        $nofollow = $other['nofollow'] ? ' rel="nofollow"' : null;
    }
    $value = "<a href=\"$url\"$target$nofollow>$key</a>";
}

/**
 * @author fbbin
 * 字符串加密、解密函数
 * @param	string	$txt		字符串
 * @param	string	$operation	ENCODE为加密，DECODE为解密，可选参数，默认为ENCODE，
 * @param	string	$key		密钥：数字、字母、下划线
 * @return	string
 */
function sysAuthCode($txt, $operation = 'ENCODE', $key = '!@#$%^&*1QAZ2WSX') {
    $key = $key ? $key : 'HZYEYAOMAI2011';
    $txt = $operation == 'ENCODE' ? (string)$txt : str_replace(array('*', '-', '.'), array('+', '/', '='), base64_decode($txt));
    $len = strlen($key);
    $code = '';
    for ($i = 0; $i < strlen($txt); $i++) {
        $k = $i % $len;
        $code .= $txt[$i] ^ $key[$k];
    }
    $code = $operation == 'DECODE' ? $code : str_replace(array('+', '/', '='), array('*', '-', '.'), base64_encode($code));
    return $code;
}

/**
 * 输出JSON格式字符串
 *
 * @author weijian
 * @param mix $data
 */
function toJSON($data) {
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($data);
    exit ;
}

/**
 * 打印变量
 * @author qianch
 */
function dump($var) {
    echo "<pre>";
    print_r($var);
    echo "</pre>";
}

/*
 *获取封面
 *@author lvxinxin
 */
function getCover($uid) {    
    if (empty($uid))
        return false;
	$cache = get_cache('cover'.$uid);
	if(!empty($cache)){
		return $cache;
	}
    $v = '?v=' . time();
    $CI = get_instance();
	require_cache(APPPATH . 'core' . DS . 'MY_Redis' . EXT);
	require_cache(APPPATH . 'libraries' . DS . 'Storage' . EXT);
	$redis = MY_Redis::getInstance();
	$storage = new Storage();
    $fname = @rtrim($redis -> get('avatar:' . $uid), '.jpg');
    $fpath = 'http://' . config_item('fastdfs_host') . '/' . config_item('fastdfs_group') . '/' . $fname . '_cover.jpg';
    if ($storage -> file_exist(config_item('fastdfs_group'), $fname . '_cover.jpg')) {
        return $storage -> get_file_url($fname, 'cover');
    } else {
        return false;
    }
}

/**
 * 设置应用区关注及粉丝封面
 *
 * @author yangshunjun
 *
 * @param integer $followid 关注人id
 * @param integer $fansid 被关注人id
 *
 *
 */
function setFollowsCover($followid, $fansid) {
    if (!$followid || !$fansid) {
        return false;
    }

    //判断两用户是否为关注

    //	$relation = call_soap('social', 'Social', 'getRelationWithUser', array('uid1' => $followid, 'uid2' => $fansid));
    //
    //	if(!in_array($relation, array(2, 3))){
    //		return false;
    //	}

    //关注菜单ID
    $follow_menuid = 2;

    //粉丝菜单ID
    $fans_menuid = 4;
    $head_pic = array();
    $fans_head_pic = array();

    //获取关注最新六人头像信息
    $follow_list = call_soap('social', 'Social', 'getFollowingsWithInfo', array('uid' => $followid, 'self' => true, 'offset' => 1, 'limit' => 6));

    if (is_array($follow_list)) {
        foreach ($follow_list AS $key => $val) {
            $head_pic[] = get_avatar($val['id'], 'ss');
        }
    }
    $files = array('file' => $head_pic, 'type' => 1, 'userid' => $followid, 'menuid' => $follow_menuid);

    call_soap('ucenter', 'UserMenuCover', 'mergeImages', $files);

    //获取粉丝最新六人头像信息
    $fans_list = call_soap('social', 'Social', 'getFollowers', array('uid' => $fansid, 'offset' => 1, 'limit' => 6));

    if (is_array($fans_list)) {
        foreach ($fans_list AS $key => $val) {
            $fans_head_pic[] = get_avatar($val, 'ss');
        }
    }
    $data_fans = array('file' => $fans_head_pic, 'type' => 1, 'userid' => $fansid, 'menuid' => $fans_menuid);

    call_soap('ucenter', 'UserMenuCover', 'mergeImages', $data_fans);

    return true;
}

function logging($var, $label = 'Test Vars') {
    static $logger;
    if (empty($logger)) {
        require_cache(APPPATH . 'core' . DS . 'FirePHP' . EXT);
        $logger = FirePHP::getInstance(true);
    }
    $logger -> info($var, $label);
}

/**
 * 截取长度
 *
 * Enter description here ...
 * @author liuGC
 * @param string $src
 * @param int $cutlength
 * @param string $dot
 */
function getStringSplicedByChar($src, $cutlength, $dot) {
    $ret = '';
    $i = $n = $ulen = 0;
    $strlen = strlen($src);
    while (($n < $cutlength) && ($i <= $strlen)) {
        $temp = substr($src, $i, 1);
        $ascnum = ord($temp);
        if ($ascnum >= 224) {
            $ret = $ret . substr($src, $i, 3);
            $i += 3;
            $n++;
        } else if ($ascnum >= 192) {
            $ret = $ret . substr($src, $i, 2);
            $i += 2;
            $n++;
        } else if ($ascnum >= 65 && $ascnum <= 90) {
            $ret = $ret . substr($src, $i, 1);
            $i++;
            $n++;
        } else {
            $ret = $ret . substr($src, $i, 1);
            $i++;
            $n += 1;
            //0.5;
        }
    }
    if (strcmp($src, $ret))
        $ret .= $dot;
    return $ret;
}

/**
 *
 * authcode 加密解密
 *
 * @author wangying
 *
 * @param string $string 加密字符串
 * @param string operation 默认解密'DECODE'标识
 * @param string $key 密钥
 * @param int $expiry 有效期
 * @return string
 */
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    $ckey_length = 4;
    $key = md5($key);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';
    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc . str_replace('=', '', base64_encode($result));
    }
}

/**
 * @author guosb
 * 文本截取
 *
 * @param	$content	需要替换的文本
 * @param	$maxlen		截取长度
 * @param	$charset	字符串编码
 *
 * @return	array(截取后的字符串,处理结果)
 */
if (!function_exists('htmlSubString')) {

 function htmlSubString($content, $maxlen=200, $charset="UTF-8") {

        $curlength = 0;
        $Tags = array();
        $outstr = '';
        $cut = false;
        $tempv = '';
        //把字符按HTML标签变成数组。
        //add start 1.0(by jiangfangtao 2012/04/26)
        //获取需要截取的内容的长度
        $contentLength=strlen($content);
        
        for ($i = 0; $i < $contentLength; $i++) {
       //add end 1.0(by jiangfangtao)
            $letter = $content{$i};
            //如果内容中没有html等标记
            if ($letter != '<' && $letter != '>') {
                $tempv.=$letter;
            } else {
            	
                if ($letter == '<' && $content{$i + 1} !== ' ') {
                	//如果标记前面已经有文字内容，而不是html内容
                    if (trim($tempv) != '') {
                        $contents[] = $tempv;
                    }
                    $tempv = $letter;
                } elseif ($letter == '>' && $tempv{0} == '<') { //标记结束
                    $tempv.=$letter;
                    if (trim($tempv) != '') {
                        $contents[] = $tempv;
                    }
                    $tempv = '';
                } else {
                    $tempv.=$letter;
                }
            }
        }
        if (trim($tempv) !== '') {
            $contents[] = $tempv;
        }
        
        
        if ($contents) {
            foreach ($contents as $key=>$value) {
                if($contents[$key]==""){
                  unset($contents[$key]);
                }
                if (preg_match('/<\S[^<>]*?>/si', $value)) { //处理标记
                    if (substr($value, 0, 2) == '</') {
                        $endTag = substr($value, 2, strlen($value) - 3);
                        if (count($Tags) < 1) {
                            $outstr.='<' . $endTag . '>' . $value; //纠正错误标记
                            continue;
                        } //丢弃错误结束标记
                        $tagName = array_pop($Tags);
                        while ($tagName != $endTag && $tagName !== '') {
                            $outstr.="</" . $tagName . ">";
                            if (count($Tags) > 0) {
                                $tagName = array_pop($Tags);
                            } else {
                                $tagName = '';
                            }
                        }
                        $outstr.=$value;
                    } elseif (substr($value, 0, 3) == '</ ') { //处理'</ '这样的错误标记
                        $outstr.=$value;
                        continue;
                    } else {
                        //取得起始标记
                        if (strpos($value, ' ') !== false) {
                            $tagName = substr($value, 1, strpos($value, ' ') - 1);
                        } else {
                            $tagName = substr($value, 1, -1);
                        }
                        //压入标记到堆栈，并添加到返回字符串
                        array_push($Tags, $tagName);
                        $outstr.=$value;
                    }
                } else { //处理内容
                    $curlength+=mb_strlen($value, $charset);

                    if ($maxlen <= $curlength) {
                        if ($maxlen < $curlength) { //规避特殊标记内容不允许截断
                            if (count($Tags) > 0 && preg_match('/object|iframe|script|embed/is', $Tags[count($Tags) - 1])) {
                                $outstr.=$value;
                            } else {
                                $outstr.=mb_substr($value, 0, $maxlen - $curlength, $charset);
                            }
                        } else {
                            $outstr.=$value;
                        }
                        while (count($Tags) > 0) {
                            $tagName = array_pop($Tags);
                            $outstr.="</" . $tagName . ">";
                        }
                        $cut = true;
                        break;
                    } else {
                        $outstr.=$value;
                        continue;
                    }
                }
            }
        }
        return array($outstr, $cut);
 	}
}
    /*
     * 截取中文字符串，超过长度用....代替
     * @ auth  liyd
     * */
    function utf8substr($string = '', $from = 0, $len = 0, $dot = '...') {
        if (empty($string)) {
            return $string;
        }
        $str_mode = '#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $from . '}' . '((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,' . $len . '}).*#s';
        $substr = preg_replace($str_mode, '$1', $string);
        if (mb_strlen($substr, 'UTF8') < mb_strlen($string, 'UTF8')) {
            $substr .= $dot;
        }
        return $substr;
    }

    function getShotRes($str = ''){
        if (empty($str)) {
            return '';
        }
        $arr = explode(' ', $str);
        array_shift ( $arr );
	$str = implode ( ' ', $arr );
	return $str;
}

/**
 * 格式化时间
 * @param array $datetime 时间信息
 * @param string $format 格式化模板
 * @return string
 */
function parseTime($strtime) {
	$time = floatval($strtime);
	$rev_strtime = strrev($strtime);

    $datetime = array(
        'year' => strrev(substr($rev_strtime, 10, strlen($strtime) - 10)),
        'month' => strrev(substr($rev_strtime, 8, 2)),
        'month2' => intval(strrev(substr($rev_strtime, 8, 2))),
        'day' => strrev(substr($rev_strtime, 6, 2)),
        'hour' => strrev(substr($rev_strtime, 4, 2)),
        'minute' => strrev(substr($rev_strtime, 2, 2)),
        'second' => strrev(substr($rev_strtime, 0, 2)),
    );
    
    if ($time > 0) {
        $datetime['bc'] = 0;
    } elseif ($time < 0) {
        $datetime['bc'] = 1;
    } else {
        return false;
    }
    return $datetime;
}

function formatTime($datetime, $format = false) {
    if (isset($datetime['bc']) && $datetime['bc']) {
        //公元前
		$format = $format == false ? 'Y/m/d' : $format;
		//时间格式化的映射 Y m d H i s
		$maps = array('Y' => 'year', 'm' => 'month', 'n' => 'month2', 'd' => 'day');
    } else {
        //公元
        if ($format === false) {
            $format = $datetime['hour'] . $datetime['minute'] == '0000' ? 'Y年m月d日' : 'Y年m月d日H:i';
        }
        //时间格式化的映射 Y m d H i s
		$maps = array('Y' => 'year', 'm' => 'month', 'n' => 'month2', 'd' => 'day', 'H' => 'hour', 'i' => 'minute', 's' => 'second');
    }
    
	//统计执行格式化信息
	$map_values = array();
	foreach ($maps as $key => $map) {
		$map_values[$key] = $datetime[$map];
	}
	//格式化信息并返回
	return str_replace(array_keys($maps), $map_values, $format);
}

function makeFriendlyTime($strtime) {
    $val = floatval($strtime);
    $val = abs($val);
    if (strlen(strval($val)) <= 10) {
        return friendlyDate($strtime);
    }
    
	$datetime = parseTime($strtime);
	$year = floatval($datetime['year']);

	if ($year < 0) {
		$year = 0 - $year;
		$start = '公元前';
		if ($year >= 10000 && $year <= 99990000) {
			$num = $year / 10000;
			$end = '万年';
		} else if ($year >= 100000000 && $year <= 999900000000) {
			$num = $year / 100000000;
			$end = '亿年';
		} else {
			$num = $year;
			$end = '年';
		}
        
        $month = floatval($datetime['month2']);
        $tail = $month > 1 ? $month . '月' : '';
        
        $day = floatval($datetime['day']);
        $tail .= $day > 1 ? $day . '日' : '';
        
		return $start . $num . $end . $tail;
	} else if ($year > 0) {
		$now = time();
		if ($datetime['year'] == date('Y', $now)) {
			$inhand = strtotime(formatTime($datetime, 'Ymd H:i:s'));
			$seconds = $now - $inhand;
			$abs_seconds = abs($seconds);
			if ($seconds >= 0) {
				//before
				return expressBefore($datetime, $abs_seconds);
			} else if ($seconds < 0) {
                return '刚刚';
				//after
				//return expressAfter($datetime, $abs_seconds);
			}
		} else {
			if (($datetime['hour'] . $datetime['hour'] . $datetime['hour']) == '000000') {
				return formatTime($datetime, 'Y年m月d日');
			}
			return formatTime($datetime);
		}
	}
	return false;
}

function expressBefore($datetime, $seconds) {
	if ($seconds > 0 && $seconds < 10) {
        //刚刚
        $num = '';
        $end = '刚刚';
    } else if ($seconds >= 10 && $seconds < 60) {
		//秒
		$num = $seconds;
		$end = '秒前';
	} else if ($seconds >= 60 && $seconds < 3600) {
		//分钟
		$num = intval($seconds / 60);
		$end = '分钟前';
	} else if ($seconds >= 3600 && $seconds < 86400) {
		//小时
		$num = intval($seconds / 3600);
		$end = '小时前';
	} else if ($seconds >= 86400 && $seconds < 172800) {
		//昨天
		$num = '';
		$end = '昨天 ' . formatTime($datetime, 'H:i');
	} else if ($seconds >= 172800 && $seconds < 259200) {
		//前天
		$num = '';
		$end = '前天 ' . formatTime($datetime, 'H:i');
	} else {
		return formatTime($datetime);
	}
	return $num . $end;
}

function expressAfter($datetime, $seconds) {
	if ($seconds > 0 && $seconds < 60) {
		//秒
		$num = $seconds;
		$end = '秒后';
	} else if ($seconds >= 60 && $seconds < 3600) {
		//分钟
		$num = intval($seconds / 60);
		$end = '分钟后';
	} else if ($seconds >= 3600 && $seconds < 86400) {
		//小时 今天
		$num = intval($seconds / 3600);
		if ($num > 3) {
			$num = '';
			$end = '今天';
		} else {
			$end = '小时后';
		}
	} else if ($seconds >= 86400 && $seconds < 172800) {
		//明天
		$num = '';
		$end = '明天 ' . formatTime($datetime, 'H:i');
	} else if ($seconds >= 172800 && $seconds < 259200) {
		//后天
		$num = '';
		$end = '后天 ' . formatTime($datetime, 'H:i');
	} else {
		return formatTime($datetime);
	}
	return $num . $end;
}




