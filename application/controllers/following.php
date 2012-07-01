<?php
/**
 * @desc 关注首页 关注列表
 * @author lanyanguang
 * @date 2012-03-01
 * @version $Id: following.php 26803 2012-06-01 16:00:01Z wangy $
 */
class Following extends MY_Controller {
    
    /**
     * 获取网页分类id
     * 
     * @var int 
     */
    private $web_id;

    /**
     * 构造函数
     */
    function __construct() {
        parent::__construct();
        
        //判断是否本人
        if (!$this->action_uid) {
            $this->action_uid = $this->uid;
            $this->action_user = $this->user;
            $this->action_dkcode = $this->dkcode;
            $this->_self = true;
        } elseif ($this->action_uid == $this->uid) {
            $this->_self = true;
        }
        $this->web_id = $this->input->get_post('web_id');
        $this->load->model('followingmodel');
    }
    
    /**
     * 获得主页用户信息
     * 
     * @author lanyanguang
     * @date 2012-03-01
     * @return array
     */
    private function _getCurrentUserInfo() {
        $array = array('action_dkcode' => $this->action_dkcode);
        if (!empty($this->web_id)) {
           $array['web_id'] = $this->web_id;
        }    
        return $userinfo = array(
            'uid' => $this->action_uid,
            'avatar' => get_avatar($this->action_uid, 'ss'),
            'username' => $this->action_user['username'],
            'url' => mk_url(APP_URL.'/index/index', array('action_dkcode' => $this->action_dkcode)),
            'self_url' => mk_url(APP_URL . '/' . $this->input->get('c') . '/' . $this->input->get('m'), $array)
        );
    }


    /**
     * 关注首页
     * 
     * @author lanyanguang
     * @date 2012-03-01
     */
    function index() {    
        //主页用户信息 lanyanguang 2012-03-01 开始
        $userinfo = $this->_getCurrentUserInfo();
        $this->assign('userinfo', $userinfo);
        $this->assign('is_self', $this->_self);
        //主页用户信息 lanyanguang 2012-03-01 结束

        //周天良 修改
        $this->assign('fdfsinfo', array('host'=>$this->config->item('fastdfs_host'),'group'=>$this->config->item('fastdfs_group')));
        $login_info['avatar_url'] = get_avatar($this->user['uid']);
        $login_info['uid']    = $this->uid;
        $login_info['username'] = $this->user['username'];
        $login_info['url']    = mk_url(APP_URL.'/index/index', array('action_dkcode' => $this->dkcode));
        $this->assign('login_info',$login_info);
        $this->assign('action_uid',$this->action_uid);
        //周天良 修改结束
       
        //视频，视频图片url wangying
		$this->assign('video_pic_domain',config_item('video_pic_domain'));
		$this->assign('video_src_domain',config_item('video_src_domain'));

        $this->display('following/index.html');
    }
    
    /**
     * 关注首页默认显示分类
     * 
     * @author lanyanguang
     * @date 2012-03-01
     */
    function getFollowingCategory() {
        //返回json数组
        $list = array();
        $list['state'] = 1;
        $data = array();
        
        //获得分类数据
        $category = (array) $this->followingmodel->getFollowingCategory($this->action_uid);
        
        //判断是否是自己
        if ($this->_self) {
            // //自己
            $list['self'] = 1;
            foreach ($category as $key => $val) {
                $data[$key]['content'] = $val['name'];
                $data[$key]['classN'] = $val['id'];
                $data[$key]['state'] = ($val['id'] == 0) ? 'on' : '';
                $data[$key]['see'] = ($val['hidden'] == 1) ? 'hid' : '';
            }    
        } else {
            //目标用户
            $list['self'] = 0;
            $i = 0;
            foreach ($category as $key => $val) {
                if (0 == $val['hidden']) {
                    $data[$i]['content'] = $val['name'];
                    $data[$i]['classN'] = $val['id'];
                    $data[$i]['state'] = ($val['id'] == 0) ? 'on' : '';
                    $data[$i]['see'] = '';
                    $i++;
                }
            }   
        }
        
        $list['data'] = $data;
        die(json_encode($list));
    }

    /**
     * 关注首页显示网页分类
     * 
     * @author lanyanguang
     * @date 2012-03-01
     */
    function getWebFollowingCategory() {
        //返回json数组
        $list = array();
        $list['state'] = 1;
        $data = array();
        
        //获得分类数据
        $category = (array) $this->followingmodel->getWebFollowingCategory($this->action_uid, $this->_self);

        foreach ($category as $key => $val) {
            $data[$key]['content'] = $val['iname'];
            $data[$key]['classN'] = $val['iid'];
            $data[$key]['state'] = '';
            $data[$key]['see'] = isset($val['is_display']) ? (($val['is_display'] == 0) ? 'hid' : '') : '';
        }    
        
        $list['data'] = $data;
        die(json_encode($list));
    }
    
