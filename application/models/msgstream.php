<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @deprecated 取得关注和好友信息
 * 
 * @author 周天良
 * @date 2012/03/08
 */
require_cache(APPPATH . 'core' . DS . 'MY_RedisModel' . EXT);

class Msgstream extends MY_RedisModel {

    public static $max = 14;
    public $count = 0;
    public $pagecount = 1;
    public $limit=1;
    public $uid = null;
    public function __construct() {

        parent::__construct();
    }

    //关注页面好友信息
    public function getFansFriendsMsg($uid, $limit = 1, $type = 'fans_frisInfos') {

        return $this->getPageMsg($uid, $limit, $type);
    }

    //关注页面个人全部信息
    public function getAllMsg($uid, $limit = 1, $type = 'fansInfos') {


        return $this->getPageMsg($uid, $limit, $type);
    }

    //关注页面 互相关注信息
    public function getMutualFollowMsg($uid, $limit = 1, $type = 'fans_bothInfos') {


        return $this->getPageMsg($uid, $limit, $type);
    }

    //好友页面 所以信息
    public function getFriendsMsg($uid, $limit = 1, $type = 'frisInfos') {

        return $this->getPageMsg($uid, $limit, $type);
    }


    /**
     * @author 周天良
     * @param $uid string  用户ID
     * @param $type string  信息类型 friInfos为好友信息  attenInfos为关注息
     * @return array 所年月的对应的总和
     */
    //计算总数有多少年月


    public function allRsort($uid, $type) {

        $allyearmonth = array();
        if (empty($allyearmonth)) {
            $allyearmonth = $this->_redis->hgetall("Info:$uid:$type");
            krsort($allyearmonth, SORT_NUMERIC);
        }
        return $allyearmonth;
    }

    /**
     * @param $uid string 
     * @param $limit int 页数
     * @param $type string 同上
     * @return json 返回信息
     */
    //分页取得信息
    private function getPageMsg($uid, $limit = 1, $type = '') {
    	logging(microtime());
        if ($type == FALSE || empty($type)) return json_encode(array('data' => null, 'status' => 0,'msg'=>'非法操作'));
        //    return false;
        $arr = $this->allRsort($uid, $type);
        if (empty($arr)) return json_encode(array('data' => null, 'status' => 0,'msg'=>'没有信息'));
        //    return false;
        $this->count = array_sum($arr);
        //算出总数
        $this->limit = $limit; //当前页数
        $this->pagecount = ceil($this->count / self::$max); //算出页数

        $startcount = ($limit * self::$max) - self::$max;
        //起始数量位置
        $endcount = $limit * self::$max;
        //结束数量位置
        $this->uid = $uid;
        if ($limit > $this->pagecount)
            return json_encode(array('data' => null, 'status' => 0,'msg'=>'没有信息'));
            //return false; //传过来的页数 大于总页数了 直接返回
        if ($startcount > $this->count)
            return json_encode(array('data' => null, 'status' => 0,'msg'=>'没有信息'));
            //return false; //开始位置不可能大于总数的

        $allyear = $this->Arithmetic($startcount, $endcount, $arr);

        $middleyear = $this->sumyear($allyear, $arr);

        return $this->mergedata($allyear, $middleyear, $uid, $type);
    }

