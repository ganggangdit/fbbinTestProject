<?php
  /**
   * @desc 好友
   * @author yaohaiqi
   * @date 2012-03-02
   */
class FriendModel extends MY_Model {
    
        /**
         * 获取用户的好友列表 - 包含用户信息
         * 
        * @param type $uid 用户的ID
        * @param bool $self 是否是该用户自己获取好友列表
        * @param type $offset 页码
        * @param type $limit 每页数量
        * @return type 
        */
        public function getFriendsWithInfo($self, $uid, $login_uid, $page=1, $limit=27) {
            return call_soap('social', 'Social', 'getFriendsWithInfo',array($uid, $self, $page, $limit, $login_uid));
	}
        
        public function getFriendsindex($self, $uid, $login_uid, $page=1) {
            $page = ($page<= 0) ? 1 :$page;
            if($page > 1){
                return call_soap('social','Social', 'getFriendsWithInfoByOffset',array($uid, $self, $start=15, $limit=45, $login_uid));
            }else{
                return call_soap('social','Social', 'getFriendsWithInfoByOffset',array($uid, $self, $start=0, $limit=15, $login_uid));
            }
	}
        
        //通过姓名查找好友
        public function getFriendByName($uid, $keyword='', $page=1) {
            $resuslt = call_soap("search", "People", "getFriendsReturnJSON", array($uid, $keyword, $page));
            $resuslt = json_decode($resuslt, true);
            return  $resuslt;
	}
        
        /**
        * 获取用户的好友数量
        * @param type $uid 用户的ID
        * @return type 
        */
        public function getNumOfFriends($self, $uid, $login_uid) {
            return call_soap('social','Social', 'getNumOfFriends',array($uid, $self, $login_uid));
        }
        
        /**
         * 用户隐藏某个好友，使这个好友在别人查看其好友列表时不可见
        * 1为隐藏，0为非隐藏
        * @param int $uid
        * @param int $friendId
        */
        public function hideFriend($uid, $friendId) {
            return call_soap('social','Social', 'hideFriend',array($uid, $friendId));
        }
        /**
         * 取消隐藏
         */
        public function unHideFriend($uid, $friendId) {
            return call_soap('social', 'Social', 'unHideFriend', array($uid, $friendId)); 
        }
        
        public function HiddenStatus($uid, $friendId) {
            return call_soap('social', 'Social', 'isHiddenFriend', array($uid, $friendId)); 
        }
        /**
         * 创建群组
         */
        public function getFriendsUseIntoGroup($uid, $login_uid, $page=1) {
            $offset = ($page - 1) * 25;
            $limit = 25;
            return call_soap('social','Social', 'getFriendsWithInfoByOffset',array($uid, true, $offset, $limit, $login_uid));
	}
}
?>