    /**
     * 关注首页默认显示个人关系列表
     * 
     * @author lanyanguang
     * @date 2012-03-01
     */
    function getFollowingList() {
        //返回json数组
        $list = array();
        $list['state'] = 1;
        $data = array();
        
        //获得关注数
        $num = (int) $this->followingmodel->getNumOfFollowings($this->action_uid, $this->_self, $this->uid);
        
        //获得关注列表
        $following = (array) $this->followingmodel->getFollowingsWithInfo($this->action_uid, $this->_self, 1, 60, $this->uid);
        foreach ($following as $k => $v) {
            $data[$k]['src'] = get_avatar($following[$k]['id'], 's');
            $data[$k]['pid'] = $following[$k]['id'];
            $data[$k]['name'] = $following[$k]['name'];
            $data[$k]['href'] = mk_url(APP_URL.'/index/index', array('action_dkcode' => $following[$k]['dkcode']));
        }
        $list['data'] = array('num' => $num, 'type' => 0,
                              'link' => mk_url(APP_URL.'/following/followingList', array('action_dkcode' => $this->action_dkcode)),
                              'list' => $data
                        );
        
        die(json_encode($list));
    }
    
    /**
     * 关注首页可能认识的人
     * 
     * @author lanyanguang
     * @date 2012-03-01
     */
    function getMayKnowList() {

        //返回json数组 
        $list = array();
        $list['state'] = 1;
        $data = array();

        $following = (array) $this->followingmodel->getMayKnow($this->action_uid, 1, 60);
        $num = (int) $this->followingmodel->getMayKnowCount($this->action_uid);
        $link = mk_url(APP_URL.'/following/mayKnowList', array('action_dkcode' => $this->action_dkcode)); 
        
        foreach ($following as $k => $v) {
            $data[$k]['src'] = get_avatar($following[$k]['id'], 's');
            $data[$k]['pid'] = $following[$k]['id'];
            $data[$k]['name'] = $following[$k]['name'];
            $data[$k]['href'] = mk_url(APP_URL.'/index/index', array('action_dkcode' => $following[$k]['dkcode']));
        }
        
        $list['data'] = array('num' => $num,
                              'link' => $link, 
                              'list' => $data);
        
        die(json_encode($list));
    }
    
    /**
     * 关注首页可能认识的网页
     * 
     * @author lanyanguang
     * @date 2012-05-10
     */
    function getWebMayKnowList() {

        //获得关系分类
        $type = (int) $this->input->get('f_id');
        if (empty($type)) {
            die(json_encode(array('state'=>0)));
        }
        
        //返回json数组 
        $list = array();
        $list['state'] = 1;
        $data = array();

        $following = $this->followingmodel->getWebMayKnow($type, $this->action_uid, 1, 60);
        
        $num = (int) $this->followingmodel->getWebMayKnowCount($type, $this->action_uid);
        $link = mk_url(APP_URL.'/following/webMayKnowList', array('action_dkcode' => $this->action_dkcode, 'web_id'=> $type)); 
        
        if (!empty($following)) {
            foreach ($following as $k => $v) {
                $data[$k]['src'] = get_webavatar($following[$k]['uid'], 'm', $following[$k]['aid']);
                $data[$k]['pid'] = $following[$k]['aid'];
                $data[$k]['name'] = $following[$k]['name'];
                $data[$k]['href'] = mk_url(APP_URL.'/index/index', array('web_id' => $following[$k]['aid']), false); 
            }
        }
        
        $list['data'] = array('num' => $num,
                              'link' => $link, 
                              'list' => $data
                              );
        
        die(json_encode($list));
    }
    
    /**
     * 关注首页默认显示关系列表
     * 
     * @author lanyanguang
     * @date 2012-03-01
     */
    function getFollowingByType() {
        //获得关系分类
        $type = (int) $this->input->get('f_id');
        $type = !empty($type) ? $type : 0;
        
        //返回json数组 
        $list = array();
        $list['state'] = 1;
        $data = array();
        
        if (0 == $type) {
            //个人
            $num = (int) $this->followingmodel->getNumOfFollowings($this->action_uid, $this->_self, $this->uid);
            $following = (array) $this->followingmodel->getFollowingsWithInfoByOffset($this->action_uid, $this->_self, 0, 60, $this->uid);
            $link = mk_url(APP_URL.'/following/followingList', array('action_dkcode' => $this->action_dkcode));
        } elseif (1 == $type) {
            //相互关注
            $num = (int) $this->followingmodel->getNumOfBothFollowers($this->action_uid, $this->_self, $this->uid);
            $following = (array) $this->followingmodel->getBothFollowersWithInfoByOffset($this->action_uid, $this->_self, 0, 60, $this->uid);
            $link = mk_url(APP_URL.'/following/bothFollowingList', array('action_dkcode' => $this->action_dkcode));
        } elseif(2 == $type) {
            //好友 
            $num = (int) $this->followingmodel->getNumOfFriends($this->action_uid, $this->_self, $this->uid);
            $following = (array) $this->followingmodel->getFriendsWithInfoByOffset($this->action_uid, $this->_self, 0, 60, $this->uid);
            $link = mk_url(APP_URL.'/friend/friendlist', array('action_dkcode' => $this->action_dkcode));
        }    
        
        foreach ($following as $k => $v) {
            $data[$k]['src'] = get_avatar($following[$k]['id'], 's');
            $data[$k]['pid'] = $following[$k]['id'];
            $data[$k]['name'] = $following[$k]['name'];
            $data[$k]['href'] = mk_url(APP_URL.'/index/index', array('action_dkcode' => $following[$k]['dkcode']));
        }

        $list['data'] = array('num' => $num,
                              'type' => $type, 
                              'link' => $link, 
                              'list' => $data);
        
        die(json_encode($list));
    }

