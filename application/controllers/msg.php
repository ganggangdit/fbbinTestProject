<?php

/**
 * if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
 * 站内信息
 * Enter description here ...
 * @author gefeichao
 * @date   2012-02-23
 */
class Msg extends MY_Controller
{
    protected $fdfs, $url;

    function __construct()
    {
        parent::__construct();
        define('UID', $this->uid);
        $this->load->model('messagemodel', '', TRUE);
    }

    function index()
    {
        //默认加载站内信信息
        $this->show_message();
    }

    function getfriends()
    {
        $keyword = $this->input->post('searchString');
        $users = $this->input->post('userids');
        $result = call_soap('search', 'People', 'getFollowingUserEachOther', array($this->uid,$keyword));
        $results = "";
		
        $result = (array)json_decode($result);
		
        if ($result['total'] > 0)
        {
            $user = explode(',', $users);
            
           foreach ($result['object'] as $value)
           {
           		$value = (array)$value;
           		if(in_array($value['id'], $user) == FALSE){
           			 	$array['userid'] = $value['id'];
                        $array['username'] = $value['name'];
                        $array['avatar'] = get_avatar($value['id']);
                        $array['location'] = "中国";
                        $results[] = $array;
           		}
            }
        }
        $data = array('status' => 1, 'compactedObjects' => $results);
     	 echo json_encode($data);
    }

    /**
     * 新建站内信
     * @author	gefeichao
     * @return  json  操作结果
     */
    public function add_msg()
    {
        $f_uid = $this->uid;
        $t_uid = $this->input->post('userids'); //接收uid
        $message = $this->input->post('newMessageContent'); //信息内容
        $fileNames = $this->input->post('fileNames');
        if (! $t_uid)
        {
            return false;
        }
        if (! $message)
        {
            $message = "";
        }
        $result = $this->messagemodel->add_message(shtmlspecialchars($f_uid), shtmlspecialchars($t_uid), strip_tags($message), $fileNames);
        $data = array('state' => 1, 'locationID' => $result, 'info' => '操作成功!', 'data' => '失败信息');
   		 echo json_encode($data);
    }

    /**
     * 回复站内信
     * @author gefeichao
     */
    function hf_msg()
    {
        $to_uid = $this->input->post('targetUserID');
        $message = $this->input->post('newMessage');
        $filename = $this->input->post('attachedFileName');
        $gid = $this->input->post('gid');
        $result = $this->messagemodel->reply_message($this->uid, shtmlspecialchars($to_uid), strip_tags($message), $filename, shtmlspecialchars($gid));
        //发送通知
        $filenames = explode(',', $filename);
        foreach ($filenames as $f)
        {
            $filea = $this->messagemodel->get_files($f);
            if ($filea)
            {
            	$group = $filea[0]['group_name'];
                $filename = $filea[0]['orig_name'];
                $filea[0]['downurl'] = mk_url('main/msg/downloadPhoto', array('id' => $f));
                $filea[0]['url'] = 'http://'. config_item('fastdfs_host') .'/' . $group . '/' . $filename;
                $filearray[] = $filea[0];
            }
            else
            {
                $filearray[] = "";
            }
        }
        $user = call_soap('ucenter', 'User', 'getUserInfo', array($this->uid)); //获得信息
        
        $data = array(
        		'state' => 1, 
        		'info' => '操作成功!', 
        		'data' => '这里是失败信息', 
        		'content' => $message, 
        		'avatar' => get_avatar($this->uid), 
        		'userid' => $this->uid, 
        		'username' => $user['username'], 
        		'replytime' => friendlyDate(time() - 1), 
        		'replyfrom' => '聊天室', 
        		'dataid' => '223214', 
        		'files' => $filearray);
        echo json_encode($data);
    }