    //取得消息ID
    public function mergedata($allyear, $middleyear, $uid, $type) {
        $arrid = array();
        if ($type == 'fansInfos') {
            $t = 'fans';
        } elseif ($type == 'fans_bothInfos') {
            $t = 'fans_both';
        } elseif ($type == 'fans_frisInfos') {
            $t = 'fans_fris';
        } elseif ($type == 'frisInfos') {
            $t = 'fris';
        }
         // var_dump($allyear);
        if ($allyear['start_year']['year'] == $allyear['end_year']['year']) {
            //按大到小取出数据 
            $arrid = $this->_redis->zrevrange("Info:$uid:$t:" . $allyear['start_year']['year'], $allyear['start_year']['offset'], self::$max + $allyear['start_year']['offset'] - 1);
        }


        if (empty($middleyear)) {

            $this->_redis->zunionstore("Info:$uid:all:content", array("Info:$uid:$t:" . $allyear['start_year']['year'], "Info:$uid:$t:" . $allyear['end_year']['year']));
            //合并两年月 
            // var_dump($this->_redis->ZREVRANGE("Info:$uid:$t:" . $allyear['start_year']['year'], 0, -1));
            //  var_dump($this->_redis->ZREVRANGE("Info:$uid:$t:" . $allyear['end_year']['year'], 0, -1));

            $arrid = $this->_redis->ZREVRANGE("Info:$uid:all:content", $allyear['start_year']['offset'], self::$max + $allyear['start_year']['offset'] - 1);

            $this->_redis->del("Info:$uid:all:content"); //删除临时数据
        } else {

            for ($i = 0; $i < count($middleyear); $i++) {

                $arr[] = "Info:$uid:$t:" . $middleyear[$i];
            }

            array_push($arr,"Info:$uid:$t:" . $allyear['start_year']['year']);
			array_unshift($arr,"Info:$uid:$t:" . $allyear['end_year']['year']);
            //$im = implode(",", $arr);

            $this->_redis->zunionstore("Info:$uid:all:contents", $arr);
            // echo self::$max+ $allyear['start_year']['offset'];
            $arrid = $this->_redis->ZREVRANGE("Info:$uid:all:contents", $allyear['start_year']['offset'], self::$max + $allyear['start_year']['offset'] - 1);

            $this->_redis->del("Info:$uid:all:contents"); //删除临时数据
        }
         //var_dump($arrid);
        return $this->msgidcontent($arrid);
    }

    //基本算法
    private function Arithmetic($start, $endcount, $arr) {

        $arryear = array();
        $endyear = $arr;
        $startyear = $arr;
        $keys = array_keys($arr);
        $values = array_values($arr);

        if ($start === 0 or $start == 0) {

            $arryear['start_year']['year'] = $keys[0];
            $arryear['start_year']['offset'] = 0;
        } else {
            if ($arr[$keys[0]] >= $start) {
                $arryear['start_year']['year'] = $keys[0];
                $arryear['start_year']['offset'] = $start;
            } else {

                $arryear = $this->recursion($start, $startyear, 0, $startyear);
            }
        }
        if ($arr[$keys[0]] > $endcount) {
            $arryears['end_year']['year'] = $keys[0];
        } else {
            if ($endcount > $this->count) {

                $arryears['end_year']['year'] = array_pop($keys); //$endyear[count($keys)-1]; //如果结束位置大于总数 就把结束位置等于最后一年的			   
            } else {

                $arryears = $this->endyear($endcount, $endyear, 0, $endyear);
            }
        }

        return array_merge($arryear, $arryears);
    }

    //计算结束年月
    private function endyear($endcount, $arr, $count = 0, $tarr) {

        static $static = 0;
        $arryear = array();
        $tkeys = array_keys($tarr);
        $keys = array_keys($arr);
        $values = array_values($arr);
        $i = 0;
        if ($count + $arr[$keys[$i]] >= $endcount) {

            $arryear['end_year']['year'] = $tkeys[$static];
            //$arryear['start_year']['offset'] = $start - $count;
            $static = 0;
            return $arryear;
        } else {
            $counts = $count + $arr[$keys[$i]];

            $static++;
            array_shift($arr);
            return $this->endyear($endcount, $arr, $counts, $tarr);
        }
    }

    //计算开始年月和偏移量
    private function recursion($start, $arr, $count = 0, $tarr) {
        static $static = 0;
        $arryear = array();
        $tkeys = array_keys($tarr);
        $keys = array_keys($arr);
        $values = array_values($arr);
        $i = 0;
        if ($count + $arr[$keys[$i]] >= $start) {

            $arryear['start_year']['year'] = $tkeys[$static];
            $arryear['start_year']['offset'] = $start - $count;
            $static = 0;
            return $arryear;
        } else {
            $counts = $count + $arr[$keys[$i]];

            $static++;
            array_shift($arr);

            return $this->recursion($start, $arr, $counts, $tarr);
        }
    }

    //计算两年月之间的所有年月
    private function sumyear($arryear, $arr) {

        $keys = array_keys($arr);

        $returnarr = array();

        for ($i = 0; $i < count($keys); $i++) {

            if ($keys[$i] < $arryear['start_year']['year'] && $keys[$i] > $arryear['end_year']['year']) {
                $returnarr[] = $keys[$i];
            }
        }
        return $returnarr;
    }

