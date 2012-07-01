<?php
  /**
   * @desc 测试缩略图
   * @author lijianwei
   * @date 2012-02-24
   */
class Test extends MY_Controller {
    
	public function index() {
		//$this -> display('timeline/index.html');
		//$uids = call_soap('social', 'Webpage', 'getAllFollowers', array('pageid' =>584 ));
		//var_dump($uids);
		
//		$conf = & get_config();
//		var_dump($conf['constants']['WEB_DUANKOU_ROOT']);
			phpinfo();
		
	}
	public function model() {
		$this -> display('timeline/model.html');
	}
	public function message() {
		$this -> display('message/index.html');
	}
	public function msgInfo() {
		$this -> display('message/msgInfo.html');
	}
	public function follow() {
		$this -> display('follow/follow.html');
	}
	public function follow1() {
		$this -> display('follow/follow1.html');
	}
	public function followlist() {
		$this -> display('follow/followlist.html');
	}
	public function friend() {
		$this -> display('friend/index.html');
	}
	public function friendlist() {
		$this -> display('friend/list.html');
	}
	public function praise() {
		$this -> display('praise/praise.html');
	}
	
	public function conf()
	{
		// echo SMARTY_DIR;
		// echo FCPATH;
		// echo BASEPATH;
		// echo CONSTANTS_TEST,'<br />';
		echo TOKENNAME,'<br />';
		// echo DEFINE_TEST,'<br />';
		// echo WEB_BAR,'<br />';
		// echo DS,'<br />';
		// echo '<pre>';
		// print_r(get_defined_constants());
		// echo '</pre>';
	}

	/**
     * 所有请求列表
     * 对应视图: all_request.html
     */	
	public function request() {
		$this -> display('request/all_request');
	}
	/**
     * 所有通知列表
     * 对应视图: all_notice.html
     */
	public function notices() {
		$this -> display('notice/all_notice');
	}
	/**
     * 邀请码
     * 对应视图: invitecode.html
     */
	public function invitecode() {
		$this -> display('invitecode/invitecode');
	}