    /**
     * 关注首页默认显示网页关系列表
     * 
     * @author lanyanguang
     * @date 2012-04-24
     */
    function getWebFollowingByCategoryId() {
        //获得关系分类
        $type = (int) $this->input->get('f_id');
        if (empty($type)) {
            die(json_encode(array('state'=>0)));
        }
        
        //返回json数组 
        $list = array();
        $list['state'] = 1;
        $data = array();
        
        //某个分类下的关注网页
        $webfollowing = (array) $this->followingmodel->getAttentionWeb($this->action_uid , $type , $this->_self, 0, 60, $this->uid);
        $num = isset($webfollowing['ct']) ? $webfollowing['ct'] : 0;
        $following = isset($webfollowing['data']) ? $webfollowing['data'] : array();
        $link = mk_url(APP_URL.'/following/webFollowinglist', array('action_dkcode' => $this->action_dkcode, 'web_id'=> $type));
        
        foreach ($following as $k => $v) {
            $data[$k]['src'] = get_webavatar($following[$k]['web_uid'], 's', $following[$k]['aid']);
            $data[$k]['pid'] = $following[$k]['aid'];
            $data[$k]['name'] = $following[$k]['name'];
            $data[$k]['href'] = mk_url(APP_URL.'/index/index', array('web_id' => $following[$k]['aid']), false);
        }

        $list['data'] = array('num' => $num,
                              'type' => $type, 
                              'link' => $link, 
                              'list' => $data);
        
        die(json_encode($list));
    }
    
    /**
     * 关注列表
     * 
     * @author lanyanguang
     * @date 2012-03-01
     */
    function followingList() {
        //用户主页信息
        $userinfo = $this->_getCurrentUserInfo();
        
        //获得关注数
        $followings_count = (int) $this->followingmodel->getNumOfFollowings($this->action_uid, $this->_self, $this->uid);
        
        //获得关注列表
        $followinglist = array();
        if ($followings_count>0) {
            $followinglist = (array) $this->followingmodel->getFollowingsWithInfo($this->action_uid, $this->_self, 1, 27, $this->uid);
            foreach ($followinglist as $k => $v) {
                $followinglist[$k]['src'] = get_avatar($followinglist[$k]['id'], 'm');
                $followinglist[$k]['href'] = mk_url(APP_URL.'/index/index', array('action_dkcode' => $followinglist[$k]['dkcode']));    
            }
        }
        
        $this->assign('userinfo', $userinfo);
        $this->assign('is_self', $this->_self);
        $this->assign('followings_count', $followings_count);
        $this->assign('followinglist', $followinglist);
        $this->display('following/list.html');
    }
    
    /**
     * 网页关注列表
     * 
     * @author lanyanguang
     * @date 2012-04-24
     */
    function webFollowingList() {
        //用户主页信息
        $userinfo = $this->_getCurrentUserInfo();
        
        //获得网页分类
        $webinfo = $this->followingmodel->get_iid_info($this->web_id);
       
         //某个分类下的关注网页
        $webfollowing = (array) $this->followingmodel->getAttentionWeb($this->action_uid , $this->web_id , $this->_self, 0, 27, $this->uid);
        $followings_count = isset($webfollowing['ct']) ? $webfollowing['ct'] : 0;
        $followinglist = isset($webfollowing['data']) ? $webfollowing['data'] : array();
        //获得网页关注列表
        foreach ($followinglist as $k => $v) {
                $followinglist[$k]['src'] = get_webavatar($followinglist[$k]['web_uid'], 'm', $followinglist[$k]['aid']);
                $followinglist[$k]['href'] = mk_url(APP_URL.'/index/index', array('web_id' => $followinglist[$k]['aid']), false);   
        }
        
        $this->assign('userinfo', $userinfo);
        $this->assign('is_self', $this->_self);
        $this->assign('followings_name', $webinfo['iname']);
        $this->assign('followings_count', $followings_count);
        $this->assign('followinglist', $followinglist);
        $this->display('following/weblist.html');
    }
    
    /**
     * 关注列表更多分页数据
     * 
     * @author lanyanguang
     * @date 2012-03-01
     */
    function getFollowingsByPage() {
        //获得页码
        $page = (int) $this->input->post("pager");
        $page = !empty($page) ? $page : 1;
        
        //获得关注数
        $followings_count = (int) $this->followingmodel->getNumOfFollowings($this->action_uid, $this->_self, $this->uid);
        
        //获得关注列表
        $followinglist = array();
        if ($followings_count>0) {
            $followinglist = (array) $this->followingmodel->getFollowingsWithInfo($this->action_uid, $this->_self, $page, 27, $this->uid);
            foreach ($followinglist as $k => $v) {
                $followinglist[$k]['src'] = get_avatar($followinglist[$k]['id'], 'm');
                $followinglist[$k]['href'] = mk_url(APP_URL.'/index/index', array('action_dkcode' => $followinglist[$k]['dkcode']));    
            }
        }
        
        //返回json数组   
        $data = array();
        $data['state'] = '1';
        $data['msg'] = 'success!';
        
        //是否最后一页
        $last = true;
        if ($followings_count - $page * 27 > 0) {
            $last = false;
        }
        $data['last'] = $last;
        
        $lists = '';
        if ($this->_self) {
            foreach ($followinglist as $k => $v) {
                $class  = $followinglist[$k]['hidden'] ? 'invisible' : '';
                $lists  .= '<li><div class="avatarBox '.$class.'">';
                $lists  .= '<a href="'.$followinglist[$k]['href'].'"><img src="'.$followinglist[$k]['src'].'" alt="" /></a>';
                $lists  .= '<s id="'.$followinglist[$k]['id'].'"></s>';
                $lists  .= '</div>';
                $lists  .= '<span class="uName"><a href="'.$followinglist[$k]['href'].'">'.$followinglist[$k]['name'].'</a>';
                $lists  .= '</span></li>';
            }
        } else {
            foreach ($followinglist as $k => $v) {
                $lists .= '<li><div class="avatarBox">';
                $lists .= '<a href="'.$followinglist[$k]['href'].'"><img src="'.$followinglist[$k]['src'].'" alt="" /></a>';
                $lists .= '</div>';
                $lists .= '<span class="uName"><a href="'.$followinglist[$k]['href'].'">'.$followinglist[$k]['name'].'</a>';
                $lists .= '</span></li>';
            } 
        }
        $data['list'] = $lists;

        die(json_encode($data));
    }  

