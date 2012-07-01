<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 公共模块
 * 
 * @author  lanyanguang
 * @date     2012/3/20
 * @version $Id$
 */
class ApiModel extends MY_Model {
	/**
     * 构造函数
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * 取得用户资料
     * 
     * @author	lanyanguang
     * @date	2012/3/8
     * @param  string $uid 用户uid
     * @return mix
     */
    function getUserInfo($uid = null) {
        if (!$uid) {
            return false;
        }

        $lists = call_soap('ucenter', 'User', 'getUserInfo', array($uid, 'uid', array('uid', 'username', 'dkcode')));
        if (!$lists) {
            return false;
        }
        $lists['url'] = mk_url(APP_URL.'/index/index', array('action_dkcode' => $lists['dkcode']));
        $lists['avatar_img'] = get_avatar($uid,'ss');
        return $lists;
    }
    
    /**
     * 取得网页资料
     * 
     * @author	lanyanguang
     * @date	2012/05/04
     * @param  int $webid 网页id 
     * @return mix
     */
    function getWebInfo($webid = null) {
        if (!$webid) {
            return false;
        }

	    $tmp = call_soap('interest', 'Index', 'get_web_info', array($webid));
        $lists = (isset($tmp) && $tmp && count($tmp)>0) ? $tmp[0] : null;
        return $lists;
    }

    /**
     * 取得网页二级分类
     * 
     * @author	lanyanguang
     * @date	2012/05/10
     * @param  int $webid 网页id 
     * @return mix
     */
    function getWebIid($webid = null) {
        if (!$webid) {
            return false;
        }

	    return call_soap('interest', 'Index', 'get_web_category_id', array($webid));
    }
    
     /**
     * 是否关注
     * 
     * @author	lanyanguang
     * @date	2012/04/24
     * @param string $uid 用户uid
     * @param string $pageid 目标用户pageid
     * @return boolean
     */
    function isWebFollowing($uid = null, $pageid = null) {
        if (!$uid || !$pageid) {
            return false;
        }

        return call_soap('social', 'Webpage', 'isFollowing', array($uid, $pageid));
    }
    
    /**
     * 添加关注
     * @author	lanyanguang
     * @date	2012/04/24
     * @param string $uid 用户ID
     * @param string $pageid 目标pageid
     * @return boolean
     */
    function webFollow($uid = null, $pageid = null) {
        if (!$uid || !$pageid) {
           return false;
        }

        return call_soap('social', 'Webpage', 'follow', array($uid, $pageid));
    }

    /**
     * 添加关注时保存关注人的分类数据与网页的粉丝数
     * @author	lanyanguang
     * @date	2012/04/24
     * @param int $uid 用户ID
     * @param int $pageid 目标pageid
     * @param int $fans_count 粉丝数
     * @return boolean
     */
    function addAttention($uid, $pageid, $fans_count) {
        if (!$uid || !$pageid) {
           return false;
        }

        return call_soap('interest', 'Attention', 'add_attention', array($uid, $pageid, $fans_count));
    }

    /**
     * 取消关注
     * 
     * @author	lanyanguang
     * @date	2012/04/24
     * @param string $uid 用户ID
     * @param string $pageid  目标用户用户pageid
     * @return  成功返回true  失败返回false 
     */
    function unWebFollow($uid = null, $pageid = null) {
        if (!$uid || !$pageid) {
            return false;
        }

        return call_soap('social', 'Webpage', 'unFollow', array($uid, $pageid));
    }
    
    /**
     * 取消关注时保存关注人的分类数据与网页的粉丝数
     * @author	lanyanguang
     * @date	2012/04/24
     * @param int $uid 用户ID
     * @param int $pageid 目标pageid
     * @param int $fans_count 粉丝数
     * @return boolean
     */
    function delAttention($uid, $pageid, $fans_count) {
        if (!$uid || !$pageid) {
           return false;
        }

        return call_soap('interest', 'Attention', 'del_attention', array($uid, $pageid, $fans_count));
    }
    
