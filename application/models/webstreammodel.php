<?php

/*
 * 关于网页信息流动读取到个人关注的信息模型
 * 
 */

/**
 * Description of webstreammodel
 *
 * @author zhoutiangliang
 */
require_cache(APPPATH . 'core' . DS . 'MY_RedisModel' . EXT);
class Webstreammodel  extends MY_RedisModel {
    //put your code here
    public static $max   = 14;
    public $count        = 0;
    public $pagecount    = 1;
    public $limit        = 1;
    private $uid         = null;
    private $infos       = null;
    private $tagid       = null;
    private $start_index = 0; //起始索引位置
    private $end_index   = 0;   //结束索引位置
    private $year_info   = null;
    public function __construct() {
        parent::__construct();
    }
    public function getWebMsg($uid,$tagid,$limit=1) {
        $this->uid = $uid;
        $this->tagid = $tagid;
        $this->limit = $limit;
        $this->infos = "Info:$uid:$tagid:infos";  
        $this->year_info = "Info:$uid:$tagid:";
        
        return $this->getAllMsg();
    }
        /**
     * @author 周天良
     * @param $uid string  用户ID
     * @param $type string  信息类型 friInfos为好友信息  attenInfos为关注息
     * @return array 所年月的对应的总和
     */
    //计算总数有多少年月


    public function allRsort() {

        $allyearmonth = array();
        if (empty($allyearmonth)) {
            $allyearmonth = $this->_redis->hgetall($this->infos);
            krsort($allyearmonth, SORT_NUMERIC);
        }
        return $allyearmonth;
    }//获取全部数据
    public function getAllMsg() {
    	logging(microtime());
        if(empty($this->uid) || empty($this->tagid)) {
             return json_encode(array('data' => null, 'status' => 0,'msg'=>'非法操作'));
        }
        $arr = $this->allRsort();//获取所有年月;
        if(empty($arr)) {
             return json_encode(array('data' => null, 'status' => 0,'msg'=>'没有信息'));
        }
        $this->count = array_sum($arr);
        //算出总数
        $this->pagecount  = ceil($this->count / self::$max);
        //算出页数
        $this->start_index = ($this->limit * self::$max) - self::$max;
        //开始位置
        $this->end_index   = $this->limit * self::$max;
        
        if ($this->limit > $this->pagecount) {
            return json_encode(array('data' => null, 'status' => 0,'msg'=>'没有信息'));
            //return false; //传过来的页数 大于总页数了 直接返回
        }
        
        if ($this->start_index > $this->count) {
            return json_encode(array('data' => null, 'status' => 0,'msg'=>'没有信息'));
            //return false; //开始位置不可能大于总数的
        }
        $allyear = $this->Arithmetic($this->start_index, $this->end_index, $arr);
     
        return $this->mergedata($allyear,$this->uid);
    }
    
    //基本算法
    private function Arithmetic($start, $end, $arr) {

        $arryear   = array();
        $keys      = array_keys($arr); //有可能
        $arr_keys  = array_keys($arr);
        $len       = count($arr);
        
        if ($start === 0 or $start == 0) {
            $arryear['start_year']['year'] = $keys[0];
            $arryear['start_year']['offset'] = 0;
        } else {
            if ($arr[$keys[0]] >= $start) {
                $arryear['start_year']['year'] = $keys[0];
                $arryear['start_year']['offset'] = $start;
            }
        }
        if ($arr[$keys[0]] >= $end) {
            $arryear['end_year']['year'] = $keys[0];
        } else {
            if ($end > $this->count) {
                $arryear['end_year']['year'] = array_pop($keys); //$endyear[count($keys)-1]; //如果结束位置大于总数 就把结束位置等于最后一年的			   
            }
        }
        //如果开始年月不在第一个数据上面 或 结束年月不在第一个上面就执行下面
        /*修改优化算法 修改之后 */
        if(isset($keys[0])) {
	        if($start > $arr[$keys[0]] || $end  > $arr[$keys[0]]) {
	            $i_end   = 0;
	            $i_begin = 0;
	        	for($i = 0; $i<$len; $i++) {
	        		$i_end   = $i_end + $arr[$arr_keys[$i]];
        		    $i_begin = $i_begin + $arr[$arr_keys[$i]];
        		    if($i_begin >= $start) {
        		  	    if(!isset($arryear['start_year']['year'])) {
        		  	   	    $arryear['start_year']['year']   = $arr_keys[$i];
        		  	   	    $arryear['start_year']['offset'] = $arr[$arr_keys[$i]] - ($i_begin - $start);
        		  	    }
        		    }
	        		if($i_end < $end ) {
	        		    if(isset($arryear['start_year']['year']) && $arr_keys[$i] < $arryear['start_year']['year']) {
	                        if(!isset($arryear['end_year']['year']) or isset($arryear['end_year']['year']) && $arryear['end_year']['year'] < $arr_keys[$i]) {
	        		  	   	    $arryear['middle_year'][] = $arr_keys[$i];
	        		  	   	}
	        		  	}
	        		} else {
	        		  	if(!isset($arryear['end_year']['year'])) {
	        		  	    $arryear['end_year']['year'] = $arr_keys[$i];
	        		  	}
	        		}
	        		
	        	}
	        	
	        }
        }

        return $arryear;
    }
 

