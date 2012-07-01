<?php
/**
 * @desc 关注
 * @author lanyanguang
 * @date 2012-03-02
 * @version $Id: followingmodel.php 24928 2012-05-18 01:15:13Z lanyg $
 */

class FollowingModel extends MY_Model {
    /**
     * 页码方式获取用户的关注列表
     * 
     * @author lanyanguang
     * @date 2012-03-01
     * @param int $uid 用户uid
     * @param boolean $self 是否自己
     * @param int $offset 页码
     * @param int $limit 偏移量
     * @return array
     */
    function getFollowingsWithInfo($uid, $self, $offset, $limit, $login_uid) {
        $followings_userinfo = call_soap('social', 'Social', 'getFollowingsWithInfo', array($uid, $self, $offset, $limit, $login_uid));

        return $followings_userinfo;
    }

    /**
     * 偏移量方式获取用户的关注列表
     * 
     * @author lanyanguang
     * @date 2012-03-01
     * @param int $uid 用户uid
     * @param boolean $self 是否自己
     * @param int $offset 起始值
     * @param int $limit 偏移量
     * @return array
     */
    function getFollowingsWithInfoByOffset($uid, $self, $offset, $limit, $login_uid) {
        $followings_userinfo = call_soap('social', 'Social', 'getFollowingsWithInfoByOffset', array($uid, $self, $offset, $limit, $login_uid));
        
        return $followings_userinfo;
    }
    
    /**
     * 页码方式获取用户的相互关注列表
     * 
     * @author lanyanguang
     * @date 2012-03-01
     * @param int $uid 用户uid
     * @param boolean $self 是否自己
     * @param int $offset 页码
     * @param int $limit 偏移量
     * @return array
     */
    function getBothFollowersWithInfo($uid, $self, $offset, $limit, $login_uid) {
        $bothfollowings_userinfo = call_soap('social', 'Social', 'getBothFollowersWithInfo', array($uid, $self, $offset, $limit, $login_uid));
        
        return $bothfollowings_userinfo;
    }

    /**
     * 偏移量方式获取用户的相互关注列表
     * 
     * @author lanyanguang
     * @date 2012-03-01
     * @param int $uid 用户uid
     * @param boolean $self 是否自己
     * @param int $offset 起始值
     * @param int $limit 偏移量
     * @return void
     */
    function getBothFollowersWithInfoByOffset($uid, $self, $offset, $limit, $login_uid) {
        $bothfollowings_userinfo = call_soap('social', 'Social', 'getBothFollowersWithInfoByOffset', array($uid, $self, $offset, $limit, $login_uid));
        
        return $bothfollowings_userinfo;
    }
    
    /**
     * 页码方式获取用户的好友列表
     * 
     * @author lanyanguang
     * @date 2012-03-01
     * @param int $uid 用户uid
     * @param boolean $self 是否自己
     * @param int $offset 页码
     * @param int $limit 偏移量
     * @return void
     */
    function getFriendsWithInfo($uid, $self, $offset, $limit, $login_uid) {
        $friends_userinfo = call_soap('social', 'Social', 'getFriendsWithInfo', array($uid, $self, $offset, $limit, $login_uid));
        
        return $friends_userinfo;
    }
    
    /**
     * 偏移量方式获取用户的好友列表
     * 
     * @author lanyanguang
     * @date 2012-03-01
     * @param int $uid 用户ID
     * @param boolean $self 是否自己
     * @param int $offset 起始值
     * @param int $limit 偏移量
     * @return void
     */
    function getFriendsWithInfoByOffset($uid, $self, $offset, $limit, $login_uid) {
        $friends_userinfo = call_soap('social', 'Social', 'getFriendsWithInfoByOffset', array($uid, $self, $offset, $limit, $login_uid));
        
        return $friends_userinfo;
    }
    