    /**
     * 是否相互关注
     * 
     * @author	lanyanguang
     * @date	2012/3/8
     * @param string $uid1 用户uid
     * @param string $uid2 目标用户uid
     * @return boolean
     */
    function isBothFollow($uid1 = null, $uid2 = null) {
        if (!$uid1 || !$uid2) {
            return false;
        }

        return call_soap('social', 'Social', 'isBothFollow',array($uid1, $uid2));
    }

    /**
     * 是否单向关注
     * 
     * @author	lanyanguang
     * @date	2012/3/8
     * @param string $uid1 用户uid
     * @param string $uid2 目标用户uid
     * @return boolean
     */
    function isFollowing($uid1 = null, $uid2 = null) {
        if (!$uid1 || !$uid2) {
            return false;
        }

        return call_soap('social', 'Social', 'isFollowing',array($uid1, $uid2));
    }
    
    /**
     * 是否好友关系
     * 
     * @author	lanyanguang
     * @date	2012/3/8
     * @param string $uid1 用户uid
     * @param string $uid2 目标用户uid
     * @return boolean
     */
    function isFriend($uid1 = null, $uid2 = null) {
        if(!$uid1 || !$uid2){
            return false;
        }

        return call_soap('social', 'Social', 'isFriend',array($uid1, $uid2));
    }    

    /**
     * 是否发起过好友邀请
     * 
     * @author	lanyanguang
     * @date	2012/3/8
     * @param string $uid1 用户uid
     * @param string $uid2 目标用户uid
     * @return boolean 
     */
    function hasRequested($uid1 = null, $uid2 = null, $is_both = true) {
        if (!$uid1 || !$uid2) {
            return false;
        }

        return call_soap('social', 'Social', 'hasRequested', array($uid1, $uid2, $is_both));
    } 
    
    /**
     * 接收好友邀请
     * 
     * @author	lanyanguang
     * @date	2012/3/8
     * @param string $uid1 接受请求的用户
     * @param string $uid2 发送请求的用户
     * @return  成功返回true  失败返回false 
     */
    function approveFriendRequest($uid1 = null, $uid2 = null) {
        if (!$uid1 || !$uid2) {
            return false;
        }

        return call_soap('social', 'Social', 'approveFriendRequest', array($uid1, $uid2));
    } 

    /**
     * 接收好友邀请更新索引
     * 
     * @author	lanyanguang
     * @date	2012/04/24
     * @param string $uid1 接受请求的用户
     * @param string $uid2 发送请求的用户
     * @return  成功返回true  失败返回false 
     */
    function addOneToMyFriends($uid1 = null, $uid2 = null) {
        if (!$uid1 || !$uid2) {
            return false;
        }

        return call_soap('search', 'RelationIndex', 'addOneToMyFriends', array($uid1, $uid2));
    } 
    
    /**
     * 发送好友请求
     * 
     * @author	lanyanguang
     * @date	2012/3/8
     * @param string $uid1 用户ID
     * @param string $uid2 目标用户ID
     * @return boolean
     */
    function makeFriend($uid1 = null, $uid2 = null) {
        if (!$uid1 || !$uid2) {
            return false;
        }

        return call_soap('social', 'Social', 'makeFriend', array($uid1, $uid2));
    }
    
    /**
     * 加好友
     * 
     * @author	lanyanguang
     * @date	2012/05/24
     * @param string $uid1 用户ID
     * @param string $uid2 目标用户ID
     * @return boolean
     */
    function addFriend($uid1 = null, $uid2 = null) {
        if (!$uid1 || !$uid2) {
            return false;
        }

        return call_soap('social', 'Social', 'addFriend', array($uid1, $uid2));
    }
    
     /**
     * 获得关系
     * 
     * @author	lanyanguang
     * @date	2012/3/8
     * @param string $uid1 用户ID
     * @param string $uid2 目标用户ID
     * @return int 
     */
    /*function getRelationWithUser($uid1 = null, $uid2 = null) {
        if (!$uid1 || !$uid2) {
           return false;
        }

        return call_soap('social', 'Social', 'getRelationWithUser', array($uid1, $uid2));
    }*/
    