    /**
     * 网页关注列表更多分页数据
     * 
     * @author lanyanguang
     * @date 2012-04-24
     */
    function getWebFollowingsByPage() {
        //获得页码
        $page = (int) $this->input->post("pager");
        $page = !empty($page) ? $page : 1;
        //某个分类下的关注网页
        $webfollowing = (array) $this->followingmodel->getAttentionWeb($this->action_uid , $this->web_id , $this->_self, 27 * ($page-1), 27, $this->uid);
        $followings_count = isset($webfollowing['ct']) ? $webfollowing['ct'] : 0;
        $followinglist = isset($webfollowing['data']) ? $webfollowing['data'] : array();
        
        //获得网页关注列表
        foreach ($followinglist as $k => $v) {
                $followinglist[$k]['src'] = get_webavatar($followinglist[$k]['web_uid'], 'm', $followinglist[$k]['aid']);
                $followinglist[$k]['href'] = mk_url(APP_URL.'/index/index', array('web_id' => $followinglist[$k]['aid']), false);   
        }
        
        //返回json数组   
        $data = array();
        $data['state'] = '1';
        $data['msg'] = 'success!';
        
        //是否最后一页
        $last = true;
        if ($followings_count - $page * 27 > 0) {
            $last = false;
        }
        $data['last'] = $last;
        
        $lists = '';
        if ($this->_self) {
            foreach ($followinglist as $k => $v) {
                $class  = $followinglist[$k]['is_display'] ? '' : 'invisible';
                $lists  .= '<li><div class="avatarBox '.$class.'">';
                $lists  .= '<a href="'.$followinglist[$k]['href'].'"><img src="'.$followinglist[$k]['src'].'" alt="" /></a>';
                $lists  .= '<s id="'.$followinglist[$k]['aid'].'"></s>';
                $lists  .= '</div>';
                $lists  .= '<span class="uName"><a href="'.$followinglist[$k]['href'].'">'.$followinglist[$k]['name'].'</a>';
                $lists  .= '</span></li>';
            }
        } else {
            foreach ($followinglist as $k => $v) {
                $lists .= '<li><div class="avatarBox">';
                $lists .= '<a href="'.$followinglist[$k]['href'].'"><img src="'.$followinglist[$k]['src'].'" alt="" /></a>';
                $lists .= '</div>';
                $lists .= '<span class="uName"><a href="'.$followinglist[$k]['href'].'">'.$followinglist[$k]['name'].'</a>';
                $lists .= '</span></li>';
            } 
        }
        $data['list'] = $lists;

        die(json_encode($data));
    }  
    
    /**
     * 相互关注列表
     * 
     * @author lanyanguang
     * @date 2012-03-01
     */
    function bothFollowingList() {
        //用户主页信息
        $userinfo = $this->_getCurrentUserInfo();
        
        //获得关注数
        $followings_count = (int) $this->followingmodel->getNumOfBothFollowers($this->action_uid, $this->_self, $this->uid);
        
        //获得关注列表
        $followinglist = array();
        if ($followings_count>0) {
            $followinglist = (array) $this->followingmodel->getBothFollowersWithInfo($this->action_uid, $this->_self, 1, 27, $this->uid);
            foreach ($followinglist as $k => $v) {
                $followinglist[$k]['src'] = get_avatar($followinglist[$k]['id'], 'm');
                $followinglist[$k]['href'] = mk_url(APP_URL.'/index/index', array('action_dkcode' => $followinglist[$k]['dkcode']));    
            }
        }
        
        $this->assign('userinfo', $userinfo);
        $this->assign('is_self', $this->_self);
        $this->assign('followings_count', $followings_count);
        $this->assign('followinglist', $followinglist);
        $this->display('following/bothlist.html');
    }
    