    /**
     * 获得网页关注 
     * 
     * @author lanyanguang
     * @date 2012-04-24
     * @param int $uid 用户ID
     * @param int $iid 网页ID
     * @param boolean $is_display 是否显示
     * @param int $start 起始值
     * @param int $limit 偏移量
     * @param int $action_uid 目标用户变量
     * @return void
     */
    function getAttentionWeb($uid , $iid , $is_display , $start , $limit, $action_uid) {
        $web_info = call_soap('interest', 'Attention', 'get_attention_web', array($uid , $iid , $is_display , $start , $limit, $action_uid));
        return $web_info;
    }   
    
    /**
     * 通过用户名查找关注用户
     * 
     * @author lanyanguang
     * @date 2012-03-01
     * @param string $uid 用户uid
     * @param string $keyword 搜索用户名
     * @param int $offset 页码
     * @param int $limit 偏移量
     * @return string 关注用户
     */
    function getFollowingByUserName($uid, $keyword, $offset, $limit) {
        $followings_userinfo = call_soap('search', 'People', 'getFollowingReturnJSON', array($uid, $keyword, $offset, $limit));
        $followings_userinfo = json_decode($followings_userinfo, true);
        if ($followings_userinfo) {
            $followings_object = array();
            if (isset($followings_userinfo['object']) && is_array($followings_userinfo['object'])) {
              $followings_object = $followings_userinfo['object'];
              foreach ($followings_object as $k => $v) {
                    $followings_object[$k]['src'] = get_avatar($followings_object[$k]['id'], 'm');
                    $followings_object[$k]['href'] = mk_url(APP_URL.'/index/index', array('action_dkcode' => $followings_object[$k]['dkcode'])); 
                }
            }
            $followings_userinfo['object'] = $followings_object;
        }    

        return $followings_userinfo;
    }

    /**
     * 通过用户名查找关注用户
     * 
     * @author lanyanguang
     * @date 2012-05-04
     * @param string $uid 用户uid
     * @param string $iid 网页二级分类id
     * @param string $keyword 搜索用户名
     * @param int $offset 页码
     * @param int $limit 偏移量
     * @return string 关注用户
     */
    function getWebpagesByUser($uid, $iid, $keyword, $offset, $limit) {
        $followings_userinfo = call_soap('search', 'Webpage', 'getWebpagesByUser', array($uid, $iid, $keyword, $offset, $limit));
        $followings_userinfo = json_decode($followings_userinfo, true);
        if ($followings_userinfo) {
            $followings_object = array();
            if (isset($followings_userinfo['object']) && is_array($followings_userinfo['object'])) {
              $followings_object = $followings_userinfo['object'];
              foreach ($followings_object as $k => $v) {
                    $followings_object[$k]['src'] = get_webavatar($followings_object[$k]['creator_id'], 'm', $followings_object[$k]['id']);
                    $followings_object[$k]['href'] = mk_url(APP_URL.'/index/index', array('web_id' => $followings_object[$k]['id']), false); 
                }
            }
            $followings_userinfo['object'] = $followings_object;
        }    

        return $followings_userinfo;
    }
    
    /**
     * 通过用户名查找相互关注用户
     * 
     * @author lanyanguang
     * @date 2012-03-01
     * @param string $uid 用户uid
     * @param string $keyword 搜索用户名
     * @param int $offset 页码
     * @param int $limit 偏移量
     * @return string 关注用户
     */
    function getBothFollowingByUserName($uid, $keyword, $offset, $limit) {
        $followings_userinfo = call_soap('search', 'People', 'getFollowingUserEachOther', array($uid, $keyword, $offset, $limit));
        $followings_userinfo = json_decode($followings_userinfo, true);
        if ($followings_userinfo) {
            $followings_object = array();
            if (isset($followings_userinfo['object']) && is_array($followings_userinfo['object'])) {
              $followings_object = $followings_userinfo['object'];
              foreach ($followings_object as $k => $v) {
                    $followings_object[$k]['src'] = get_avatar($followings_object[$k]['id'], 'm');
                    $followings_object[$k]['href'] = mk_url(APP_URL.'/index/index', array('action_dkcode' => $followings_object[$k]['dkcode'])); 
                }
            }
            $followings_userinfo['object'] = $followings_object;
        }    
        return $followings_userinfo;
    }
   
