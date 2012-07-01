<?php
/**
 * 评论与赞控制器
 * 
 * @author boolee 2012 3 1
 */
class Comment extends MY_Controller
{
	protected $uinfo = array();
	
	/**
	 * 初始化需要初始化用户id用户名，头像地址;
	 * 放置与uinfo数组里
	 * uinfo['username'],uinfo['username']和uinfo['avatar']
	 * */
	public function __construct()
    {
        parent::__construct();
        
        $this->uinfo=array(
        	'uid' 	   => $this->uid,
        	'username' => $this->username,
 	        'avatar'   => get_avatar($this->uid),            //头像路径
        ); 
        //可选类型
        $this->object_type=array(	'topic','ask','event','blog','photo','video','album','comment','forward'	);
        //发信息链接
        $this->msgurl     =array(	'topic'=>'main/info/view',
        							'blog'=>'blog/blog/main',
        							'video'=>'video/video/player_video',
        							'album'=>'album/index/photoLists',
        							'photo'=>'album/index/test1',
        							'forward'=>'main/info/view');
    }
	
    /**
     * 通过uids获取一个以uid为索引的dkcode数组。
     */
    private function get_dkcodes($uids)
	{
	    $userinfo = call_soap('ucenter','User','getUserList',array($uids,array('uid','dkcode')));
	    $return=array();
	    if($userinfo)
	    {	
	    	foreach ($userinfo as $list){
	    		foreach($uids as $uid){
		    		if($uid == $list['uid'])
		    		$return[$uid]=$list['dkcode'];
	    		}
	    	}
	        return $return;
	    }
	    return 0;
	}
	
	/**
	 * 获取单个用户dkcode
	 */
	private function get_dkcode($uid)
	{
	    $user = call_soap('ucenter','User','getUserInfo',array($uid,'uid',array('dkcode')));
	    if($user)
	    {
	        return $user['dkcode'];
	    }
	    return 0;
	}

	/**
	 * 初始化加载全部评论，赞，转发相关数据及其统计
	 */
	public function get_stat_all()
    {
    	$object_id  =  $this->input->get('comment_ID');  
    	$object_type=  $this->input->get('pageType');  
	    $tid		=  $this->input->get('tid');   
	    
        if(!($object_id && $this->uid  && $object_type)){
            echo json_encode(array('status'=>0,'msg'=>'获取数据异常'));exit;
        }
        $data['object_id']	= $object_id;
        $data['object_type']= $object_type;
        $data['uid']		= $this->uid;
        $data['tid']		= $tid;
         
        if(isset($data['object_id']) && isset($data['uid']) && isset($data['object_type']))
        {		
               $re = call_soap( 'comlike','Index','get_stat_all',array($data) );
               $re = json_decode($re , true);
               if($re){
               		//多次soap优化的中间变量：$rek，头像索引，$rekey,dkcode索引，$dkuids，不重复的用户uid数组
               		$rek    =array();
               		$rekey  =array();
               		$dkuids =array();
  
               		//--------------------评论者个人头像+端口号处理------------------------------------------------
               		foreach ($re as $k=>$list1){
               			//查找头像端口号
	               		if(isset($list1['data'])){
		               		foreach($list1['data'] as $key => $people){
		               			if($people['uid'] == $this->uid){
		               				$re[$k]['data'][$key]['url']    = WEB_ROOT.'main';
		               			}else{
		               				$rek[$people['uid']][]   =$k.','.$key;
		               				if(empty($dkuids[$people['uid']])) $dkuids[$people['uid']]  =$people['uid'];       
		               				//$re[$k]['data'][$key]['url']    = '';	
		               			}		               			
		               			$re[$k]['data'][$key]['imgUrl'] = get_avatar($people['uid']);
		               		}
	               		}
	               		//赞用户端口号查找
	               		if(isset($list1['greepeople'])){
	               			foreach($list1['greepeople'] as $key => $people){
	               				if($people['uid'] == $this->uid){
		               				$re[$k]['greepeople'][$key]['url']    = WEB_ROOT.'main';
		               			}else{				  
		               				$rekey[$people['uid']][]   =$k.','.$key;
		               				if(empty($dkuids[$people['uid']])) $dkuids[$people['uid']]    =$people['uid']; 
		               				//$re[$k]['greepeople'][$key]['url']    = '';
		               			}     
		               		}
	               		}
               		}
               		//完成替换
               		$dkcodedata=$this->get_dkcodes(array_values($dkuids));
               		if(is_array($dkcodedata)){
               			foreach($dkcodedata as $keys=>$list){
	               			foreach($rek as $reakk=>$k1){
	               				if($keys == $reakk){
	               					foreach ($k1 as $kk){ 
	               						$kk=explode(',', $kk);
	               						$re[$kk[0]]['data'][$kk[1]]['url']  = mk_url('main/index/index',array('action_dkcode'=>$list));
	               					}
	               					break;
	               				}
	               			}
	               			
	               			foreach($rekey as $reakk=>$k1){
	               				if($keys == $reakk){
	               					foreach ($k1 as $kk){ 
	               						$kk=explode(',', $kk);
	               						$re[$kk[0]]['greepeople'][$kk[1]]['url']  = mk_url('main/index/index',array('action_dkcode'=>$list)); 
	               					}
	               				}
	               			}       			
						 
	               		}
               		}
               		echo json_encode($re);exit;
               }else{
               		echo json_encode(array('status'=>0,'msg'=>'未能及时获取数据'));
               }
        }
    }
   