    /**
     * 查看站内信详细对话列表
     * @author gefeichao
     * @access public
     * @param $fromid 会话id
     */
    function list_msg()
    {
        $fromid = $this->input->get('fromid')?strip_tags($this->input->get('fromid')):"";
       	$lastid = $this->input->get('lastId')?strip_tags($this->input->get('lastId')):"";
        //获取群组成员
        $users = $this->messagemodel->showgroup($fromid);
        $ulist = array();
         $list = explode(',', $users['g_list']);
    		foreach ($list as $v)
            {
                if ($v != UID)
                {
                    $ulist[] = $v;
                }
            }
       /* if ($users)
        {
        	$str='';
	        $user = call_soap('ucenter', 'User', 'getUserList',array($users['g_list']));	//获得信息
			foreach ($user as $value) {
				if(!$str){
					$str = $value['username'];
				}else{
					$str .= ','.$value['username'];
				}
			}
		
            $list = explode(',', $users['g_list']);
            $str = "";
            foreach ($list as $v)
            {
                $user = call_soap('ucenter', 'User', 'getUserInfo', array($v)); //获得信息
                if (! $user)
                {
                    $user['username'] = $v;
                }
                if ($v != UID)
                {
                    $ulist[] = $v;
                    if ($str == "")
                    {
                        $str = $user['username'];
                    }
                    else
                    {
                        $str = $str . "," . $user['username'];
                    }
                }
            }
            $this->assign('fromname', $str);
        }*/
        
        $this->assign('lastid', $lastid);
        $this->assign('gid', $fromid);
        $this->assign('avatar', get_avatar($this->uid));
        $this->assign('user', $this->user);
        $this->assign('fromid', implode(',', $ulist));
        $this->display('message/msgInfo.html');
    }

    function msgdetail_more(){
    	$fromid = $this->input->get('dataid');
    	$pagesize = 9;
        $more = true;$status = 1;$msginfo = array();
        $page = $this->input->post('page') ? $this->input->post('page') : 1;
        $limit = ($page-1) * $pagesize;
        $result = $this->messagemodel->showdetailmessage($fromid);
            foreach ($result as $r)
            {
                $myfile = array();
                $myfiles = explode(',', $r['files']);
                foreach ($myfiles as $j)
                {
                    $file = $this->messagemodel->get_files($j);
                    if ($file)
                    {
                    	$file[0]['id']=$j;
                    	$file[0]['downurl'] = mk_url('main/msg/downloadPhoto', array('id' => $j));
                        $group = $file[0]['group_name'];
                        $filename = $file[0]['orig_name'];
                        $file[0]['url'] = 'http://'. config_item('fastdfs_host') .'/' . $group . '/' . $filename;
                    }
                    else
                    {
                        $file[0] = '';
                    }
                    $myfile[] = $file[0];
                }
                $r['files'] = $myfile;
                $msginfo[] = $r;
            }
        //清空未读信息数
        call_soap('ucenter', 'Notice', 'setting', array($this->uid, 'editmsg'));
        $messresult = $this->msgpage($msginfo, $pagesize, $limit);
        $data = array('status' => $messresult['state'], 'data' => '这里是失败信息', 'messages' => $messresult['result'], 'isend' => $messresult['more']);
        echo json_encode($data);
    }
    
   
    /**
     * 获取站内信已存档列表
     * @author	gefeichao
     * @date	20111110
     * @param  $page
     * @return	array
     */
    function showarchivelist($page = 0, $pages = 10, $searchkey = NULL)
    {
        $pagesize = $pages * ($page - 1);
        $archivelist = $archiveresult = array();
        //调用后台方法，获得数据结果集
        $archiveresult = $this->messagemodel->message_archivelist($searchkey);
        if (! $archiveresult)
        {
            $archiveresult = array();
        }
        foreach ($archiveresult as $value)
        {
             //获取群组成员
            $users = $this->messagemodel->showgroup($value['gid']);
			$username = $this->username;
			$str = "";$i = 0;$j = 0;
			
       			 if(isset($users['u_list'])){
           			$ulist = explode(',', $users['u_list']);
           		}else{
           			$ulist = explode(',', $users['g_list']);
           		}
				$glist = explode(',', $users['g_list']);
				
				foreach ($ulist as $ul){
					$i++;
					if ($ul != $username){
						if ($str == ""){
							$str = $ul;
						}else{
							$str = $str . "," . $ul;
						}
						if($i >= 3){
                			$j = count($ulist)-4;
                			break;
                		}
					}
					
				}
                
				foreach ($glist as $gl){
					 if (count($glist) == 2){
						if ($gl != UID){
							$value['avatar'][] = get_avatar($gl); //获得用户头像
						}
					} else{
						$value['avatar'][] = get_avatar($gl); //获得用户头像
					}
				}
             if($j>0)	$str .= "还有其他". $j ."人";
            $value['username'] = $str;
            //获取已存档列表
            $archivelist[] = $value;
        }
        $mylist = $this->msgpage($archivelist, $pages, $pagesize);
        return $mylist;
    }