    /**
     * 获得关注数
     * 
     * @author lanyanguang
     * @date 2012-03-01
     * @param int $uid 用户uid
     * @param boolean $self 是否自己
     * @return int
     */
    function getNumOfFollowings($uid, $self, $login_uid) {
        $followings_count = call_soap('social', 'Social', 'getNumOfFollowings', array($uid, $self, $login_uid));
        
        return $followings_count;
    }
    
    /**
     * 获得好友数
     * 
     * @author lanyanguang
     * @date 2012-03-01
     * @param int $uid 用户uid
     * @param boolean $self 是否自己
     * @return int
     */
    function getNumOfFriends($uid, $self, $login_uid) {
        $friends_count = call_soap('social', 'Social', 'getNumOfFriends', array($uid, $self, $login_uid));
        
        return $friends_count;
    }
    
    /**
     * 获得相互关注数量
     * 
     * @author lanyanguang
     * @date 2012-03-01
     * @param int $uid 用户uid
     * @param boolean $self 是否自己
     * @return int
     */
    function getNumOfBothFollowers($uid, $self, $login_uid) {
        $friends_count = call_soap('social', 'Social', 'getNumOfBothFollowers', array($uid, $self, $login_uid));
        
        return $friends_count;
    }
    
    /**
     * 隐藏关注用户
     * 
     * @author lanyanguang
     * @date 2012-03-01
     * @param int $uid 用户uid
     * @param int $following_id 目标用户uid
     * @return boolean true成功|false失败
     */
    function hideFollowing($uid, $following_id) {
        $result = call_soap('social','Social', 'hideFollowing', array($uid, $following_id));
        return $result;
    }
    
    /**
     * 隐藏关注网页
     * 
     * @author lanyanguang
     * @date 2012-04-24
     * @param int $uid 用户uid
     * @param int $following_id 目标用户pageid
     * @return boolean true成功|false失败
     */
    function hideWebFollowing($uid, $following_id) {
        $result = call_soap('interest', 'Attention', 'set_attention_web_show', array($uid, $following_id, 0));
        return $result;
    }
    
    /**
     * 取消隐藏关注用户
     * 
     * @author lanyanguang
     * @date 2012-03-01
     * @param int $uid 用户uid
     * @param int $following_id 目标用户uid
     * @return boolean true成功|false失败
     */
    function unHideFollowing($uid, $following_id) {
        $result = call_soap('social','Social', 'unHideFollowing', array($uid, $following_id));
        return $result;
    }
    
    /**
     * 取消隐藏关注网页
     * 
     * @author lanyanguang
     * @date 2012-04-24
     * @param int $uid 用户uid
     * @param int $following_id 目标用户pageid
     * @return boolean true成功|false失败
     */
    function unHideWebFollowing($uid, $following_id) {
        $result = call_soap('interest', 'Attention', 'set_attention_web_show', array($uid, $following_id, 1));
        return $result;
    }
    
     /**
     * 隐藏关注分类
      * 
     * @author lanyanguang
     * @date 2012-03-01
     * @param int $uid 用户uid
     * @param int $following_id 目标用户uid
     * @return boolean true成功|false失败
     */
    function hiddenFollowingCategory($uid, $following_id) {
        $result = call_soap('ucenter','MyFollowingHide', 'hiddenFollowingCategory', array($uid, $following_id));
        return $result;
    }
    
    /**
     * 隐藏网页关注分类
      * 
     * @author lanyanguang
     * @date 2012-04-24
     * @param int $uid 用户uid
     * @param int $following_id 分类id
     * @return boolean true成功|false失败
     */
    function hiddenWebFollowingCategory($uid, $following_id) {
        $result = call_soap('interest', 'Attention', 'set_attention_category_show', array($uid, $following_id, $is_show = 0));
        return $result;
    }
    
    /**
     * 取消隐藏关注分类
     * 
     * @author lanyanguang
     * @date 2012-03-01
     * @param int $uid 用户uid
     * @param int $following_id 目标用户uid
     * @return boolean true成功|false失败
     */
    function unHiddenFollowingCategory($uid, $following_id) {
        $result = call_soap('ucenter','MyFollowingHide', 'unHiddenFollowingCategory', array($uid, $following_id));
        return $result;
    }
    