	public function invitecode_data(){
		$result = array(
						'state'=> 1,
						'msg' => '操作成功!',
						'data' =>'<li uid="g000001">
									  <p><a href="#"><img alt="头像" src="/new_duankou/misc/files/images/avatars/013A11191-15.jpg"></a></p>
									  <p>杨静</p>
									  <p><input type="button" class="uiButton uiButtonDepressed w70" name="addLook" value="+加关注"></p>
								  </li>
								  <li uid="g000002">
									  <p><a href="#"><img alt="头像" src="/new_duankou/misc/files/images/avatars/013A11191-15.jpg"></a></p>
									  <p>李莲</p>
									  <p><input type="button" class="uiButton uiButtonDepressed w70" name="addLook" value="+加关注"></p>
								  </li>',
			);
			echo json_encode($result);
		}
	/**
	 * 获取头部未读信息条数
	 * @author zhangbo
	 * @date 2012-2-29
	 * return json
	 */
	function top_no_read_count(){
		//下面固定静态测试数据
		$infos['unread_friendapply'] = '2';
		$infos['unread_msg'] = '5';
		$infos['unread_notice'] = '8';
		//返回json数据
		$data = array('status'=>1,
	 				  'data'=>array(
					  		'requests'=>$infos['unread_friendapply'],
							'messages'=>$infos['unread_msg'],
							'notice'=>$infos['unread_notice']
					  )
	 	);
		echo json_encode($data);
	}
	function add_ok(){
		$result = array(
						'state'=> 1,
						'msg'  => '操作成功!',
						'data' => '',
			);
		echo json_encode($result);
	}
	/**
	 * 获取头部“请求”下拉信息
	 * @author zhangbo
	 * @date 2012-2-29
	 * return json
	 */
	function top_request(){
		//下面固定静态测试数据
		//返回json数据
		$result=array( 
					array(
					'invite_uid' => 00001,
					'type' => 1,
					'dkcode' => ' lixiaolong',
					'avatarurl' => '/new_duankou/misc/files/images/avatars/013A11191-15.jpg',
					'username' => '李小龙',
					'dateline' => '2011-10-15'
					),
					array(
					'invite_uid' => 00002,
					'type' => 0,
					'dkcode' => 'liuyifei',
					'avatarurl' => '/new_duankou/misc/files/images/avatars/0T154G01-6.jpg',
					'username' => '刘亦菲',
					'dateline' => '2012-1-15'
					),
					array(
					'invite_uid' => 00003,
					'type' => 1,
					'dkcode' => 'renxianqi',
					'avatarurl' => '/new_duankou/misc/files/images/avatars/0T15414K-8.jpg',
					'username' => '任贤齐',
					'dateline' => '2012-10-15'
					)
				);


	$state = 1;
	$str="";
		if($result){
			foreach ($result as $r){
				$str.="<li class='clearfix' rid=".$r['invite_uid'].">";
				$str.="<span class='picHead'><a href='".WEB_ROOT.$r['dkcode']."/home/socials/index'><img src='".$r['avatarurl']."'/></a></span>";
				$str.="<span class='friendInfo'><a href='".WEB_ROOT.$r['dkcode']."/home/socials/index'><strong>".$r['username']."</strong></a><br>".$r['dateline']."</span>";
				$str.="<span class='addView'>";
				if($r['type']==1){
				$str.="<span class='btnBlue' name='reqAdd'><i class='a'></i><a href='javascript:void(0);'>加关注</a></span> ";
				
				}else{
				$str.="<span class='btnBlue' name='reqFriend'><a href='javascript:void(0);'>成为朋友</a></span> ";
				}
				$str.="<span class='btnGray' name='reqIgnore'><a href='javascript:void(0);'>忽略请求</a></span>";
				$str.="</span>";
				$str.="</li>";
			}
			$state=1;
		}else{
			$str.="<li class='clearfix'><span style='padding:6px 8px 4px;'>没有可显示的请求列表</span></li>";
			$state=0;
		}
	
		echo json_encode(array('state' => $state,'data' => $str));

	}
	/**
	 * 获取头部“站内信”下拉信息
	 * @author zhangbo
	 * @date 2012-2-29
	 * return json
	 */
	function top_msg(){

		$str="";
			for($i = 1; $i<=5; $i++){
								$str.="<li class=";
									 if($str==""){
										$str.="'firstChild'>";
									}else{
										$str.="''>";
									}
										$str.='<a href="javascript:void(0)" class="itemBlock">';
											$str.='<div class="uiImageBlock clearfix">';
											$str.='	<img class="uiProfilePhoto fl" src="/new_duankou/misc/files/images/avatars/0T154L29-12.jpg" />';
												$str.='<div class="uiImageBlockContent">';
												$str.='	<div class="author">';
														$str.='<strong>Maxine Xie</strong>';
													$str.='</div>';
													$str.='<div class="snippet">';
														$str.='<span>你在搞什么东东啊？神神秘秘的</span>';
													$str.='</div>';
													$str.='<div class="time">';
													$str.='	<abbr class="timestamp">2009年7月7日</abbr>';
													$str.='</div>';
												$str.='</div>';
											$str.='</div>';
										$str.='</a>';
									$str.='</li>';
		}
		echo json_encode($result = array('state' => 1,'data' => $str));

	}
	/**
	 * 头部“站内信”下拉区域 点击“发布新消息” 
	 * @author zhangbo
	 * @date 2012-2-29
	 * return json 返回所有好友列表
	 */
	public function get_all_friends(){
	
		$data = array('status'=>1,
	 				  'info' =>'操作成功!',
	 				  'data'=>'这里是失败信息',
					  'compactedObjects'=>array(
						  	array(
								'avatar' => '/new_duankou/misc/files/images/avatars/0T154L29-12.jpg',
								'userid' => '2012',
								'username' => '大地',
								'location' => '浙江杭州'
							),
							array(
								'avatar' => '/new_duankou/misc/files/images/avatars/0T154L29-12.jpg',
								'userid' => '2013',
								'username' => '二狗子',
								'location' => '浙江杭州'
							),
							array(
								'avatar' => '/new_duankou/misc/files/images/avatars/0T154L29-12.jpg',
								'userid' => '2014',
								'username' => '啊啊',
								'location' => '浙江杭州'
							)
					  )
	 			);
		echo json_encode($data);
	}
	/**
	 * 头部“发布新消息” 上传附件
	 * @author zhangbo
	 * @date 2012-3-6
	 */
	function msg_uploadfile(){
		if (isset($_FILES['FileData'])) {
			$attachedFileId = '232434';
			$attachedFileOriginalName = $_FILES['FileData']['name'];
			$attachedFileName = rand(0,500000).dechex(rand(0,10000)).$attachedFileOriginalName;
			$attachedFileSize = $_FILES['FileData']['size'];
			$callback = $_POST['callback'];
			$inputFileId= $_POST['inputFileId'];
			$filePath = basename('--'.rand().$attachedFileOriginalName);
			move_uploaded_file($_FILES['FileData']['tmp_name'],"D:/wamp/www/new_duankou/misc/files/images/temp/".$filePath);
			$arr = array('id' => $attachedFileId,'filename'=>$attachedFileName,'fileOriginalName'=>$attachedFileOriginalName,'fileSize'=>$attachedFileSize );
			
			echo $this->uploaderResult($callback, $inputFileId, $arr);
		}else{
			echo '<script type="text/javascript"> alert("上传失败"); </script>';
		}
	}