    /**
     * 获取站内信未读信息列表
     * @author	gefeichao
     * @param  $page	传入页数
     * @return	array
     */
    function showunreadlist($page = 0, $pages = 10, $searchkey = NULL)
    {
        $pagesize = $pages * ($page - 1);
        //调用后台方法，获得数据结果集
        $unreadlist = array();
        $unreadresult = $this->messagemodel->message_unreadlist($searchkey);
        if (! $unreadresult)
        {
            $unreadresult = array();
        }
        foreach ($unreadresult as $value)
        {
             //获取群组成员
            $users = $this->messagemodel->showgroup($value['gid']);
			$username = $this->username;
			$str = "";$i = 0;$j = 0;
			
           
        		if(isset($users['u_list'])){
           			$ulist = explode(',', $users['u_list']);
           		}else{
           			$ulist = explode(',', $users['g_list']);
           		}
				$glist = explode(',', $users['g_list']);
				
				foreach ($ulist as $ul){
					$i++;
					if ($ul != $username){
						if ($str == ""){
							$str = $ul;
						}else{
							$str = $str . "," . $ul;
						}
						if($i >= 3){
                			$j = count($ulist)-4;
                			break;
                		}
					}
					
				}
                
				foreach ($glist as $gl){
					 if (count($glist) == 2){
						if ($gl != UID){
							$value['avatar'][] = get_avatar($gl); //获得用户头像
						}
					} else{
						$value['avatar'][] = get_avatar($gl); //获得用户头像
					}
				}
             if($j>0)	$str .= "还有其他". $j ."人";
            $value['username'] = $str;
            //获取未读站内信列表
            $unreadlist[] = $value;
        }
        $mylist = $this->msgpage($unreadlist, $pages, $pagesize);
        return $mylist;
    }

    /**
     * 站内信收件箱列表显示
     * @author gefeichao
     * @param  $page	传入的页数
     */
    function showmlist($page = 0, $pages = 10, $searchkey = NULL)
    {
        $pagesize = $pages * ($page - 1);
        $messlist = array();
        //调用后台方法，获得数据结果集
        $messresult = $this->messagemodel->message_showmlist($searchkey);
        if (! $messresult)
        {
            $messresult = array();
        }
        foreach ($messresult as $value)
        {
             //获取群组成员
            $users = $this->messagemodel->showgroup($value['gid']);
			$username = $this->username;
			$str = "";$i = 0;$j = 0;
			
           
        		if(isset($users['u_list'])){
           			$ulist = explode(',', $users['u_list']);
           		}else{
           			$ulist = explode(',', $users['g_list']);
           		}
				$glist = explode(',', $users['g_list']);
				
				foreach ($ulist as $ul){
					$i++;
					if ($ul != $username){
						if ($str == ""){
							$str = $ul;
						}else{
							$str = $str . "," . $ul;
						}
						if($i >= 3){
                			$j = count($ulist)-4;
                			break;
                		}
					}
					
				}
                
				foreach ($glist as $gl){
					 if (count($glist) == 2){
						if ($gl != UID){
							$value['avatar'][] = get_avatar($gl); //获得用户头像
						}
					} else{
						$value['avatar'][] = get_avatar($gl); //获得用户头像
					}
				}
            if($j>0)	$str .= "还有其他". $j ."人";
            $value['username'] = $str;
            //获取收件箱列表
            $messlist[] = $value;
        }
        $mylist = $this->msgpage($messlist, $pages, $pagesize);
        return $mylist;
    }