    /**
     * 取消隐藏网页关注分类
     * 
     * @author lanyanguang
     * @date 2012-04-24
     * @param int $uid 用户uid
     * @param int $following_id 分类id
     * @return boolean true成功|false失败
     */
    function unHiddenWebFollowingCategory($uid, $following_id) {
        $result = call_soap('interest', 'Attention', 'set_attention_category_show', array($uid, $following_id, $is_show = 1));
        return $result;
    }  
    
    /**
     * 判断用户隐藏关系
     * 
     * @author lanyanguang
     * @date 2012-04-24
     * @param int $uid1 用户id
     * @param int $uid2 被隐藏用户id 
     */
    function isHiddenFollowing($uid1, $uid2) {
         return call_soap('social', 'Social', 'isHiddenFollowing', array($uid1, $uid2)); 
    }
    
    
    /**
     * 获得用户关注分类
     * 
     * @author lanyanguang
     * @date 2012-03-01
     * @param int $uid 用户ID
     */
    function getFollowingCategory($uid) {
        $result = call_soap('ucenter', 'MyFollowingHide', 'getFollowingCategory', array($uid));
        return $result;
    }

    /**
     * 获得用户关注分类
     * 
     * @author lanyanguang
     * @date 2012-04-24
     * @param int $uid 用户ID
     * @param boolean $is_self 是否自己
     */
    function getWebFollowingCategory($uid, $is_self) {
        $result = call_soap('interest', 'Attention', 'get_attention_category', array($uid, $is_self));
        return $result;
    }
    
    /**
     * 获得可能认识的人
     * 
     * @author lanyanguang
     * @date 2012-03-31
     * @param int $uid 用户ID
     * @param int $page 页码
     * @param int $size 偏移量
     */
    function getMayKnow($uid, $page, $size) {
        $result = call_soap('ucenter', 'MayKnow', 'getUserInfos', array($uid, $page, $size));
        return $result;
    }
    
    /**
     * 获得可能认识的网页
     * 
     * @author lanyanguang
     * @date 2012-05-10
     * @param int $iid 二级分类ID
     * @param int $uid 用户ID
     * @param int $page 页码
     * @param int $size 偏移量
     */
    function getWebMayKnow($iid, $uid, $page, $size) {
        $result = call_soap('ucenter', 'MayKnow', 'getWebInfos', array($iid, $uid, $page, $size));
        $result = json_decode($result, true);
        return $result;
    }
    
    /**
     * 获得可能认识的人数量
     * 
     * @author lanyanguang
     * @date 2012-03-31
     * @param int $uid 用户ID
     */
    function getMayKnowCount($uid) {
        $result = call_soap('ucenter','MayKnow', 'getCount', array($uid));
        return $result;
    }    
    
    /**
     * 获得可能认识的网页数量
     * 
     * @author lanyanguang
     * @date 2012-05-10
     * @param int $iid 二级分类ID
     * @param int $uid 用户ID
     */
    function getWebMayKnowCount($iid, $uid) {
        $result = call_soap('ucenter','MayKnow', 'getWebCount', array($iid, $uid));
        return $result;
    } 
    
    /**
     * 加关注|显示隐藏网页操作 更新网页索引
     * @author	lanyanguang
     * @date	2012/05/07
     * @param array $info 用户资料
     * @return boolean
     */
    function unHidingAUserInWebpage($info) {
        return call_soap('search', 'Webpage', 'unHidingAUserInWebpage', array($info));
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
     * 获得二级分类信息
     * @author	lanyanguang
     * @date	2012/05/07
     * @param int $iid 二级分类id
     * get_iid_info
     */
    function get_iid_info($iid) {
         return call_soap('interest', 'Index', 'get_iid_info', array($iid));
    }
    
}
/* End of file followingmodel.php */
/* Location: ./application/models/followingmodel.php */