	/**
	 * uploaderResult(param1, param2)
	 * param1:客户端上传上来的回调函数
	 * param2:input file Id
	 * param3:保存文件后服务器输出的结果
	 */
	function uploaderResult($_callback, $_inputFileId, $_arr){
		$result  = '<script type="text/javascript">';
		$result .= ';window.parent[\''.$_callback.'\'].call(window,';
		$result .= '\''. json_encode($_arr);
		$result .= '\''.');';
		$result .= 'window.parent.document.getElementById("uploader-loading").style.display = "none";';
		$result .= 'window.parent.document.getElementById("'.$_inputFileId.'").style.display = "block";';
		$result .= '</script>';
		return $result;
	}
	/**
	 * 信息列表切换类型显示对应数据 
	 * @author zhangbo
	 * @date 2012-2-29
	 * return json 返回所有好友列表
	 */
	function messagesSearch(){
	$_POST['messagesCateGory'];/*消息筛选类型*/
		$_POST['pageNum'];/*消息筛选类型请求的分页数*/
		
		$data = '';
		if($_POST['messagesCateGory'] == '0'){//请求未读的消息
			$data = array('state'=>1,
	 				  'info' =>'操作成功!',
	 				  'data'=>'这里是失败信息',
					  'messages'=>array(
						  	array(
								'avatar' => array(
									'/misc/images/avatars/0T15420K-7.jpg',
									'/misc/images/avatars/16.jpg',
									'/misc/images/avatars/20100511114711696.jpg',
								),
								'name' => '王小白',
								'snippet' => '中华人民共和国 pepole republic of china',
								'time' => '15小时前',
								'readState' => '1',
								'dataid' => '123'
							),
							array(
								'avatar' => array(
									'/misc/images/avatars/16.jpg'
								),
								'name' => '诸葛二狗',
								'snippet' => '你好我的空调制冷效果超好的啊',
								'time' => '9月7日',
								'readState' => '0',
								'dataid' => '123'
							)
					  ),
					 'more' => '1'
	 			);
		}else if($_POST['messagesCateGory'] == '2'){//请求存档的消息
			$data = array('state'=>1,
	 				  'info' =>'操作成功!',
	 				  'data'=>'这里是失败信息',
					  'messages'=>array(
						  	array(
								'avatar' => array(
									'/misc/images/avatars/20100511114711696.jpg'
								),
								'name' => '鱼头',
								'snippet' => '今天忘记带钱包了',
								'time' => '15小时前',
								'readState' => '0',
								'dataid' => '123'
							)
					  ),
					 'more' => '0'
	 			);
		}else if($_POST['messagesCateGory'] == '6'){//请求已发送的消息
			$data = array('state'=>1,
	 				  'info' =>'操作成功!',
	 				  'data'=>'这里是失败信息',
					  'messages'=>array(
						  	array(
								'avatar' => array(
									'/misc/images/avatars/20100511114710932.jpg'
								),
								'name' => 'henrry',
								'snippet' => 'I miss you so much!',
								'time' => '二秒钟前',
								'readState' => '1',
								'dataid' => '123'
							),
							array(
								'avatar' => array(
									'/misc/images/avatars/16.jpg'
								),
								'name' => 'hanmeimei',
								'snippet' => 'hello i name is han mei mei',
								'time' => '5分钟前',
								'readState' => '1',
								'dataid' => '123'
							)
					  ),
					 'more' => '1'
	 			);
		}else if($_POST['messagesCateGory'] == ''){//请求全部消息
			$data = array('state'=>1,
	 				  'info' =>'操作成功!',
	 				  'data'=>'这里是失败信息',
					  'messages'=>array(
						  	array(
								'avatar' => array(
									'/misc/images/avatars/16.jpg',
									'/misc/images/avatars/0T15420K-7.jpg',
									'/misc/images/avatars/20100511114711696.jpg',
								),
								'name' => '王小白',
								'snippet' => '中华人民共和国 pepole republic of china',
								'time' => '15小时前',
								'readState' => '0',
								'dataid' => '123'
							),
							array(
								'avatar' => array(
									'/misc/images/avatars/16.jpg'
								),
								'name' => '诸葛二狗',
								'snippet' => '你好我的空调制冷效果超好的啊',
								'time' => '9月7日',
								'readState' => '0',
								'dataid' => '123'
							)
					  ),
					 'more' => '1'
	 			);
		}
	 	
	 	echo json_encode($data);
	}
	/**
	 * 获取头部“通知”下拉信息
	 * @author zhangbo
	 * @date 2012-2-29
	 * return json
	 */
	function top_notices(){
		
		$result=array( 
					array(
					'url' => '',
					't' => '0',
					'avatar' => '/new_duankou/misc/files/images/avatars/011355B91-22.jpg',
					'content1' => '<span class="blueName">潘霜霜</span>接受了你的朋友请求',
					'dateline' => '2011-10-15'
					),
					array(
					'url' => '',
					't' => 'photo',
					'avatar' => '/new_duankou/misc/files/images/avatars/013A15301-16.jpg',
					'content1' => '<span class="blueName">Charles Cui</span>接受了你的朋友请求',
					'dateline' => '2012-1-15'
					),
					array(
					'url' => '',
					't' => 'photo',
					'avatar' => '/new_duankou/misc/files/images/avatars/0T1545302-2.jpg',
					'content1' => '<span class="blueName">Charles Cui</span>接受了你的朋友请求',
					'dateline' => '2012-10-15'
					)
				);
	
		$str="";
		if($result){
			foreach ($result as $nstr){
				if($str==""){
					$str.="<li class='firstChild'>";
				}else{
					$str.="<li class=''>";
				}
				
				if($nstr['t']=="photo"){
					$str.="<a href='".$nstr['url']."' class='itemBlock picView'>";
				}else{
					$str.="<a href='".$nstr['url']."' class='itemBlock'>";
				}
					$str.="<div class='uiImageBlock clearfix'>";
					$str.="<img class='uiProfilePhoto fl' src='".$nstr['avatar']."' alt='头像' />
							<div class='uiImageBlockContent'><div>";
					$str.=$nstr['content1']."</div><div class='metadata'>
							<div class='time clearfix'>";
					$str.="<i class='uiIcon jewelMiniIcons bpIcon_date fl'></i>";
					$str.="<abbr class='timestamp'>".$nstr['dateline']."</abbr></div></div></div></div></a></li>";
			}
		}else{
			$str.="<ul class='clearfix'><span style='padding:6px 8px 4px;'>没有可显示的通知列表</span></ul>";
			$state=1;
		}
		echo json_encode(array('state' => '1','data' => $str,'msg'=>'通知获取错误！'));
	}
	/**
	 * 切换不要用户ajax数据
	 * @author zhangbo
	 * @date 2012-3-7
	 * return json
	 */
	function other_notice_list(){
		@$uid = $_POST['uid'];/*消息筛选类型*/
		@$more = $_POST['more'];
		@$pid = $_POST['page'];
		$data = '';
		if($uid == '10001'){//请求未读的消息
			$data =array(
				    array(
					'time'=>'今天',
			    	'notices'=>array(
									array(
										'type' => '1',
										'comment_content' => '<a href="#">10001潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									),
									array(
										'type' => '1',
										'comment_content' => '<a href="#">10001潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									),
									array(
										'type' => '1',
										'comment_content' => '<a href="#">10001潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									)
							
							)
						),
					array(
						'time'=>'昨天',
			    	    'notices'=>array(
									array(
										'type' => 'bp_photo',
										'comment_content' => '<a href="#">10001潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									),
									array(
										'type' => 'bp_photo',
										'comment_content' => '<a href="#">10001潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									),
									array(
										'type' => 'bp_photo',
										'comment_content' => '<a href="#">10001潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									)
							
							)
			       ) ,
					array(
						'time'=>'2月10号',
			    	    'notices'=>array(
									array(
										'type' => 'bp_photo',
										'comment_content' => '<a href="#">10001潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									),
									array(
										'type' => '1',
										'comment_content' => '<a href="#">10001潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									),
									array(
										'type' => 'bp_photo',
										'comment_content' => '<a href="#">10001潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									)
							
							)
			       ),
			
				);
		}else if($uid == '10002'){
		$data =array(
				    array(
					'time'=>'今天',
			    	'notices'=>array(
									array(
										'type' => 'bp_photo',
										'comment_content' => '<a href="#">10002潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									),
									array(
										'type' => 'bp_photo',
										'comment_content' => '<a href="#">10002潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									),
									array(
										'type' => 'bp_photo',
										'comment_content' => '<a href="#">10002潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									)
							
							)
						),
					array(
						'time'=>'昨天',
			    	    'notices'=>array(
									array(
										'type' => 'bpIcon_plusMan',
										'comment_content' => '<a href="#">10002潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									),
									array(
										'type' => 'bp_photo',
										'comment_content' => '<a href="#">10002潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									),
									array(
										'type' => 'bp_photo',
										'comment_content' => '<a href="#">10002潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									)
							
							)
			       ) ,
					array(
						'time'=>'2月10号',
			    	    'notices'=>array(
									array(
										'type' => 'bp_photo',
										'comment_content' => '<a href="#">10002潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									),
									array(
										'type' => 'bp_photo',
										'comment_content' => '<a href="#">10002潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									),
									array(
										'type' => 'bp_photo',
										'comment_content' => '<a href="#">10002潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									)
							
							)
			       ),
			
				);
		}else if($pid == '2'){
		$data =array(
				    array(
					'time'=>'今天',
			    	'notices'=>array(
									array(
										'type' => 'bp_photo',
										'comment_content' => '<a href="#">page2潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									),
									array(
										'type' => 'bp_photo',
										'comment_content' => '<a href="#">page2潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									),
									array(
										'type' => 'bp_photo',
										'comment_content' => '<a href="#">page2潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									)
							
							)
						),
					array(
						'time'=>'昨天',
			    	    'notices'=>array(
									array(
										'type' => 'bpIcon_plusMan',
										'comment_content' => '<a href="#">page2潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									),
									array(
										'type' => 'bp_photo',
										'comment_content' => '<a href="#">page2潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									),
									array(
										'type' => 'bp_photo',
										'comment_content' => '<a href="#">page2潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									)
							
							)
			       ) ,
					array(
						'time'=>'2月10号',
			    	    'notices'=>array(
									array(
										'type' => 'bp_photo',
										'comment_content' => '<a href="#">page2潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									),
									array(
										'type' => 'bp_photo',
										'comment_content' => '<a href="#">page2潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									),
									array(
										'type' => 'bp_photo',
										'comment_content' => '<a href="#">page2潘霜霜</a>也对<a href="#">陈莉沙</a>的<a href="#">相册</a>做了评论',
										'comment_time' => '2012年2月13日09:30',
									)
							
							)
			       ),
			
				);
		}

	echo json_encode(array('state' => '1','data' => $data,'msg'=>'通知获取错误！'));
		//echo "<pre>"; 
		//print_r($aa); 
		//echo "</pre>"; 

	}
/**
	 * 所有请求换一组
	 * @author zhangbo
	 * @date 2012-2-29
	 * return json
	 */
	function show_invite(){
		$result = array(
						'state'=> 1,
						'msg'  => '操作成功!',
						'data' => array(
										array(
											'invite_uid' => '100003',
											'dkcode' => '10000158',
											'type' => '1',													
											'userUrl' => '#',
											'avatarurl' => '/new_duankou/misc/files/images/avatars/0T1543116-5.jpg',
											'username' => '方江艳',
											'dateline' => '5分钟',
											),
										array(
											'invite_uid' => '100004',
											'dkcode' => '10000158',		
											'type' => '1',	
											'userUrl' => '#',
											'avatarurl' => '/new_duankou/misc/files/images/avatars/013A11191-15.jpg',
											'username' => '李小路',
											'dateline' => '155分钟',
											),
										array(
											'invite_uid' => '100005',
											'dkcode' => '10000158',	
											'type' => '2',	
											'userUrl' => '#',
											'avatarurl' => '/new_duankou/misc/files/images/avatars/013A11191-15.jpg',
											'username' => '刘亦菲',
											'dateline' => '25分钟',
											),
						),
			);
			echo json_encode($result);
	}
	public function seeornot(){
		$result = array(
			'status' =>1
		);
		echo json_encode($result);
	}
	/**
     * 粉丝列表
     */
	public function follow_data() {
		$result = array(
			'status' => 1,
			'data' => array(
						array(
							'content'=>'个人',
							'classN'=>'p',
							'state'=>'on',
							'see'=>''
						),
						array(
							'content'=>'AV妞妞',
							'classN'=>'c',
							'state'=>'',
							'see'=>'hid'
						),
						array(
							'content'=>'粉丝',
							'classN'=>'f',
							'state'=>'',
							'see'=>''
						),
						array(
							'content'=>'还珠格格之天上人间',
							'classN'=>'file',
							'state'=>'',
							'see'=>''
						),
						array(
							'content'=>'刘诗诗',
							'classN'=>'ss',
							'state'=>'',
							'see'=>''
						),
						array(
							'content'=>'那些年，我们一起追过的女孩',
							'classN'=>'girl',
							'state'=>'',
							'see'=>'hid'
						),
						array(
							'content'=>'步步惊心',
							'classN'=>'bb',
							'state'=>'',
							'see'=>''
						),
						array(
							'content'=>'让子弹飞会儿',
							'classN'=>'g',
							'state'=>'',
							'see'=>''
						),
						array(
						'content'=>'命中注定我爱你',
						'classN'=>'g',
						'state'=>'',
						'see'=>'hid'
						),
						array(
						'content'=>'失恋33天',
						'classN'=>'g',
						'state'=>'',
						'see'=>''
						)
					  ),
			'msg' => 'error'
		);
		echo json_encode($result);
	}
	/**
     * 粉丝列表
     */
	public function friend_data() {
		$result = array(
			'state' => 1,
			'data' => array(
						array(
							'content'=>'个人',
							'classN'=>'p',
							'state'=>true,
							'className'=>'fri_icon1',
							
						),
						array(
							'content'=>'AV妞妞',
							'classN'=>'c',
							'state'=>false,
							'className'=>'fri_icon2',
						),
						array(
							'content'=>'粉丝',
							'classN'=>'f',
							'state'=>true
						),
						array(
							'content'=>'电影迷',
							'classN'=>'f',
							'state'=>true
						),
						array(
							'content'=>'刘诗诗',
							'classN'=>'f',
							'state'=>false
						),array(
							'content'=>'粉丝',
							'classN'=>'f',
							'state'=>true
						),
						array(
							'content'=>'电影迷',
							'classN'=>'f',
							'state'=>true
						),
						array(
							'content'=>'刘诗诗',
							'classN'=>'f',
							'state'=>false
						),
						array(
							'content'=>'粉丝',
							'classN'=>'f',
							'state'=>true
						),
						array(
							'content'=>'电影迷',
							'classN'=>'f',
							'state'=>true
						),
						array(
							'content'=>'刘诗诗',
							'classN'=>'f',
							'state'=>false
						),
						array(
							'content'=>'粉丝',
							'classN'=>'f',
							'state'=>true
						),
						array(
							'content'=>'电影迷',
							'classN'=>'f',
							'state'=>true
						),
						array(
							'content'=>'刘诗诗',
							'classN'=>'f',
							'state'=>false
						),
					  ),
			'msg' => 'error'
		);
		echo json_encode($result);
	}
	/**
     * 头像列表
     */
	public function list_data(){
		$person = array(
			'state' => 1,
			'data' => array(
						array(
							'imgURL'=>'http://localhost/new_duankou/misc/img/default/avatar_50.gif',
						),
						array(
							'imgURL'=>'http://localhost/new_duankou/misc/img/default/avatar_50.gif',
						),
						array(
							'imgURL'=>'http://localhost/new_duankou/misc/img/default/avatar_50.gif',
						),
						array(
							'imgURL'=>'http://localhost/new_duankou/misc/img/default/avatar_50.gif',
						),
						array(
							'imgURL'=>'http://localhost/new_duankou/misc/img/default/avatar_50.gif',
						),
						array(
							'imgURL'=>'http://localhost/new_duankou/misc/img/default/avatar_50.gif',
						),
						array(
							'imgURL'=>'http://localhost/new_duankou/misc/img/default/avatar_50.gif',
						),
						array(
							'imgURL'=>'http://localhost/new_duankou/misc/img/default/avatar_50.gif',
						),
						array(
							'imgURL'=>'http://localhost/new_duankou/misc/img/default/avatar_50.gif',
						),
						array(
							'imgURL'=>'http://localhost/new_duankou/misc/img/default/avatar_50.gif',
						),
						array(
							'imgURL'=>'http://localhost/new_duankou/misc/img/default/avatar_50.gif',
						),
						array(
							'imgURL'=>'http://localhost/new_duankou/misc/img/default/avatar_50.gif',
						),
						
					  ),
			'msg' => 'error'
		);
		echo json_encode($person);
	}
	/**
     * 上传头像
     */
	public function upload() {
		$this -> display('timeline/testdata/upload.php');
	}
	/**
     * 删除头像
     */
	public function delete_head() {
		$this -> display('timeline/testdata/delete_head.php');
	}
	/**
     * 删除封面
     */
	public function delete_cover() {
		$this -> display('timeline/testdata/delete_cover.php');
	}
	/**
     * 上传封面
     */
	public function uploadcover() {
		$this -> display('timeline/testdata/uploadcover.php');
	}
	/**
     * 保存封面
     */
	public function set_cover() {
		$this -> display('timeline/testdata/set_cover.php');
	}
	
	/**
     * 从已上传的照片中挑选返回图片列表
     */
	public function headerData() {
		
		$p = $_POST['p'];
		if($p==1){
			$arr = array(
				'state' => 1,
				'data' => 'no',
				'msg' => 'error'
			);
			echo json_encode($arr);
			return;
		}else if($p==2){
			$arr = array(
				'state' => 1,
				'data' => array(
							array(
								'pid' => '001',
								'purl' => 'http://localhost/new_duankou/misc/temp/547208dc95c00b4bd5a0c2e347977abe_m.jpg',
							),
							array(
								'pid' => '002',
								'purl' => 'http://localhost/new_duankou/misc/temp/010K21154-2.jpg',
							),
							array(
								'pid' => '003',
								'purl' => 'http://localhost/new_duankou/misc/temp/015I35532-11.jpg',
							),
							array(
								'pid' => '004',
								'purl' => 'http://localhost/new_duankou/misc/temp/547208dc95c00b4bd5a0c2e347977abe_m.jpg',
							),
							array(
								'pid' => '005',
								'purl' => 'http://localhost/new_duankou/misc/temp/547208dc95c00b4bd5a0c2e347977abe_m.jpg',
							),
							array(
								'pid' => '005',
								'purl' => 'http://localhost/new_duankou/misc/temp/010K21154-2.jpg',
							),
							array(
								'pid' => '006',
								'purl' => 'http://localhost/new_duankou/misc/temp/015I35532-11.jpg',
							),
							array(
								'pid' => '007',
								'purl' => 'http://localhost/new_duankou/misc/temp/547208dc95c00b4bd5a0c2e347977abe_m.jpg',
							)
					
				),
				'msg' => 'error'
			);
			echo json_encode($arr);
			return;
		}
	}
	/*
	 * 传送封面图
	 */
	public function setPhotoInfo(){
		$p = $_POST['d'];
		$arr = array(
			'state' => 1,
			'data' => 'http://localhost/new_duankou/misc/temp/Hydrangeas.jpg',
			'msg' => 'error'
		);
		echo json_encode($arr);
			return;
	}
	/**
     * 从已上传的照片中挑选返回图片列表
     */
	public function getAlbum() {
		
		$p = $_POST['p'];
			$arr = array(
				'state' => 1,
				'data' => array(
							array(
								'pid' => '001',
								'purl' => 'http://localhost/new_duankou/misc/temp/547208dc95c00b4bd5a0c2e347977abe_m.jpg',
								'name' =>'最近上传'
							),
							array(
								'pid' => '002',
								'purl' => 'http://localhost/new_duankou/misc/temp/010K21416-4.jpg',
								'name' =>'个人头像'
							),
							array(
								'pid' => '003',
								'purl' => 'http://localhost/new_duankou/misc/temp/015I35532-11.jpg',
								'name' =>'封面照片'
							),
							array(
								'pid' => '004',
								'purl' => 'http://localhost/new_duankou/misc/temp/013A15210-12.jpg',
								'name' =>'个人头像'
							),
							array(
								'pid' => '005',
								'purl' => 'http://localhost/new_duankou/misc/temp/013A11191-15.jpg',
								'name' =>'最近上传'
							),
							array(
								'pid' => '005',
								'purl' => 'http://localhost/new_duankou/misc/temp/010K21154-2.jpg',
								'name' =>'最近上传'
							),
							array(
								'pid' => '006',
								'purl' => 'http://localhost/new_duankou/misc/temp/015I35532-11.jpg',
								'name' =>'最近上传'
							),
							array(
								'pid' => '007',
								'purl' => 'http://localhost/new_duankou/misc/temp/547208dc95c00b4bd5a0c2e347977abe_m.jpg',
								'name' =>'最近上传'
							)
					
				),
				'msg' => 'error'
			);
			echo json_encode($arr);
			return;
		
	}
	

}