    /**
     * 关注列表更多分页数据
     * 
     * @author lanyanguang
     * @date 2012-03-01
     */
    function getBothFollowingsByPage() {
        //获得页码
        $page = (int) $this->input->post("pager");
        $page = !empty($page) ? $page : 1;
        
        //获得关注数
        $followings_count = (int) $this->followingmodel->getNumOfBothFollowers($this->action_uid, $this->_self, $this->uid);
        
        //获得关注列表
        $followinglist = array();
        if ($followings_count>0) {
            $followinglist = (array) $this->followingmodel->getBothFollowersWithInfo($this->action_uid, $this->_self, $page, 27, $this->uid);
            foreach ($followinglist as $k => $v) {
                $followinglist[$k]['src'] = get_avatar($followinglist[$k]['id'], 'm');
                $followinglist[$k]['href'] = mk_url(APP_URL.'/index/index', array('action_dkcode' => $followinglist[$k]['dkcode']));    
            }
        }
        
        //返回json数组   
        $data = array();
        $data['state'] = '1';
        $data['msg'] = 'success!';
        
        //是否最后一页
        $last = true;
        if ($followings_count - $page * 27 > 0) {
            $last = false;
        }
        $data['last'] = $last;
        
        $lists = '';
        if ($this->_self) {
            foreach ($followinglist as $k => $v) {
                $class  = $followinglist[$k]['hidden'] ? 'invisible' : '';
                $lists  .= '<li><div class="avatarBox '.$class.'">';
                $lists  .= '<a href="'.$followinglist[$k]['href'].'"><img src="'.$followinglist[$k]['src'].'" alt="" /></a>';
                $lists  .= '<s id="'.$followinglist[$k]['id'].'"></s>';
                $lists  .= '</div>';
                $lists  .= '<span class="uName"><a href="'.$followinglist[$k]['href'].'">'.$followinglist[$k]['name'].'</a>';
                $lists  .= '</span></li>';
            }
        } else {
            foreach ($followinglist as $k => $v) {
                $lists .= '<li><div class="avatarBox">';
                $lists .= '<a href="'.$followinglist[$k]['href'].'"><img src="'.$followinglist[$k]['src'].'" alt="" /></a>';
                $lists .= '</div>';
                $lists .= '<span class="uName"><a href="'.$followinglist[$k]['href'].'">'.$followinglist[$k]['name'].'</a>';
                $lists .= '</span></li>';
            } 
        }
        $data['list'] = $lists;

        die(json_encode($data));
    }  

    /**
     * 可能认识的人列表
     * 
     * @author lanyanguang
     * @date 2012-03-31
     */
    function mayKnowList() {
        //检查必须是自己
        if (!$this->_self) {
            $this->redirect(mk_url(APP_URL.'/index/index', array('action_dkcode' => $this->action_dkcode)));
        }
        
        //用户主页信息
        $userinfo = $this->_getCurrentUserInfo();
        
        //获得可能认识的人数
        $followings_count = (int) $this->followingmodel->getMayKnowCount($this->action_uid);
        
        //获得可能认识的人列表
        $followinglist = array();
        if ($followings_count>0) {
            $followinglist = (array) $this->followingmodel->getMayKnow($this->action_uid, 1, 27);
            foreach ($followinglist as $k => $v) {
                $followinglist[$k]['src'] = get_avatar($followinglist[$k]['id'], 'm');
                $followinglist[$k]['href'] = mk_url(APP_URL.'/index/index', array('action_dkcode' => $followinglist[$k]['dkcode']));    
            }
        }
        $this->assign('userinfo', $userinfo);
        $this->assign('followings_count', $followings_count);
        $this->assign('followinglist', $followinglist);
        $this->display('following/mayknowlist.html');
    }
    
    /**
     * 可能认识的网页列表
     * 
     * @author lanyanguang
     * @date 2012-05-10
     */
    function webMayKnowList() {
        //检查必须是自己
        if (!$this->_self) {
            $this->redirect(mk_url(APP_URL.'/index/index', array('action_dkcode' => $this->action_dkcode)));
        }
        
        //用户主页信息
        $userinfo = $this->_getCurrentUserInfo();
        
        //获得可能认识的人数
        $followings_count = (int) $this->followingmodel->getWebMayKnowCount($this->web_id, $this->action_uid);
        
        //获得可能认识的人列表
        $followinglist = array();
        if ($followings_count>0) {
            $followinglist = (array) $this->followingmodel->getWebMayKnow($this->web_id, $this->action_uid, 1, 27);
            foreach ($followinglist as $k => $v) {
                $followinglist[$k]['src'] = get_webavatar($followinglist[$k]['uid'], 'm', $followinglist[$k]['aid']);
                $followinglist[$k]['href'] = mk_url(APP_URL.'/index/index', array('web_id' => $followinglist[$k]['aid']), false);    
            }
        }
        $this->assign('userinfo', $userinfo);
        $this->assign('followings_count', $followings_count);
        $this->assign('followinglist', $followinglist);
        $this->display('following/webmayknowlist.html');
    }
    
    /**
     * 可能认识的人更多分页数据
     * 
     * @author lanyanguang
     * @date 2012-03-31
     */
    function mayKnowByPage() {
        //获得页码
        $page = (int) $this->input->post("pager");
        $page = !empty($page) ? $page : 1;
        
        //获得关注数
        $followings_count = (int) $this->followingmodel->getMayKnowCount($this->action_uid);
        
        //获得关注列表
        $followinglist = array();
        if ($followings_count>0) {
            $followinglist = (array) $this->followingmodel->getMayKnow($this->action_uid, $page, 27);
            foreach ($followinglist as $k => $v) {
                $followinglist[$k]['src'] = get_avatar($followinglist[$k]['id'], 'm');
                $followinglist[$k]['href'] = mk_url(APP_URL.'/index/index', array('action_dkcode' => $followinglist[$k]['dkcode']));    
            }
        }
        
        //返回json数组   
        $data = array();
        $data['state'] = '1';
        $data['msg'] = 'success!';
        
        //是否最后一页
        $last = true;
        if ($followings_count - $page * 27 > 0) {
            $last = false;
        }
        $data['last'] = $last;
        
        $lists = '';
        foreach ($followinglist as $k => $v) {
            $lists  .= '<li><div class="avatarBox">';
            $lists  .= '<a href="'.$followinglist[$k]['href'].'"><img src="'.$followinglist[$k]['src'].'" alt="" /></a>';
            $lists  .= '</div>';
            $lists  .= '<span class="uName"><a href="'.$followinglist[$k]['href'].'">'.$followinglist[$k]['name'].'</a>';
            $lists  .= '</span></li>';
        }

        $data['list'] = $lists;

        die(json_encode($data));
    } 
 