    /**
     * 获得关系状态
     * 
     * @author	lanyanguang
     * @date	2012/05/24
     * @param string $uid1 用户ID
     * @param string $uid2 目标用户ID
     * @return int 
     */
    function getRelationStatus($uid1 = null, $uid2 = null) {
        if (!$uid1 || !$uid2) {
           return false;
        }

        return call_soap('social', 'Social', 'getRelationStatus', array($uid1, $uid2));
    }
    
    /**
     * 添加关注
     * @author	lanyanguang
     * @date	2012/3/8
     * @param string $uid1 用户ID
     * @param string $uid2 目标用户ID
     * @return boolean
     */
    function follow($uid1 = null, $uid2 = null) {
        if (!$uid1 || !$uid2) {
           return false;
        }

        return call_soap('social', 'Social', 'follow', array($uid1, $uid2));
    }

    /**
     * 添加关注更新索引
     * @author	lanyanguang
     * @date	2012/04/24
     * @param string $uid1 用户ID
     * @param string $uid2 目标用户ID
     * @return boolean
     */
    function addOneToMyFollowings($uid1 = null, $uid2 = null) {
        if (!$uid1 || !$uid2) {
           return false;
        }

        return call_soap('search', 'RelationIndex', 'addOneToMyFollowings', array($uid1, $uid2));
    }

    /**
     * 取消关注
     * 
     * @author	lanyanguang
     * @date	2012/3/8
     * @param string $uid1 用户ID
     * @param string $uid2  目标用户ID
     * @return  成功返回true  失败返回false 
     */
    function unfollow($uid1 = null, $uid2 = null) {
        if (!$uid1 || !$uid2) {
            return false;
        }

        return call_soap('social', 'Social', 'unFollow', array($uid1, $uid2));
    }
    
    /**
     * 取消关注更新索引
     * @author	lanyanguang
     * @date	2012/04/24
     * @param string $uid1 用户ID
     * @param string $uid2 目标用户ID
     * @return boolean
     */
    function removeOneOfMyFollowings($uid1 = null, $uid2 = null) {
        if (!$uid1 || !$uid2) {
           return false;
        }

        return call_soap('search', 'RelationIndex', 'removeOneOfMyFollowings', array($uid1, $uid2));      
    }
    
    /**
     * 删除好友
     * 
     * @author	lanyanguang
     * @date	2012/3/8
     * @param string $uid1 用户ID
     * @param string $uid2  目标用户ID
     * @return boolean
     */
    function deleteFriend($uid1 = null, $uid2 = null) {
        if (!$uid1 || !$uid2) {
            return false;
        }

        return call_soap('social', 'Social', 'deleteFriend', array($uid1, $uid2));
    }
    
    /**
     * 删除好友更新索引
     * 
     * @author	lanyanguang
     * @date	2012/04/24
     * @param string $uid1 用户ID
     * @param string $uid2  目标用户ID
     * @return boolean
     */
    function removeOneOfMyFriends($uid1 = null, $uid2 = null) {
        if (!$uid1 || !$uid2) {
            return false;
        }

        return call_soap('search', 'RelationIndex', 'removeOneOfMyFriends', array($uid1, $uid2));
    }
    
    /**
     * 显示隐藏网页操作 更新网页索引
     * @author	lanyanguang
     * @date	2012/05/07
     * @param array $info 用户资料
     * @return boolean
     */
    function unHidingAUserInWebpage($info) {
        return call_soap('search', 'Webpage', 'unHidingAUserInWebpage', array($info));
    }

    /**
     * 加关注操作 更新网页索引
     * @author	lanyanguang
     * @date	2012/05/17
     * @param array $info 用户资料
     * @return boolean
     */
    function addAFansToWeb($info) {
        return call_soap('search', 'Webpage', 'addAFansToWeb', array($info));
    }
    
