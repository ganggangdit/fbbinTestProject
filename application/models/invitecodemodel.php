<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 邀请码模块
 * 
 * Enter description here ...
 * @author  bohailiang
 * @date    2012/2/22 
 * @version 1.2
 */
class Invitecodemodel extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}


	/**
	 * 取得我推荐的人列表
	 *
	 * @author hujiashan
	 * @date   2012/3/8
	 * @access public
	 * @param string $uid 用户uid
	 * @param int $nowpage 查询当前页面
	 * @param int $limit 显示查询数据数目
	 * @return 返回推荐者数组
	 */
	function get_recommend_lists($uid = null,$start = 0,$limit = 50){
		
		$uid = mysql_real_escape_string($uid);
		if(!$uid){
			return false;
		}
		
		//返回我推荐的人 的用户信息列表
		$user_lists = call_soap('ucenter', 'InviteCode', 'getMyRecommandUsers', array($uid, $start, $limit));
		$user_lists  = unserialize($user_lists);
		if(!$user_lists){
			return false;
		}

		$lists = array();
		foreach($user_lists as $k => $v){
			//头像小图50x50
			$v['avatar_img'] = get_avatar($v['uid'], 's');
			$v['url'] = mk_url(APP_URL.'/index/index', array('action_dkcode' => $v['dkcode']));
			$lists[] = $v;
		}
		
		return $lists;
	}

	
	/**
	 * 邀请一个用户,获取剩余邀请码数量
	 * @param $name string 被邀请者用户名 
	 * @param $mobile int 被邀请者手机号
	 * @param $uid string 邀请者用户ID
	 *  @return 返回数组
	 */
	
	function invite_user($name = null, $mobile = null, $uid = null){
		
		$uid = mysql_real_escape_string($uid);
		if(!$name || !$mobile || !$uid){
			return false;
		}
	
		return call_soap('ucenter', 'InviteCode', 'inviteUserByUid', array($name, $mobile, $uid));
	}
	
	/**
	 * 
	 * 检查手机是否已被使用
	 * @param int $uid
	 * @param int $mobile
	 * @author  hujiashan
	 * @date  2012/4/18
	 */
	function checkmobile($uid = null, $mobile = null){
		if(!$mobile || !$uid){
			return false;
		}
		return call_soap('ucenter', 'InviteCode', 'phoneTimesRule', array($uid, $mobile));
	}
	
	
	/**
	 * 
	 *  首页加载时获取"提供邀请码给我的人"\"我邀请成功的人"\"剩余邀请码数量"\"获取我推荐且 成功注册人的总数"
	 *  @author hujiashan
	 *  @date 2012-5-25
	 * @param int $uid
	 * @param int $dkcode
	 * @param int = $offsent
	 * @param int $limit
	 * @return Array
	 */
	function getInviteCodeAllStatus($uid = NULL, $dkcode = NULL, $offsent =0, $limit = 12){
		if(!$uid || !$dkcode){
			return false;
		}
		
		$data = call_soap('ucenter', 'InviteCode', 'getInviteCodeAllStatus', array($uid, $dkcode, $offsent, $limit));
		return json_decode($data , true);
	}
		
}
/* End of file invitecodemodel.php */
/* Location: ./application/models/invitecodemodel.php */