     /**
     * 可能认识的人更多分页数据
     * 
     * @author lanyanguang
     * @date 2012-03-31
     */
    function webMayKnowByPage() {
        //获得页码
        $page = (int) $this->input->post("pager");
        $page = !empty($page) ? $page : 1;
        
        //获得关注数
        $followings_count = (int) $this->followingmodel->getWebMayKnowCount($this->web_id, $this->action_uid);
        
        //获得关注列表
        $followinglist = array();
        if ($followings_count>0) {
            $followinglist = (array) $this->followingmodel->getWebMayKnow($this->web_id, $this->action_uid, $page, 27);
            foreach ($followinglist as $k => $v) {
                $followinglist[$k]['src'] = get_webavatar($followinglist[$k]['uid'], 'm', $followinglist[$k]['aid']);
                $followinglist[$k]['href'] = mk_url(APP_URL.'/index/index', array('web_id' => $followinglist[$k]['aid']), false);     
            }
        }
        
        //返回json数组   
        $data = array();
        $data['state'] = '1';
        $data['msg'] = 'success!';
        
        //是否最后一页
        $last = true;
        if ($followings_count - $page * 27 > 0) {
            $last = false;
        }
        $data['last'] = $last;
        
        $lists = '';
        foreach ($followinglist as $k => $v) {
            $lists  .= '<li><div class="avatarBox">';
            $lists  .= '<a href="'.$followinglist[$k]['href'].'"><img src="'.$followinglist[$k]['src'].'" alt="" /></a>';
            $lists  .= '</div>';
            $lists  .= '<span class="uName"><a href="'.$followinglist[$k]['href'].'">'.$followinglist[$k]['name'].'</a>';
            $lists  .= '</span></li>';
        }

        $data['list'] = $lists;

        die(json_encode($data));
    } 
    
    /**
     * 隐藏 显示关注对象
     * 
     * @author lanyanguang
     * @date 2012-03-01
     */
    function visibleFollowing() {
        //获得关注对象
        $f_uid = (int) $this->input->post('f_uid');
        //获得可见性
        $visible =  $this->input->post('visible');
        $status = $this->followingmodel->isHiddenFollowing($this->uid, $f_uid);
        if ($visible == 'false') {
            if ($status) {
                $result = true;
            } else {   
                $result = $this->followingmodel->hideFollowing($this->uid, $f_uid);
            }
        } else {
            if (!$status) {
                $result = true;
            } else {  
                $result = $this->followingmodel->unHideFollowing($this->uid, $f_uid);
            }
        }
        if ($result) {
            die(json_encode(array('state' => '1', 'msg' => "success!", 'status' => $status)));
        } else {
            die(json_encode(array('state' => '0', 'msg' => 'error!')));
        }
    }

    /**
     * 隐藏 显示关注对象
     * 
     * @author lanyanguang
     * @date 2012-03-01
     */
    function visibleWebFollowing() {
        //获得关注对象
        $f_uid = (int) $this->input->post('f_uid');
        
        //获得可见性
        $visible =  $this->input->post('visible');

        //用户信息
        $info = array(
            'user_id' => $this->uid,
            'web_id' => $f_uid
        );
        
        if ($visible == 'false') {
            $result = $this->followingmodel->hideWebFollowing($this->uid, $f_uid);
            
            //隐藏网页更新索引
            $this->followingmodel->hidingAUserInWebpage($info);
        } else {
            $result = $this->followingmodel->unHideWebFollowing($this->uid, $f_uid);
            
            //隐藏网页更新索引
            $this->followingmodel->unHidingAUserInWebpage($info);
        }

        if ($result) {
            die(json_encode(array('state' => '1', 'msg' => "success!")));
        } else {
            die(json_encode(array('state' => '0', 'msg' => 'error!')));
        }
    }
    
    /**
     * 隐藏关注分类
     * 
     * @author lanyanguang
     * @date 2012-03-01
     */
    function hiddenFollowingCategory() {
        //获得关注分类
        $f_id = (int) $this->input->get('f_id');
        
        $result = $this->followingmodel->hiddenFollowingCategory($this->uid, $f_id);
        if ($result) {
            die(json_encode(array('state' => '1', 'msg' => 'success!')));
        } else {
            die(json_encode(array('state' => '0', 'msg' => 'error!')));
        }
    }
    
    /**
     * 隐藏网页关注分类
     * 
     * @author lanyanguang
     * @date 2012-03-01
     */
    function hiddenWebFollowingCategory() {
        //获得关注分类
        $f_id = (int) $this->input->get('f_id');
        
        $result = $this->followingmodel->hiddenWebFollowingCategory($this->uid, $f_id);
        if ($result) {
            die(json_encode(array('state' => '1', 'msg' => 'success!')));
        } else {
            die(json_encode(array('state' => '0', 'msg' => 'error!')));
        }
    }
    