	//添加评论
    public function add_comment()
    {  	
    	$object_id	=$this->input->post('comment_ID');
    	$content	=$this->input->post('comment_content');
    	$pageType	=$this->input->post('pageType');
    	$src_uid	=$this->input->post('action_uid');
    	$msgname	=$this->input->post('msgname');         //信息名字，信息原链接
    	$msgurl		=$this->input->post('msgurl');
    	$tid		=$this->input->get_post('tid');			//首页热度新加
    	$msgid		=$tid;
    	$uid		=$this->uid;
    	$usr_ip		=$_SERVER['REMOTE_ADDR'];
    	$username	=$this->uinfo['username'];
    	$data		=array();								//插入数据
    	if( $object_id && ($content || $content ==='0') && in_array($pageType,$this->object_type) ){
    		if(!$this->check_author($src_uid, $this->uid, $tid) && $tid){
    				echo json_encode(array('state'=>0,'msg'=>'该用户已经设置了权限。'));exit;
    		}
    		$data['object_id']	=$object_id;
    		$data['object_type']=$pageType;
    		$data['content']	=$content;
    		$data['uid']		=$uid;
    		$data['src_uid']	=$src_uid;
    		$data['usr_ip']		=$usr_ip;
    		$data['username']	=$username;
        	$response=call_soap('comlike','Index','add_comment',array($data));
        	//信息流热度添加
    	 	if($tid){
	        	 call_soap('timeline','Timeline','updateTopicHot',array($object_id,1));	
	       	}
        	//对相册评论字段操作
        	if($response && $pageType=='photo'){
        		$url=WEB_ROOT.'single/album/index.php?c=comment&m=update1&object_id='.$object_id.'&time='.time();
	        	file_get_contents( $url );
        	}
			//发信息
			switch ($pageType){
				case 'album':
					$subtype='photo';
					$treetype='photo_albumcommenttoyou';
					call_soap('search','Restoration','restoreAlbumInfo',array(array(	'id'=>$object_id,
																			  	'type'=>0,
																				'visible'=>0
																			  )));
					if(!$msgurl) $msgurl=mk_url($this->msgurl[$pageType],array(	'action_dkcode'=>($this->get_dkcode($src_uid)),
																			 	'albumid'=>$object_id));
					break;
				case 'photo':
					$subtype='photo';
					$treetype='photo_commenttoyou';
					call_soap('search','Restoration','restorePhotoInfo',array(array(array(	'id'=>$object_id,
																			  	'type'=>0
																			  ))));
					if(!$msgurl) $msgurl=mk_url($this->msgurl[$pageType],array(	'pid'=>$object_id ));
					break;			
				case 'forward':
					$subtype='info';
					$treetype='info_infocomment';
					call_soap('search','Restoration','restoreStatusInfo',array(array('id'=>$tid,
																		   'type'=>0
																			         )));
					if(!$msgurl) $msgurl=mk_url($this->msgurl[$pageType],array(	'c'=>'info','m'=>'view','tid'=>$msgid ));
					break;	
				case 'topic':
					$subtype='info';
					$treetype='info_infocomment';
					call_soap('search','Restoration','restoreStatusInfo',array(array('id'=>$tid,'type'=>0)));
					if(!$msgurl) $msgurl=mk_url($this->msgurl[$pageType],array(	'c'=>'info','m'=>'view','tid'=>$msgid ));
					break;
				case 'blog':
					$subtype='blog';
					$treetype='blog_commenttoyou';
					call_soap('search','Restoration','restoreBlogInfo',array('id'=>$object_id));
					if(!$msgurl) $msgurl=mk_url($this->msgurl[$pageType],array(	'action_dkcode'=>($this->get_dkcode($src_uid)),'id'=>$object_id));
					break;
				case 'video':
					$subtype='video';
					$treetype='video_commenttoyou';
					call_soap('search','Restoration','restoreVideoInfo',array(array(	'id'=>$object_id,'type'=>0 )));
					if(!$msgurl) $msgurl=mk_url($this->msgurl[$pageType],array(	'vid'=>$object_id));
					break;				
			}
			if( ($this->uid != $src_uid) && $msgurl ){
				if(isset($msgname) && !in_array($pageType, array('topic','forward','photo'))){
					call_soap('ucenter', 'Notice', 'add_notice', array(1,$this->uid,$src_uid,$subtype,$treetype,array('name'=>$msgname,'url'=>$msgurl)));
				}else{
					call_soap('ucenter', 'Notice', 'add_notice', array(1,$this->uid,$src_uid,$subtype,$treetype,array('url'=>$msgurl)));
				}
			}
        	echo $response;
    	}else{
    		echo json_encode(array('state'=>0,'msg'=>'数据有误'));
    	}
    	
    }
	//删除评论
    public function del_comment()
    {
    	if($_GET['comment_ID'] && $_GET['pageType']){
    		$data = array(	'object_id'=>$_GET['comment_ID'],
    						'object_type'=>$_GET['pageType'],
    						'uid'=>$this->uid);
    		//核心返回false或者操作成功后的相片评论数关于的array值
    		$comment_count_arr=call_soap('comlike','Index','del_comment',array($data));
    		if($comment_count_arr){
    			echo json_encode(array('state'=>1));
    		}else{
    			echo json_encode(array('state'=>0,'msg'=>'暂时无法删除评论'));
    		}
    		
    		//----------------------相册字段处理------------------------------------------------------------------
    		if($comment_count_arr && $_GET['pageType']=='photo'){	
	    		if( empty($comment_count_arr['comment_count'] )){
	    			$comment_object_id=$comment_count_arr['object_id'];
	    			//最后一条进行删除处理
	    			$url              =WEB_ROOT.'single/album/index.php?c=comment&m=update2&object_id='.$comment_object_id.'&time='.time();
					file_get_contents($url);
	    		}		
	    		
    		}
    		  		
    		//----------------------搜索引擎接口------------------------------------------------------------------
    		/*switch ($_GET['pageType']){
				case 'album':
					call_soap('search','Restoration','restoreAlbumInfo',array(array('id'=>$object_id,
																			  'type'=>0,'visible'=>0
																			  )));
					break;
				case 'photo':
					call_soap('search','Restoration','restorePhotoInfo',array(array(array('id'=>$object_id,
																			  'type'=>0
																			  ))));
					break;			
				case 'topic':
					call_soap('search','Restoration','restoreStatusInfo',array(array('id'=>$object_id,
																		   'type'=>0
																			  )));
					break;
				case 'forward':
					call_soap('search','Restoration','restoreStatusInfo',array(array('id'=>$object_id,
																		   'type'=>0
																			  )));
					break;	
				case 'blog':
					call_soap('search','Restoration','restoreBlogInfo',array('id'=>$object_id));
					break;
				case 'video':
					call_soap('search','Restoration','restoreVideoInfo',array(array('id'=>$object_id,
																			  'type'=>0
																			  )));
					break;				
			}*/
    	}else{
    		echo json_encode(array('status'=>0,'msg'=>'获取数据异常'));
    	}    	
    }
	//添加赞
    public function add_like()
    {	
    	$object_id=isset($_POST['comment_ID'])?$_POST['comment_ID']:$_GET['comment_ID'];
    	$src_uid  =isset($_POST['action_uid'])?$_POST['action_uid']:$_GET['action_uid'];
    	$tid	  =$this->input->get('tid');
    	$ctime	  =$this->input->get('ctime');
    	$pageType =$_GET['pageType'];
    	if($object_id && $_GET['pageType'] && $src_uid){
    		//信息流操作时候权限判断
    		if(!$this->check_author($src_uid, $this->uid, $tid) && $tid){
    				echo json_encode(array('state'=>0,'msg'=>'该用户设置了权限。'));exit;
    		}
    		//赞模块专用数据接口
    		if(!$tid && in_array($pageType, array('album','photo','video','blog'))){
    			$spage= $pageType;
    			$sobj = $object_id;
    			if($pageType == 'photo'){
    				$sobj = $ctime;
    				$spage= 'album';
    			}
		    	$info	=call_soap('timeline', 'Timeline', 'getTopicByMap', array( $sobj,$spage ));
		    	$tid 	=$info['tid'];
		    	$ctime 	=$info['ctime'];
    		}
    		if(!$tid){
		    	$tid=0;	
    		}
		    if(!$ctime){
		    	$ctime=0;
		    }
    		$data = array(	'object_id'		=>$object_id, 
    						'object_type'	=>$_GET['pageType'], 
    						'usr_ip'		=>$_SERVER['REMOTE_ADDR'], 
    						'username'		=>$this->uinfo['username'], 
    						'uid'			=>$this->uid, 
    						'src_uid'		=>$src_uid,
    						'tid'			=>$tid,
    						'ctime'			=>$ctime);
	    	$re=call_soap('comlike','Index','add_like',array($data));
	    	//-------------------------------------赞用户处理BEGIN------------------------------------------------------------------------------------
    		if(isset($re['greepeople'])){
	    		$rek    =array();
               	$dkuids =array();
	    		foreach ($re['greepeople'] as $key=>$list){	
		    		$rek[$list['uid']][]   =$key;
		            if(empty($dkuids[$list['uid']])) $dkuids[$list['uid']]  =$list['uid']; 
		    	}
		    	$dkcodedata=$this->get_dkcodes(array_values($dkuids)); 
    			if(is_array($dkcodedata)){
	               	foreach($dkcodedata as $keys=>$list){
	               			foreach($rek as $reakk=>$k1){
	               				if($keys == $reakk){
	               					foreach ($k1 as $kk){ $re['greepeople'][$kk]['url']  = mk_url('main/index/index',array('action_dkcode'=>$list));
	               					}
	               					break;
	               			}
	               		}  			
	             	}
    			}	
	    	}	
    		//-------------------------------------赞用户处理END------------------------------------------------------------------------------------
	    	//发信息array('ask','event','topic','blog','photo','video','album','comment');
	    	$msgname	=$this->input->post('msgname');//信息名字，信息原链接
    		$msgurl		=$this->input->post('msgurl');
    		//-------------------------------------通知，搜索---------------------------------------------------------------------------------------
			switch ($_GET['pageType']){
				case 'ask':
					$subtype='ask';
					$treetype='ask_comment';
					break;
				case 'album':
					$subtype='photo';
					$treetype='photo_albumzan';
					call_soap('search','Restoration','restoreAlbumInfo',array(array('id'=>$object_id,
																			  'type'=>0,'visible'=>0
																			  )));
					if(!$msgurl) $msgurl=mk_url($this->msgurl[$pageType],array('action_dkcode'=>($this->get_dkcode($src_uid)),
																			   'albumid'=>$object_id));
					break;
				case 'photo':
					$subtype='photo';
					$treetype='photo_zan';
					call_soap('search','Restoration','restorePhotoInfo',array(array(array('id'=>$object_id,
																			  'type'=>0
																			  ))));
					if(!$msgurl) $msgurl=mk_url($this->msgurl[$pageType],array('pid'=>$object_id));
					break;			
				case 'topic':
					$subtype='info';
					$treetype='info_zaninfo';
					call_soap('search','Restoration','restoreStatusInfo',array(array('id'=>$tid,
																		   'type'=>0
																			  )));
					if(!$msgurl) $msgurl=mk_url($this->msgurl[$pageType],array('tid'=>$tid));
					break;
				case 'forward':
					$subtype='info';
					$treetype='info_zaninfo';
					call_soap('search','Restoration','restoreStatusInfo',array(array('id'=>$tid,
																		   'type'=>0
																			  )));
					if(!$msgurl) $msgurl=mk_url($this->msgurl[$pageType],array('tid'=>$tid));
					break;	
				case 'blog':
					$subtype='blog';
					$treetype='blog_zan';
					call_soap('search','Restoration','restoreBlogInfo',array('id'=>$object_id));
					if(!$msgurl) $msgurl=mk_url($this->msgurl[$pageType],array('action_dkcode'=>($this->get_dkcode($src_uid)),'id'=>$object_id));
					break;
				case 'video':
					$subtype='video';
					$treetype='video_zan';
					call_soap('search','Restoration','restoreVideoInfo',array(array('id'=>$object_id,
																			  'type'=>0
																			  )));
					if(!$msgurl) $msgurl=mk_url($this->msgurl[$pageType],array('vid'=>$object_id));
					break;				
			}
			//发通知
    		if( ($this->uid != $src_uid) && $msgurl){
				if(isset($msgname) && !in_array($pageType, array('topic','forward','photo'))){//条件：有name,不是信息流或者相片
					$s=call_soap('ucenter', 'Notice', 'add_notice', array(1,$this->uid,$src_uid,$subtype,$treetype,array('name'=>$msgname,'url'=>$msgurl)));
				}else{
					call_soap('ucenter', 'Notice', 'add_notice', array(1,$this->uid,$src_uid,$subtype,$treetype,array('url'=>$msgurl)));
				}
			}
			echo json_encode($re);
	    }else{
	    	json_encode(array('state'=>0,'msg'=>'添加赞异常'));
	    }
    }
	//删除赞
    public function del_like()
    {
    	$object_id=$_GET['comment_ID'];
    	if( $_GET['comment_ID'] && $_GET['pageType'] ){
    		$uid  = $this->uid;
    		$data = array('object_id'=>$_GET['comment_ID'], 'object_type'=>$_GET['pageType'], 'uid'=>$uid);
    		$re   = call_soap( 'comlike','Index','del_like',array($data) );
    		//-------------------------------------赞用户处理BEGIN------------------------------------------------------------------------------------
	    	if(isset($re['greepeople'])){
	    		$rek    =array();
               	$dkuids =array();
	    		foreach ($re['greepeople'] as $key=>$list){	
		    		$rek[$list['uid']][]   =$key;
		            if(empty($dkuids[$list['uid']])) $dkuids[$list['uid']]  =$list['uid']; 
		    	}
		    	$dkcodedata=$this->get_dkcodes(array_values($dkuids)); 
    			if(is_array($dkcodedata)){
	               	foreach($dkcodedata as $keys=>$list){
	               			foreach($rek as $reakk=>$k1){
	               				if($keys == $reakk){
	               					foreach ($k1 as $kk){ $re['greepeople'][$kk]['url']  = mk_url('main/index/index',array('action_dkcode'=>$list));
	               					}
	               					break;
	               			}
	               		}  			
	             	}
    			}	
	    	}
    		//-------------------------------------赞用户处理END------------------------------------------------------------------------------------
    		switch ($_GET['pageType']){
				case 'album':
					call_soap('search','Restoration','restoreAlbumInfo',array(array('id'=>$object_id,
																			  'type'=>0,'visible'=>0
																			  )));
					break;
				case 'photo':
					call_soap('search','Restoration','restorePhotoInfo',array(array(array('id'=>$object_id,
																			  'type'=>0
																			  ))));
					break;			
				case 'topic':
					call_soap('search','Restoration','restoreStatusInfo',array(array('id'=>$object_id,
																		   'type'=>0
																			  )));
					break;
				case 'forward':
					call_soap('search','Restoration','restoreStatusInfo',array(array('id'=>$object_id,
																		   'type'=>0
																			  )));
					break;	
				case 'blog':
					call_soap('search','Restoration','restoreBlogInfo',array('id'=>$object_id));
					break;
				case 'video':
					call_soap('search','Restoration','restoreVideoInfo',array(array('id'=>$object_id,
																			  'type'=>0
																			  )));
					break;				
			}
	    	echo json_encode($re);
    	}else{
    		echo json_encode(array('status'=>0,'msg'=>'获取数据异常'));
    	}
    }
	//获取所有赞列表
    public function get_all_comment()
    {
    	$object_id   = $this->input->get('comment_ID');
    	$object_type = $this->input->get('pageType');
    	$page  		 = $this->input->get('pageIndex');
    	$uid		 = $this->uid;
    	$data		 =array('object_id'=>$object_id,
    						'object_type'=>$object_type,
    						'uid'=>$uid,
    						'page'=>$page
    					);
    	$re= call_soap( 'comlike','Index','get_all_comment',array($data) ) ;
		$re=json_decode($re,1);
    	if($re){   		
    			if(is_array($re['data']) && !empty($re['data'])){
    				$rek    =array();
               		$dkuids =array();
		        	//查找头像端口号
		            foreach($re['data'] as $key => $people){
		               	if($people['uid'] == $this->uid){
		               	    $re['data'][$key]['url']    = WEB_ROOT.'main';
		               	}else{
		               		$rek[$people['uid']][]   =$key;
		               		if(empty($dkuids[$people['uid']])) $dkuids[$people['uid']]  =$people['uid']; 
		               	}		               			
		                $re['data'][$key]['imgUrl'] = get_avatar($people['uid']);
		           }
	           }

	      		$dkcodedata=$this->get_dkcodes(array_values($dkuids)); 
    			if(is_array($dkcodedata)){
	               		foreach($dkcodedata as $keys=>$list){
	               			foreach($rek as $reakk=>$k1){//uid
	               				if($keys == $reakk){
	               					foreach ($k1 as $kk){ $re['data'][$kk]['url']  =WEB_ROOT.'main/index.php?c=index&m=index&action_dkcode='.$list; 
	               					}
	               					break;
	               				}
	               			}  			
	               		}
    			}		 
              	echo json_encode($re);
         }else{
         	echo json_encode(array('status'=>0,'msg'=>'获取数据异常'));exit;
         }
    }