    /**
     * 获取站内信发送列表
     * @author gefeichao
     * @param $page 传入页数
     * @return array
     */
    function setmessages($page = 0, $pages = 10, $searchkey = NULL)
    {
        $pagesize = $pages * ($page - 1);
        $messlist = array();
        //调用后台方法，获得数据结果集
        $messresult = $this->messagemodel->sentmessage($searchkey);
        if (! $messresult)
        {
            return false;
        }
        foreach ($messresult as $value)
        {
             //获取群组成员
            $users = $this->messagemodel->showgroup($value['gid']);
			$username = $this->username;
			$str = "";$i = 0;$j = 0;
			
           
        		if(isset($users['u_list'])){
           			$ulist = explode(',', $users['u_list']);
           		}else{
           			$ulist = explode(',', $users['g_list']);
           		}
				$glist = explode(',', $users['g_list']);
				
				foreach ($ulist as $ul){
					$i++;
					if ($ul != $username){
						if ($str == ""){
							$str = $ul;
						}else{
							$str = $str . "," . $ul;
						}
						if($i >= 3){
                			$j = count($ulist)-4;
                			break;
                		}
					}
					
				}
                
				foreach ($glist as $gl){
					 if (count($glist) == 2){
						if ($gl != UID){
							$value['avatar'][] = get_avatar($gl); //获得用户头像
						}
					} else{
						$value['avatar'][] = get_avatar($gl); //获得用户头像
					}
				}
            if($j>0)	$str .= "还有其他". $j ."人";
            $value['username'] = $str;
            //获取收件箱列表
            $messlist[] = $value;
        }
        $mylist = $this->msgpage($messlist, $pages, $pagesize);
        return $mylist;
    }

    /**
     * 站内信分页函数
     * @author gefeichao
     */
    private function msgpage($result, $pages, $pagesize)
    {
        //遍历分页设置
        $arr_rel = "";
        if (count($result) - $pagesize > $pages)
        {
            if ($pagesize == 0)
            {
                if (count($result) <= $pages)
                {
                    for ($i = 0; $i < count($result); $i ++)
                    {
                        $arr_rel[] = $result[$i];
                    }
                    $resultarray['more'] = true; //没有下一页
                }
                else
                {
                    for ($i = 0; $i < $pages; $i ++)
                    {
                        $arr_rel[] = $result[$i];
                    }
                    $resultarray['more'] = false;//有下一页
                }
            }
            else
            {
                for ($i = 0; $i < $pages; $i ++)
                {
                    $arr_rel[] = $result[$pagesize + $i];
                }
                $resultarray['more'] = false;
            }
        }
        else
        {
            if (count($result) < $pagesize)
            {
                $arr_rel = $result;
            }
            else
            {
                for ($i = 0; $i < count($result) - $pagesize; $i ++)
                {
                    $arr_rel[] = $result[$pagesize + $i];
                }
            }
            $resultarray['more'] = true;
        }
        $valarray = $arr_rel;
        $resultarray['result'] = $valarray;
        if (count($valarray) > 0 && $result)
        {
            $resultarray['state'] = '1';
        }
        else
        {
            $resultarray['state'] = '0';
        }
        return $resultarray;
    }