    /**
     * 显示关注分类
     * 
     * @author lanyanguang
     * @date 2012-03-01
     */
    function unHiddenFollowingCategory() {
        //获得关注分类
        $f_id = (int) $this->input->get('f_id');
        $result = $this->followingmodel->unHiddenFollowingCategory($this->uid, $f_id);
        if ($result) {
            die(json_encode(array('state' => '1', 'msg' => 'success!')));
        } else {
            die(json_encode(array('state' => '0', 'msg' => 'error!')));
        }
    }

    /**
     * 显示网页关注分类
     * 
     * @author lanyanguang
     * @date 2012-03-01
     */
    function unHiddenWebFollowingCategory() {
        //获得关注分类
        $f_id = (int) $this->input->get('f_id');
        $result = $this->followingmodel->unHiddenWebFollowingCategory($this->uid, $f_id);
        if ($result) {
            die(json_encode(array('state' => '1', 'msg' => 'success!')));
        } else {
            die(json_encode(array('state' => '0', 'msg' => 'error!')));
        }
    }    
    
    /**
     * 通过用户名查找关注用户
     * 
     * @author lanyanguang
     * @date 2012-03-01
     */
    function searchFollowingByUserName() {
        //获得搜索关键字
        $keyword = $this->input->post('keyword');
        
        //获得页码
        $page = (int) $this->input->post("pager");
        $page = !empty($page) ? $page : 1;
        
        //返回json数组   
        $data = array();
        $data['state'] = '1';
        $data['msg'] = 'success!';
        $last = true;
        
        if($keyword != '') {
            $followinglist = $this->followingmodel->getFollowingByUserName($this->uid, $keyword, $page, 27);

            $following_object = array();
            if ($followinglist) {     
                $following_object = $followinglist['object'];
                $following_count = $followinglist['total'];

                if($following_count - $page * 27 > 0) {
                    $last = false;
                }

            }

            $data['last'] = $last;

            $lists = '';
            foreach ($following_object as $k => $v) {
                $class  = $following_object[$k]['type'] ? 'invisible' : '';
                $lists .= '<li><div class="avatarBox '.$class.'">';
                $lists .= '<a href="'.$following_object[$k]['href'].'"><img src="'.$following_object[$k]['src'].'" alt="" /></a>';
                $lists .= '<s id="'.$following_object[$k]['id'].'"></s>';
                $lists .= '</div>';
                $lists .= '<span class="uName"><a href="'.$following_object[$k]['href'].'">'.$following_object[$k]['name'].'</a>';
                $lists .= '</span></li>';
            }
            $data['list'] = $lists;
        } else {
            //获得关注数
            $followings_count = (int) $this->followingmodel->getNumOfFollowings($this->action_uid, $this->_self, $this->uid);

            //获得关注列表
            $followinglist = array();
            if ($followings_count>0) {
                $followinglist = (array) $this->followingmodel->getFollowingsWithInfo($this->action_uid, $this->_self, $page, 27, $this->uid);
                foreach ($followinglist as $k => $v) {
                    $followinglist[$k]['src'] = get_avatar($followinglist[$k]['id'], 'm');
                    $followinglist[$k]['href'] = mk_url(APP_URL.'/index/index', array('action_dkcode' => $followinglist[$k]['dkcode']));    
                }
            }
            
             //是否最后一页
            if ($followings_count - $page * 27 > 0) {
                $last = false;
            }
            $data['last'] = $last;

            $lists = '';
            
            foreach ($followinglist as $k => $v) {
                $class  = $followinglist[$k]['hidden'] ? 'invisible' : '';
                $lists  .= '<li><div class="avatarBox '.$class.'">';
                $lists  .= '<a href="'.$followinglist[$k]['href'].'"><img src="'.$followinglist[$k]['src'].'" alt="" /></a>';
                $lists  .= '<s id="'.$followinglist[$k]['id'].'"></s>';
                $lists  .= '</div>';
                $lists  .= '<span class="uName"><a href="'.$followinglist[$k]['href'].'">'.$followinglist[$k]['name'].'</a>';
                $lists  .= '</span></li>';
            }
            $data['list'] = $lists;
        }
            
        die(json_encode($data));
    }