	/**
	 * 取得目标赞的信息
	 *
	 * @param $object_id 对象ID
	 * @param $object_type对象类型
	 * @param $page      当前页
	 */
	public function like_list()
	{
		$object_id    = $this->input->get('comment_ID');
    	$object_type  = $this->input->get('pageType');
    	$page    	  = (empty( $_GET['page'] ))?0:$_GET['page'];	    							  //判断当前请求是数据[page>0]还是初始化[page=0]
		$uid  		  = $this->uid;
		if(empty($uid) &&empty($object_id) &&empty($object_type)){
			echo json_encode(array('status'=>0,'msg'=>'登录异常'));exit;
		}
		
		/**page区分请求类型**/
		if($page){
			$lists = call_soap('comlike','Index','getLike',array(array(								  //获取当前请求数据
			    'object_id'	    =>    $object_id,
				'object_type'	=>    $object_type,
			    'page'			=>    $page,
				'order'			=>	  'date_desc',
			)));
			$lists=json_decode($lists,1);                            			
			if($lists){													//返回数组
				/**
				 * json输出内容：用户头像路径,用户名称,用户主页链接,用户间关系,[赞时间]。
				 * */
				$return	= array();
				$keys	= array();
				$uids	= array();
				foreach($lists as $key => $item){
					//关系列表  2无关系， 10好友, 6 相互关注, 4 粉丝, 8等待对方接受好友邀请
					if($this->uid == $item['uid']){
						$return[$key]['relationship']	=	7;
					}else{
						$keys[$key]	  = $item['uid'];
						if(!in_array($item['uid'], $uids))
						$uids[]	 	  = $item['uid'];
						//$relationship=call_soap( 'social','Social','getRelationWithUser',array($this->uid,$item['uid']) );//这里进行用户关系确定
					}
					$dateline=$item['dateline'];						//赞的时间
					
					$return[$key]['uid']			=	$item['uid'];
					$return[$key]['avatar_s']		=	get_avatar($item['uid']);
					$return[$key]['username']		=	$item['username'];
					$return[$key]['url']			=	WEB_ROOT.'main/index.php?c=index&m=index&action_dkcode='.($this->get_dkcode($item['uid']));
					//$return[$key]['relationship']	=	$relationship;
				    $return[$key]['dateline']		=	$dateline;
				}
				if($uids){
					$relationships=call_soap( 'social','Social','getMultiRelationStatus',array($this->uid,$uids) );
					foreach($relationships as $rek=>$relist){
						$kk=array_keys($keys,substr($rek,1));
						foreach ($kk as $k){ $return[$k]['relationship']	=	$relist;}
					}
				}
				$returnjson=json_encode($return);						 //每次请求返回的json数据，不覆盖已有的
				echo 	$returnjson;	
			}else{
				echo json_encode(array('status'=>0,'msg'=>'加载异常'));exit;
			}						      			 
		}else{
			$statarr  = call_soap( 'comlike','Index','getStat',array($object_id,$object_type) );		  //取统计表数,用于首次计算页面数量
			$p=intval(($statarr[0]['like_count'])/50);
			$pagecount=$statarr[0]['like_count']?($p ? $p : 1):0;//分页计算
			$this->assign('pagecount',$pagecount);//页面总数，只第一次加载进去
			$this->assign('object_id',$object_id);
			$this->assign('object_type',$object_type);
			$this->display('comment/like_lists.html');
		}

	}
	