    /**
     * 点击站内信显示的最新列表
     * @author gefeichao
     * @return array
     */
    function msg_top()
    {
        $messlist = array();
        //调用后台方法，获得数据结果集
        $messresult = $this->messagemodel->message_list_top();
        if (! $messresult)
        {
            $messresult = array();
        }
        //清空未读信息数
        call_soap('ucenter', 'Notice', 'setting', array($this->uid, 'editmsg'));
        foreach ($messresult as $value)
        {
            //获取群组成员
            $users = $this->messagemodel->showgroup($value['gid']);
			$username = $this->username;
			$str = "";$i = 0;$j = 0;
			
           		if(isset($users['u_list'])){
           			$ulist = explode(',', $users['u_list']);
           		}else{
           			$ulist = explode(',', $users['g_list']);
           		}
				$glist = explode(',', $users['g_list']);
				
				foreach ($ulist as $ul){
					$i++;
					if ($ul != $username){
						if ($str == ""){
							$str = $ul;
						}else{
							$str = $str . "," . $ul;
						}
						if($i == 3){
                			$j = count($ulist)-4;
                			break;
                		}
					}
					
				}
                
				foreach ($glist as $gl){
					 if (count($glist) == 2){
						if ($gl != UID){
							$value['avatar'][] = get_avatar($gl); //获得用户头像
						}
					} else{
						$value['avatar'][] = get_avatar($gl); //获得用户头像
					}
				}
            
             if($j>0)	$str .= "还有其他". $j ."人";
            $value['username'] = $str;
            
            $value['isToUser'] = $value['toUser'] ? '<img src="/misc/img/system/forward.gif"/>':"";
            //获取收件箱列表
            $messlist[] = $value;
            
        }
        //显示下拉列表
        $msgstr = $this->msglisttop($messlist);
        echo json_encode(array('state' => '1', 'data' => $msgstr));
    }

    /**
     * 站内信下拉列表
     * @author gefeichao
     */
    private function msglisttop($topresult)
    {
        $str = "";
        if ($topresult)
        {
            foreach ($topresult as $value)
            {
                if ($value['state'] == 1)
                {
                    if ($str == "")
                    {
                        $str .= "<li class='firstChild jewelItemNew'>";
                    }
                    else
                    {
                        $str .= "<li class='jewelItemNew'>";
                    }
                }
                else
                {
                    if ($str == "")
                    {
                        $str .= "<li class='firstChild '>";
                    }
                    else
                    {
                        $str .= "<li class=''>";
                    }
                }
                $str .= " <a href='" . mk_url('main/msg/list_msg', array('fromid' => $value['gid'],'lastId'=>$value['id'])) . "' class='itemBlock'>
							<div class='uiImageBlock '>";
                if (count($value['avatar']) > 1)
                {
                    $str .= "<span class='uiSplitPics '>";
                    $str .= "<span class='uiSplitPic leftThree'><img class='uiProfilePhoto uiProfilePhotoLarge img' src='" . $value['avatar'][0] . "' /></span>";
                    $str .= "<span class='uiSplitPic rTop'><img class='uiProfilePhoto uiProfilePhotoSmall img' src='" . $value['avatar'][1] . "' /></span>";
                    $str .= "<span class='uiSplitPic rBottom'><img class='uiProfilePhoto uiProfilePhotoSmall img' src='" . $value['avatar'][2] . "'  /></span>";
                    $str .= "</span>";
                }
                else
                {
                    $str .= "<img class='uiProfilePhoto fl' src='" . $value['avatar'][0] . "' alt='" . $value['username'] . "头像' />";
                }
                $str .= "<div class='uiImageBlockContent'>
									<div class='author'>
										<strong>" . $value['username'] . "</strong>
									</div>
									<div class='snippet'>
										<span>" . $value['isToUser'] .$value['mess'] . "</span>
									</div>
									<div class='time'>
										<abbr class='timestamp'>" . $value['dateline'] . "</abbr>
									</div>
								</div>
							</div>
						</a>
					</li>";
            }
        }
        else
        {
            $str .= "<li class='firstChild not-message-list'><span class='not-message-list'>暂时没有站内信</span></li>";
        }
        return $str;
    }