    /**
     * 通过用户名查找关注用户
     * 
     * @author lanyanguang
     * @date 2012-03-01
     */
    function searchBothFollowingByUserName() {
        //获得搜索关键字
        $keyword = $this->input->post('keyword');
        
        //获得页码
        $page = (int) $this->input->post("pager");
        $page = !empty($page) ? $page : 1;
        
        //返回json数组   
        $data = array();
        $data['state'] = '1';
        $data['msg'] = 'success!';
        $last = true;
        if($keyword != '') {
            $followinglist = $this->followingmodel->getBothFollowingByUserName($this->uid, $keyword, $page, 27);

            $following_object = array();
            if ($followinglist) {     
                $following_object = $followinglist['object'];
                $following_count = $followinglist['total'];

                if($following_count - $page * 27 > 0) {
                    $last = false;
                }

            }

            $data['last'] = $last;

            $lists = '';
            foreach ($following_object as $k => $v) {
                $class  = $following_object[$k]['type'] ? 'invisible' : '';
                $lists .= '<li><div class="avatarBox '.$class.'">';
                $lists .= '<a href="'.$following_object[$k]['href'].'"><img src="'.$following_object[$k]['src'].'" alt="" /></a>';
                $lists .= '<s id="'.$following_object[$k]['id'].'"></s>';
                $lists .= '</div>';
                $lists .= '<span class="uName"><a href="'.$following_object[$k]['href'].'">'.$following_object[$k]['name'].'</a>';
                $lists .= '</span></li>';
            }
            $data['list'] = $lists;
        } else {
            //获得关注数
            $followings_count = (int) $this->followingmodel->getNumOfBothFollowers($this->action_uid, $this->_self, $this->uid);

            //获得关注列表
            $followinglist = array();
            if ($followings_count>0) {
                $followinglist = (array) $this->followingmodel->getBothFollowersWithInfo($this->action_uid, $this->_self, $page, 27, $this->uid);
                foreach ($followinglist as $k => $v) {
                    $followinglist[$k]['src'] = get_avatar($followinglist[$k]['id'], 'm');
                    $followinglist[$k]['href'] = mk_url(APP_URL.'/index/index', array('action_dkcode' => $followinglist[$k]['dkcode']));    
                }
            }
            
            if ($followings_count - $page * 27 > 0) {
                $last = false;
            }
            $data['last'] = $last;

            $lists = '';
            
             foreach ($followinglist as $k => $v) {
                $class  = $followinglist[$k]['hidden'] ? 'invisible' : '';
                $lists  .= '<li><div class="avatarBox '.$class.'">';
                $lists  .= '<a href="'.$followinglist[$k]['href'].'"><img src="'.$followinglist[$k]['src'].'" alt="" /></a>';
                $lists  .= '<s id="'.$followinglist[$k]['id'].'"></s>';
                $lists  .= '</div>';
                $lists  .= '<span class="uName"><a href="'.$followinglist[$k]['href'].'">'.$followinglist[$k]['name'].'</a>';
                $lists  .= '</span></li>';
            }
            
            $data['list'] = $lists;
        }
        die(json_encode($data));
    }
    
     /**
     * 通过用户名查找关注用户
     * 
     * @author lanyanguang
     * @date 2012-03-01
     */
    function searchWebFollowingByUserName() {
        //获得搜索关键字
        $keyword = $this->input->post('keyword');
        
        //获得页码
        $page = (int) $this->input->post("pager");
        $page = !empty($page) ? $page : 1;
        
        //返回json数组   
        $data = array();
        $data['state'] = '1';
        $data['msg'] = 'success!';
        $last = true;
        
        if($keyword != '') {
            $followinglist = $this->followingmodel->getWebpagesByUser($this->uid, $this->web_id, $keyword, $page, 27);

            $following_object = array();
            if ($followinglist) {     
                $following_object = $followinglist['object'];
                $following_count = $followinglist['total'];

                if($following_count - $page * 27 > 0) {
                    $last = false;
                }

            }

            $data['last'] = $last;

            $lists = '';
            foreach ($following_object as $k => $v) {
                $class  = $following_object[$k]['type'] ? 'invisible' : '';
                $lists .= '<li><div class="avatarBox '.$class.'">';
                $lists .= '<a href="'.$following_object[$k]['href'].'"><img src="'.$following_object[$k]['src'].'" alt="" /></a>';
                $lists .= '<s id="'.$following_object[$k]['id'].'"></s>';
                $lists .= '</div>';
                $lists .= '<span class="uName"><a href="'.$following_object[$k]['href'].'">'.$following_object[$k]['name'].'</a>';
                $lists .= '</span></li>';
            }
            $data['list'] = $lists;
        } else {
            //某个分类下的关注网页
            $webfollowing = (array) $this->followingmodel->getAttentionWeb($this->action_uid , $this->web_id , $this->_self, 27 * ($page-1), 27, $this->uid);
            $followings_count = isset($webfollowing['ct']) ? $webfollowing['ct'] : 0;
            $followinglist = isset($webfollowing['data']) ? $webfollowing['data'] : array();

            //获得网页关注列表
            foreach ($followinglist as $k => $v) {
                    $followinglist[$k]['src'] = get_webavatar($followinglist[$k]['web_uid'], 'm', $followinglist[$k]['aid']);
                    $followinglist[$k]['href'] = mk_url(APP_URL.'/index/index', array('web_id' => $followinglist[$k]['aid']), false);   
            }
            
            if ($followings_count - $page * 27 > 0) {
                $last = false;
            }
                $data['last'] = $last;

            $lists = '';
            foreach ($followinglist as $k => $v) {
                $class  = $followinglist[$k]['is_display'] ? '' : 'invisible';
                $lists  .= '<li><div class="avatarBox '.$class.'">';
                $lists  .= '<a href="'.$followinglist[$k]['href'].'"><img src="'.$followinglist[$k]['src'].'" alt="" /></a>';
                $lists  .= '<s id="'.$followinglist[$k]['aid'].'"></s>';
                $lists  .= '</div>';
                $lists  .= '<span class="uName"><a href="'.$followinglist[$k]['href'].'">'.$followinglist[$k]['name'].'</a>';
                $lists  .= '</span></li>';
            }
            $data['list'] = $lists;
        }
        die(json_encode($data));
    }
    
}
/* End of file following.php */
/* Location: ./application/controllers/following.php */