	/**
	 * 取得转发者列表
	 *
	 * @param $object_id 对象ID
	 * @param $object_type对象类型
	 * @param $page      当前页
	 */
	public function share_list()
	{
		$object_id    = $this->input->get('comment_ID');
    	$object_type  = $this->input->get('pageType');
    	$page    	  = (empty( $_GET['page'] ))?0:$_GET['page'];	    			 				  //判断当前请求是数据[page>0]还是初始化[page=0]
		$uid  		  = $this->uid;
		if(!$uid){
			echo json_encode(array('status'=>0,'msg'=>'登录异常'));exit;
		}
		
		/**page区分请求类型**/
		if($page){
			$lists = call_soap('comlike','Share','getPageList',array($object_type,$object_id,$page));
			if($lists){													//返回数组
				/**
				 * json输出内容：用户头像路径,用户名称,用户主页链接,用户间关系,[赞时间]。
				 * */
				
				$return =array();
				$tids   =array();
				$uids   =array();	//用于查找用户信息
				$kid 	=array();	//用于保存循环id值

				foreach($lists as $key => $item){
					
					$item		= json_decode($item,1);
					if(!in_array($item['uid'], $uids))
					$uids[$item['uid']]				= 	$item['uid'];
					$kid[$key]						=  	$item['uid'];
					$return[$key]['uid']			=	$item['uid'];
					$return[$key]['avatar_s']		=	get_avatar($item['uid']);
					$return[$key]['url']			=	WEB_ROOT.'main/index.php?c=index&m=index&action_dkcode='.($this->get_dkcode($item['uid']));
					$return[$key]['cid']			=	$item['tid'];
					$return[$key]['pageType']		=	$object_type;
				    $tids[]							=   $item['tid'];
				}
				$userinfo = call_soap('ucenter','User','getUserList',array($uids,array('uid,username'),array('username')));	
				foreach($userinfo as $l1){
					foreach ($uids as $l2){
						if($l2 == $l1['uid']){
							$kys = array_keys( $kid,$l2 );
							foreach ($kys as $index){$return[$index]['username']    =   $l1['username']; }
							break;
						}
					}
					
				}
			}else{
				echo '[]';exit;
			}
			if(isset($tids) && !empty($tids)){
				//由信息ids查找信息内容和信息时间
				$info=call_soap('timeline', 'Timeline', 'getTopicByTid', array( 'fid'=>$tids ));
				$info=json_decode($info,TRUE);
				foreach (@$return as $key=>$list){
					if($info[$list['cid']]){
						$return[$key]['action_uid']		=	$info[$list['cid']]['uid'];
						$return[$key]['info']   		=   $info[$list['cid']]['content'];
						$return[$key]['ctime']  		=   $info[$list['cid']]['ctime'];
					}
				}
				$returnjson=json_encode(@$return);						 //每次请求返回的json数据，不覆盖已有的
				echo $returnjson;			
			}else{
				echo '[]';
			}	      			 
		}else{
			$statarr  = call_soap( 'comlike','Share','getLen',array($object_type,$object_id) );		  //取统计表数,用于首次计算页面数量
			if(($statarr%8)==0){
				$pagecount=$statarr?intval(@$statarr/8):0;
			}else{
				$pagecount=$statarr?intval(@$statarr/8)+1:0;
			}
			
			$this->assign('pagecount',$pagecount);//页面总数，只第一次加载进去
			$this->assign('object_id',$object_id);
			$this->assign('object_type',$object_type);//暂时这里都是forward
			$this->display('comment/share_lists.html');
		}

	}
	