    /**
     * 搜索站内信
     * @author gefeichao
     */
    function search_msg()
    {
    	$gid = $this->input->post('gid');
        $searchkey = $this->input->post("searchkey");
        $lastid = $this->input->post("hd_lastId");
       // $sresult = $this->messagemodel->search_msg($searchkey, $gid);
       // $this->assign('userlist', $sresult);
        $this->assign('lastid', shtmlspecialchars($lastid));
       	$this->assign('searchname',shtmlspecialchars(trim($searchkey)));
        $this->assign('user', $this->user);
        $this->assign('gid', shtmlspecialchars($gid));
        $this->assign('avatar', get_avatar($this->uid));
        $this->display('message/search.html');
    }

    function search_msg_more(){
    	$gid = $this->input->get('gid');
    	$searchkey = $this->input->get('searchkey');
    	if(!$gid || !$searchkey)	return false;
    	$searchkey = str_replace(' ', '', $searchkey);
    	$page = $this->input->post('page') ? $this->input->post('page') : 1;
    	$pagesize = 9;$msginfo=array();
        $limit = ($page-1) * $pagesize;$sresult = array();
    	$sresult = $this->messagemodel->search_msg(shtmlspecialchars($searchkey), $gid);
    	if(!$sresult) $sresult = array();
      	foreach ($sresult as $r)
            {
                $myfile = array();
                $myfiles = explode(',', $r['files']);
                foreach ($myfiles as $j)
                {
                    $file = $this->messagemodel->get_files($j);
                    if ($file)
                    {
                    	$file[0]['id']=$j;
                    	$file[0]['downurl'] = mk_url('main/msg/downloadPhoto', array('id' => $j));
                        $group = $file[0]['group_name'];
                        $filename = $file[0]['orig_name'];
                        $file[0]['url'] = 'http://'. config_item('fastdfs_host') .'/' . $group . '/' . $filename;
                    }
                    else
                    {
                        $file[0] = '';
                    }
                    $myfile[] = $file[0];
                }
                $r['files'] = $myfile;
                $msginfo[] = $r;
            }
    	$messresult = $this->msgpage($msginfo, $pagesize, $limit);
    	$data = array('status' => $messresult['state'], 'data' => '这里是失败信息', 'messages' => $messresult['result'], 'isend' => $messresult['more']);
        echo json_encode($data);            
    }
    /**
     * 删除站内信   
     * @access  public
     * @param   $id  记录id
     * return bool
     */
    function del_pms()
    {
        $id = $this->input->post('dataid');
        if (! $id)
        {
            $this->showmessage('编号不能为空！');
            return FALSE;
        }
        if($id == '111111'){
        	$gid = $this->input->post('id');
        	$count = $this->messagemodel->showdetailmessage($gid);
        	foreach ($count as $value) {
        		$ids[] = $value['id'];
        	}
        }else{
       	 $ids = explode(',', $id);
        }
        $result = $this->messagemodel->del_pms($ids, $this->uid);
        if ($result)
        {
            $state = 1;
        }
        else
        {
            $state = 0;
        }
        $data = array('state' => $state, 'data' => '这里删除信息失败');
        echo json_encode($data);
    }

    /**
     * 加载站内信首页显示列表
     * @author gefeichao
     * @date 20111110
     */
    public function show_message()
    {
        $this->assign('avatar', get_avatar($this->uid));
        $this->assign('user', $this->user);
        $this->display('message/index.html');
    }