     //取得消息ID
    private function mergedata($allyear,$uid) {
        $arrid = array();
        logging($allyear);
        if ($allyear['start_year']['year'] == $allyear['end_year']['year']) {
            //按大到小取出数据 
            $arrid = $this->_redis->zrevrange($this->year_info . $allyear['start_year']['year'], $allyear['start_year']['offset'], self::$max + $allyear['start_year']['offset'] - 1);
        }
        if (!isset($allyear['middle_year']) || empty($allyear['middle_year'])) {
            $this->_redis->zunionstore("Info:$uid:all:content", array($this->year_info . $allyear['start_year']['year'], $this->year_info . $allyear['end_year']['year']));
            $arrid = $this->_redis->ZREVRANGE("Info:$uid:all:content", $allyear['start_year']['offset'], self::$max + $allyear['start_year']['offset'] - 1);
            $this->_redis->del("Info:$uid:all:content"); //删除临时数据
        } else {
            $i_len = count($allyear['middle_year']);
            for ($i = 0; $i < $i_len; $i++) {
                $arr[] = $this->year_info . $allyear['middle_year'][$i];
            }
            array_unshift($arr, $this->year_info . $allyear['start_year']['year']);
            array_push($arr,$this->year_info . $allyear['end_year']['year']);
            $this->_redis->zunionstore("Info:$uid:all:contents", $arr);
            $arrid = $this->_redis->ZREVRANGE("Info:$uid:all:contents", $allyear['start_year']['offset'], self::$max + $allyear['start_year']['offset'] - 1);
            $this->_redis->del("Info:$uid:all:contents"); //删除临时数据
        }
        logging($arrid);
        return $this->msgidcontent($arrid);
    }
    //计算对应ID的信息
    public function msgidcontent($arr = array(),$count=false) {

        if (empty($arr)) {
            
             return json_encode(array('data' => null, 'status' => 0,'msg'=>'没有信息'));
        }
         
        $len = count($arr);
        $content = array();
        $info = array();
        
        $multi = $this->_redis->multi();//redis事务处理 一次取出来
        for($i=0;$i<$len;$i++) {
        	$multi->hgetall("Webtopic:$arr[$i]");
        }
        $content = $multi->exec();
        
        for ($i = 0; $i < $len; $i++) {

            if(empty($content[$i]) && isset($content[$i])) {
            
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
            
            if(isset($content[$i]['pid'])) { //获取信息流 的头像地址
                
                if($content[$i]['pid']>0){
                     $get_headimage = get_webavatar($content[$i]['uid'],'s',$content[$i]['pid']);
                
                     $content[$i]['headpic'] = $get_headimage;
                
                      //加上web地址 
                     $content[$i]['web_url'] =rtrim(WEB_DUANKOU_ROOT,'/') .'/main/?web_id='.$content[$i]['pid'];
                }
                
            }
            
            
            if(isset($content[$i]['type']) && ($content[$i]['type']=='uinfo')){
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
    public function getTimeCount($uid,$tagid,$ctime=0) {
    	$this->year_info = "Info:$uid:$tagid:".date("Ym");
    	if($ctime===0) {
    		$ctime=time();
    	}
    	$t_arr = $this->_redis->zrangebyscore($this->year_info,$ctime,SYS_TIME);
    	
    	
    	
    	$count = count($t_arr);
    	if($count>0){
    	
    		for($i=0;$i<$count;$i++) {
    			$content[$i] = $this->_redis->hgetall("Webtopic:$t_arr[$i]");
    			if($content[$i]['uid']==$uid) {
    				unset($t_arr[$i]);
    			}
    		}
    		$count = count($t_arr);
    		return json_encode(array('count'=>$count,'status'=>1,'ctime'=>SYS_TIME,'topicid'=>$t_arr));
    	
    	}else{
    	
    		return json_encode(array('count'=>0,'status'=>1,'ctime'=>SYS_TIME));
    	}
    }
    public function getTimeContent($uid,$tagid,$ltime=0) {
    	$this->year_info = "Info:$uid:$tagid:".date("Ym");
    	if($ltime===0) {
    		$ltime=time();
    	}
    	$t_arr = $this->_redis->zrangebyscore($this->year_info,$ltime,'+inf');
        if($t_arr){  
        return $this->msgidcontent($t_arr,true);
        }else{
            
        return json_encode(array('data'=>null,'status'=>1,'ltime'=>SYS_TIME)); 
        }
    }

}

?>