    //计算对应ID的信息
    public function msgidcontent($arr = array(),$count=false) {

        if (empty($arr)) {
            
             return json_encode(array('data' => null, 'status' => 1,'msg'=>'没有信息'));
        }
         
        $len = count($arr);
        $content = array();
        $multi = $this->_redis->multi(); //redis事务处理 一次取出来
        for ($i = 0; $i < $len; $i++) {
            $multi->hgetall("Topic:$arr[$i]");
        }
        $content = $multi->exec();
        for($i =0;$i<$len;$i++) {
            if(empty($content[$i])) { 
            
                unset($content[$i]);
            
            }
            if(isset($content[$i]['dateline'])) {
            $ctime = friendlyDate($content[$i]['dateline']);
            $content[$i]['friendly_time'] = $ctime;
            }
            if(isset($content[$i]['type'])) {
	            if($content[$i]['type']=='album') {
		             if(isset($content[$i]['picurl'])) {
		                  $content[$i]['picurl'] = json_decode($content[$i]['picurl'],true);
		             }
	            }
                if($content[$i]['type']=='event') {
                     if(isset($content[$i]['starttime']) && !empty($content[$i]['starttime'])) {
                          $content[$i]['starttime'] =  friendlyDate($content[$i]['starttime']);
                     }
                }
                if($content[$i]['type']=='ask') {
                     if(isset($content[$i]['answerlist'])&& !empty($content[$i]['answerlist'])) {
                          $content[$i]['answerlist'] = json_decode($content[$i]['answerlist'],true);                       
                     }
                }
                if($content[$i]['type']=='forward') {
                //处理转发数据
                    $get_fid = $content[$i]['fid'];
                    $get_forward = $this->_redis->hgetall("Topic:{$get_fid}");
                    if(!empty($get_forward)) {
                        $content[$i]['forward'] = $get_forward;
                    }
                    if(isset($content[$i]['forward']['type']) && $content[$i]['forward']['type']=='album') {
                        $content[$i]['forward']['picurl'] = json_decode($content[$i]['forward']['picurl'],true);
                    }
                    if(isset($content[$i]['forward']['type']) && $content[$i]['forward']['type']=='ask') {
                         if(isset($content[$i]['forward']['answerlist'])&& !empty($content[$i]['forward']['answerlist'])) {
                              $content[$i]['forward']['answerlist'] = json_decode($content[$i]['forward']['answerlist'],true);                       
                         }

                    }
                
                }
            }
            
            if(isset($content[$i]['uid'])) { //获取信息流 的头像地址
                
                if($content[$i]['uid']>0){
                     $get_headimage = get_avatar($content[$i]['uid']);
                
                     $content[$i]['headpic'] = $get_headimage;
                }
            }
            
            
            if(isset($content[$i]['type']) && $content[$i]['type']=='uinfo'){
                //过滤不要的时间线要的信息不要的信息
                unset($content[$i]);
                
            }

        }


    logging(microtime());
          if($count==false){
          
            if(($this->count - ($this->limit * self::$max)) <= 0 ) {
            
               $msg = true;
            
            } else {
               $msg = false;  //判断是否还有下一页;  
            }            
            return json_encode(array('data' => array_values($content), 'status' => 1,'isend'=>$msg));
          
          }else{
            
            
            return json_encode(array('data' => $content,'status'  => 1,'ltime'=>SYS_TIME));
          }
    }
     
    /**
     * @author 周天良
     * @data 2012/03/08
     * @param $uid int 用户ID
     * @param $yearmonth int 特定的年月
     * @param $limit int   取第几页
     * @param @msgtype  string 消息类型  好友(fri) 还是 关注{atten}
     * @return JSON  
     */
    //取一个月的数据
    public function readSingleYearData($uid, $yearmonth, $limit = 1, $msgtype = 'fans') {
        if (!$uid || !$yearmonth)
            return FALSE;
        switch ($msgtype){

        case 'fans': //关注页面
            $msgtypes = 'fansInfos'; 
            break; 
        case 'fris':    //好友页面的信息
            $msgtypes = 'frisInfos';
            break;
        case 'fans_both' : //关注页面 互相关注的信息
            $msgtypes = 'fans_bothInfos';
            break;
        case 'fans_fris': //关注页面 是好友的信息
            $msgtypes = 'fans_frisInfos';
            break;
        default :
            $msgtype = 'fans';
            $msgtypes = 'fansInfos';

        }  
        if ($this->_redis->HEXISTS("Info:$uid:$msgtypes", $yearmonth)) { //判断这个月有没有
            $yearcount = $this->_redis->hget("Info:$uid:$msgtypes", $yearmonth);
        } else {
            return false;
        }
        $this->count = $yearcount;
        $this->pagecount = ceil($yearcount / self::$max);


        if ($limit > $this->pagecount)
            $limit = 1;

        $arrdata = $this->_redis->ZrevRange("Info:$uid:$msgtype:$yearmonth", (self::$max * $limit) - self::$max, self::$max * $limit);
        //偏移量  起始位置 是 页数*分页数量-分页数量 结束位置 页数*分页数量

        return $this->msgidcontent($arrdata);

        //$data = $this->msgidcontent($arrdata);
    }
    