    /**
     * 标记站内信读取状态
     * @access  public
     * @param   $id  记录id
     * return bool
     */
    function edit_message()
    {
        $id = $this->input->post('dataid');
        if (! $id)
        {
            $this->showmessage('编号不能为空！');
            return FALSE;
        }
        $result = $this->messagemodel->setmessage($id);
        if ($result)
        {
            $state = 1;
        }
        else
        {
            $state = 0;
        }
        $data = array('state' => $state, 'data' => '站内信未读修改失败，禁止非法操作哦 亲！！！', 'readState' => $result[0]);
        echo json_encode($data);
    }

    /**
     * 消息存档处理
     * @author gefeichao
     */
    function save_message()
    {
        $dataid = $this->input->post('dataid');
        if (! $dataid)
        {
            $this->showmessage('编号不能为空！');
            return FALSE;
        }
        $result = $this->messagemodel->setarchive($dataid);
        if ($result)
        {
            $state = 1;
        }
        else
        {
            $state = 0;
        }
        $data = array('state' => $state, 'data' => '站内信存档修改失败，禁止非法操作哦 亲！！！');
        echo json_encode($data);
    }

    /**
     * 完成消息附件上传操作
     * @author gefeichao
     * @access public
     */
    function message_upload()
    {
    	 require_once APPPATH . 'models/FdfsModel.php';
        $this->fdfs = FdfsModel::getInstance();
        $is_image = 0;
        $ext = $_FILES['FileData']['name'];
        $temp = trim(substr($ext, strrpos($ext, '.')), '.');
        $array = array('bmp', 'gif', 'jpeg', 'jpg', 'jpe', 'png', 'tiff', 'tif');
        if (in_array($temp, $array))
        {
            $is_image = 1;
        }
        $size = 1024*1024*10;
        if($_FILES['FileData']['size'] > $size){
        	 echo '<script type="text/javascript"> alert("附件大小超过10M，上传失败！"); </script>';
        	 return;
        }
        $r = $this->fdfs->upload_filename($_FILES['FileData']['tmp_name'], $temp);
        if (isset($r) && count($r) > 0)
        {
            $attachedGroupName = $r['group_name'];
            $attachedFileOriginalName = $r['filename'];
            $attachedFileName = $_FILES['FileData']['name'];
            $attachedFileSize = $_FILES['FileData']['size'];
            $callback = $_POST['callback'];
            $inputFileId = $_POST['inputFileId'];
            $sqldata = array('file_name' => $_FILES['FileData']['tmp_name'], 'file_type' => $_FILES['FileData']['type'], 'group_name' => $attachedGroupName, 
            'orig_name' => $r['filename'], 'client_name' => $attachedFileName, 'file_ext' => $temp, 'file_size' => $attachedFileSize, 'is_image' => $is_image);
            $res = $this->messagemodel->addfile($sqldata);
            $arr = array('id' => $res, 'filename' => $attachedFileName, 'fileOriginalName' => $attachedFileName, 'fileSize' => $attachedFileSize);
            echo $this->uploaderResult($callback, $inputFileId, $arr);
        }
        else
        {
            echo '<script type="text/javascript"> alert("上传失败"); </script>';
        }
    }

    /**
     * uploaderResult(param1, param2)
     * param1:客户端上传上来的回调函数
     * param2:input file Id
     * param3:保存文件后服务器输出的结果
     */
    function uploaderResult($_callback, $_inputFileId, $_arr)
    {
        $result = '<script type="text/javascript">';
        $result .= ';window.parent[\'' . $_callback . '\'].call(window,';
        $result .= '\'' . json_encode($_arr);
        $result .= '\'' . ');';
        $result .= 'window.parent.document.getElementById("uploader-loading").style.display = "none";';
        $result .= 'window.parent.document.getElementById("' . $_inputFileId . '").style.display = "block";';
        $result .= '</script>';
        return $result;
    }