	//外部调用接口
	public function call_stat($object_id='',$object_type=''){
		$re=call_soap('comlike', 'Index', 'call_stat',array($object_id,$object_type));
		
		return $re;
	}
	
	
	/**
	 * 权限内部函数
	 *
	 * @param $author 作者id
	 * @param $uid    当前用户id
	 * @param $tid    信息id(可能是不同类型的id),因为信息流可直接获取权限，在首页，无需进行fid+type去查找。
	 */
	private function check_author($author,$uid,$tid){
		//权限处理【是否公开或者自定义-是，不进行判断关系】
    	/*
    	 *-1 : 自定义
		 * 1 : 公开
		 * 3 : 粉丝
		 * 4 : 好友
		 * 8 : 自己
		 * */
			if($author==$uid) return true;
    		$timeline=call_soap('timeline','Timeline','getTopicByTid',array($tid));
    		switch ($timeline['permission']){
    			case'-1':
    				//自定义,在relations有权限
    				if(in_array($uid, $timeline['relations']))
    				$return=true;
    				$return=false;
    				break;
    			case'1':
    					$return=true;	//不处理
    				break;
    			case'3':
    				$relationship=call_soap( 'social','Social','getRelationStatus',array($uid,$author) );//确认是否为粉丝
    				if($relationship!=4){
    					$return=true;
    				}else{
    					$return=false;
    				}
    				break;
    			case'4':
    				$relationship=call_soap( 'social','Social','getRelationStatus',array($uid,$author) );	//对比好友关系
    				if($relationship === 10){
    					$return=true;
    				}else{
    					$return=false;
    				}
    				break;
    			case'8':
    				if($author == $uid){//判断时候是自己
    					$return=true;
    				}else{
    					$return=false;
    				}	
    				break;			
    			default://
    				$return=false;
    				break;		
    		}
    		
    		return $return;
	}
	
}
?>