           //获取时间段的总数
    public function getTimeCount($uid,$msgtype='fans',$ctime=0) {

        if(empty($uid) || empty($msgtype))  return json_encode(array('count'=>0,'status'=>0));
        
        switch($msgtype){
            
            case 'fans':
               $key = "Info:$uid:fans:".date("Ym"); //个人全信息
            break;
            case 'fans_both':
               $key = "Info:$uid:fans_both:".date("Ym"); //个人相互关注
            break;
            case 'fans_fris':
               $key = "Info:$uid:fans_fris:".date("Ym"); //个人好友
            break;
            case 'fris':
               $key = "Info:$uid:fris:".date("Ym"); //好友
            break;
            default:
               $key='';
            
        }
        if(empty($key)) return json_encode(array('count'=>0,'status'=>0));
        
       
        
        $arr = $this->_redis->zrangebyscore($key,$ctime, SYS_TIME);
          
        $count = count($arr);
        if($count>0){ 
        	for($i=0;$i<$count;$i++) {
        		$content[$i] = $this->_redis->hgetall("Topic:$arr[$i]");
        		if($content[$i]['uid']==$uid) {
        			unset($arr[$i]);
        		}
        	}
        	$count = count($arr);
        	if($count>0){
                return json_encode(array('count'=>$count,'status'=>1,'ctime'=>SYS_TIME,'topicid'=>$arr));
        	}else {
        		return json_encode(array('count'=>0,'status'=>1,'ctime'=>SYS_TIME));
        	}
        }else{
            
        return json_encode(array('count'=>0,'status'=>1,'ctime'=>SYS_TIME));
        }
        
    }
    //获取时间段的内容
    public function getTimeContent($uid,$msgtype='fans',$ctime=0){
        
        if(empty($uid) || empty($msgtype))  return json_encode(array('data'=>null,'status'=>0));
        
        switch($msgtype){
            
            case 'fans':
               $key = "Info:$uid:fans:".date("Ym"); //个人全信息
            break;
            case 'fans_both':
               $key = "Info:$uid:fans_both:".date("Ym"); //个人相互关注
            break;
            case 'fans_fris':
               $key = "Info:$uid:fans_fris:".date("Ym"); //个人好友
            break;
            case 'fris':
               $key = "Info:$uid:fris:".date("Ym"); //好友
            break;
            default:
               $key='';
            
        }
        
        if(empty($key)) return json_encode(array('data'=>null,'status'=>0));
        
        
        $arr = $this->_redis->zrangebyscore($key,$ctime, '+inf');
        $count = count($arr);
        if($arr){  
        	for($i=0;$i<$count;$i++) {
        		$content[$i] = $this->_redis->hgetall("Topic:$arr[$i]");
        		if($content[$i]['uid']==$uid) {
        			unset($arr[$i]);
        		}
        	}
        	//logging($arr);
        	if($arr) {
                return $this->msgidcontent($arr,true);
        	}else {
        		return json_encode(array('data'=>null,'status'=>1,'ltime'=>SYS_TIME));
        	}
        }else{
            
        return json_encode(array('data'=>null,'status'=>1,'ltime'=>SYS_TIME));    
        }           
    }
    
//     public function test(){
    	
//     	$time=strtotime("2012-03-09");
    	
//     	for($i=0;$i<25;$i++) {
    		
//     		$this->_redis->zADD("Info:1000001000:fans:201203",$time--,$i);
    		
//     	}
//     }

}

?>