    /**
     * 执行ajax 显示 操作函数
     * @author gefeichao
     * @date 20110927
     * return json
     * Enter description here ...
     */
    function show_ajaxdata()
    {
        /****获取相应消息数据****/
        $messageCateGory = $this->input->get('messagesCateGory'); /*消息筛选类型*/
        $searchKey = $this->input->get('MessaginSearchQuery'); /*消息搜索关键字*/
        $page = $this->input->post('page'); /*消息筛选类型请求的分页数*/
        $pages = $page ? $page : 1;
        $data = '';
        $searchKey = shtmlspecialchars($searchKey);
        if($pages == 1){
        	$pagesize = 20;
        }else{
        	$pagesize = 10;	
        }
        if ($messageCateGory == '0')
        { //请求未读的消息
            $messresult = $this->showunreadlist($pages, $pagesize, $searchKey);
            $data = array('status' => $messresult['state'], 'data' => '这里是失败信息', 'messages' => $messresult['result'], 'isend' => $messresult['more']);
        }
        else 
            if ($messageCateGory == '2')
            { //请求存档的消息
                $messresult = $this->showarchivelist($pages, $pagesize, $searchKey);
                $data = array('status' => $messresult['state'], 'data' => '这里是失败信息', 'messages' => $messresult['result'], 'isend' => $messresult['more']);
            }
            else 
                if ($messageCateGory == '6')
                { //请求已发送的消息
                    $messresult = $this->setmessages($pages, $pagesize, $searchKey);
                    $data = array('status' => $messresult['state'], 'data' => '这里是失败信息', 'messages' => $messresult['result'], 'isend' => $messresult['more']);
                }
                else 
                    if ($messageCateGory == '')
                    { //请求全部消息
                        $messresult = $this->showmlist($pages, $pagesize, $searchKey);
                        $data = array('status' => $messresult['state'], 'data' => '这里是失败信息', 'messages' => $messresult['result'], 'isend' => $messresult['more']);
                    }
        echo json_encode($data);
    }

    /**
     * 获取未读信息条数
     * @author gefeichao
     * @date 2012-02-23
     * return json
     */
    function show_unreadinfo()
    {
        $uid = $this->uid;
		
		$infos = $this->messagemodel->show_unread($uid);
//		$key = 'dkcore_cache_showunreads_935'.$uid;
//		$cacheunread = call_soap('cache','Memcache','get',array('key'=>$key));
//		
//		if(! $cacheunread){
//			 $infos = $this->messagemodel->show_unread($uid);
//			 $val = call_soap('cache','Memcache','set',array('key'=>$key,'data'=>json_encode($infos)));			
//		}else{
//			$infos = json_decode($cacheunread,true);
//		}
        //返回json数据
        $data = array('status' => 1, 'data' => array('requests' => $infos[0]['un_invite'], 'messages' => $infos[0]['un_msg'], 'notice' => $infos[0]['un_notice']));
		
        echo json_encode($data);
    }
    
 	/**
     * 下载照片附件
     *
     * @author gefeichao
     * @date   2012-05-08
     * @access public
     */
    public function downloadPhoto(){
		require_once APPPATH . 'models/FdfsModel.php';
        $this->fdfs = FdfsModel::getInstance();
        $pid = $this->input->get('id');
        $photo_info = $this->messagemodel->get_files($pid);
        if(!$photo_info){
            echo "<script>alert('error!');</script>";
        }
        //取得照片原图
        //$fastdfs_group = config_item('fastdfs_group');
        $photores = $this->fdfs->download_filebuff($photo_info[0]['group_name'], $photo_info[0]['orig_name']);
        //echo $photores;exit;
        if ($photores) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/force-download');
            $filename = $photo_info[0]['client_name'];
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length:'.$photo_info[0]['file_size']);
            //ob_clean();
           // flush();
            echo $photores;
            exit;				
        }else{
            echo "<script>alert('文件不存在!');</script>";
        }

    }
}
?>	