    /**
     * 隐藏网页 更新网页索引
     * @author	lanyanguang
     * @date	2012/05/07
     * @param array $info 用户资料
     * @return boolean
     */
    function hidingAUserInWebpage($info) {
        return call_soap('search', 'Webpage', 'hidingAUserInWebpage', array($info));
    }

    /**
     * 取消网页 更新网页索引
     * @author	lanyanguang
     * @date	2012/05/07
     * @param array $info 用户资料
     * @return boolean
     */
    function deleteUserOfWeb($web_id = null, $user_id = null) {
        if (!$web_id || !$user_id) {
            return false;
        }
        
        return call_soap('search', 'Webpage', 'deleteUserOfWeb', array($web_id, $user_id));
    }
    
    /**
     * 发送短信
     * 
     * @author	lanyanguang
     * @date	2012/3/8
     * @param string|array $mobile 手机号码
     * @param string 短信内容
     * @return array 
     * @see state: 0:    成功;
     *             17:   发送信息失败;
     *             18:   发送定时信息失败;
     *             101:  客户端网络故障;
     *             305:  服务器端返回错误，错误的返回值（返回值不是数字字符串）;
     *             307:  目标电话号码不符合规则，电话号码必须是以0、1开头;
     *             997:  平台返回找不到超时的短信，该信息是否成功无法确定;
     *             998:  由于客户端网络问题导致信息发送超时，该信息是否成功下发无法确定;
     *             9001: 号码为空;
     * @see error: 错误的手机号数组
     */
    function sendSMS($mobile = null, $content = null) {
         
        if (!$mobile || !is_numeric($mobile) || !$content) {
            return false;
        }

        return call_soap('sms', 'Index', 'sendSMS', array(array($mobile), $content));

    }

    /**
     * 发送通知
     * 
     * @author	lanyanguang
     * @date	2012/3/8
     * @param int $notice_type 通知类型 1 个人通知 2 网页通知
     * @param int $uid  发送通知当前用户uid
     * @param int $to_uid  接收用户uid
     * @param string $btype  通知大分类
     * @param string $stype  通知小分类
     * @param array $param   其他参数（如URL）
     * @return state@
     * 1   操作对象uid 不存在
     * 2   大分类不存在
     * 3   小分类不存在
     * 4   当前用户登录uid不存在
     * 5   信息对应分类过滤失败
     * 6   小分类输入错误
     * 7   操作失败！
     * 8   操作成功！
     * */
    function sendNotice($notice_type = 1, $uid = NULL, $to_uid = NULL, $btype = NULL, $stype = NULL, $param = array()) {
        if (!$notice_type || !$uid || !$to_uid || !$btype || !$stype) {
            return false;
        }

        return call_soap('ucenter', 'Notice', 'add_notice',array($notice_type, $uid, $to_uid, $btype, $stype, $param));
    }
    
    /**
     * 添加关注后对可能认识的人的数据更新
     * 
     * @author lanyanguang
     * @date 2012-03-31
     * @param int $uid1 用户ID
     * @param string $uid2  目标用户ID
     */
    function updateIndex($uid1 = null, $uid2 = null) {
        if (!$uid1 || !$uid2) {
            return false;
        }
        
        $result = call_soap('ucenter','MayKnow', 'updateIndex', array($uid1, $uid2));
        return $result;
    } 
    
    /**
     * 添加关注后对可能认识的网页的数据更新
     * 
     * @author lanyanguang
     * @date 2012-05-11
     * @param int $iid 二级分类ID
     * @param string $webid 网页id
     */
    function updateWebIndex($iid = null, $uid = null, $webid = null) {
        if (!$iid || !$uid || !$webid) {
            return false;
        }
        
        $result = call_soap('ucenter','MayKnow', 'updateWebIndex', array($iid, $uid, $webid));
        return $result;
    } 
}
/* End of file apimodel.php */
/* Location: ./application/models/apimodel.php */
