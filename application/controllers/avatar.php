<?php

/**
 * 头像封面
 * @author lvxinxin
 * @date <2012/03/23>
 *
 */
class Avatar extends MY_Controller
{
	private $fdfs;	
	private $mduid;
    public function __construct()
    {
        parent::__construct();		
		$this->load->library('Redisdb');		
		$this->mduid = md5($this->uid);
    }

    function index()
    {
        $this->set_avatar();
    }
	
	
    function set_avatar()
    {
        $data = $this->getLoginInfo();
		//var_dump($data);
        if(empty($this->user)){
        	echo '<script type="text/javascript">alert("登陆超时，请重新登陆！");</script>';
        	exit;
        }
        $camera = $this->input->get('camera');       
        $path = $this->input->get('p');
        $pid = $this->input->get('pid');
		//echo get_webavatar($data['uid'],'s','9527');
        $this->assign('username', $this->user['username']);
        $this->assign('avatar50', get_avatar($this->uid));
        $this->assign('avatar_upload', mk_url('main/avatar/avatar_upload'));
        $this->assign('url',mk_url('main/avatar/set_avatar'));
        $this->display('timeline/upload_protrait.html');
        if (! empty($camera))
        {
            echo '<script type="text/javascript">$(function(){useCamera();})</script>';
        }
        if (! empty($path))
        {
            $upPath = str_replace("\\", "/", '../files/image/avatar/');
            $avatar = $upPath . $this->mduid . '.jpg';
            if (file_exists($avatar))
            {
                @unlink($avatar);
            }
            $a = @file_put_contents($avatar, @file_get_contents($path));
            if ($a > 0)
            {
                $web_path = WEB_ROOT . 'files/image/avatar/'  . $this->mduid . '.jpg';
                $api_path = WEB_ROOT ."single/album/index.php?c=api&m=uploadHead&filePath=";
                $code = urlencode($web_path);
                $flag = file_get_contents($api_path . $code . '&flashUploadUid=' . $this->uid . '&pid='.$pid.'&v=' . time());
               // echo $flag.'------';echo $api_path . $code . '&flashUploadUid=' . sysAuthCode($data['uid']) . '&v=' . time();exit;
                if ($flag != 's')
                {
                    //echo '<script type="text/javascript">alert("保存至头像相册失败！");</script>';
                }
            	$log = array(
					'flag'=>$flag,
					'web_path'=>$web_path,
					'api_path'=>$api_path . $code . '&flashUploadUid=' . $this->uid . '&pid='.$pid.'&v=' . time(),
				);
				log_user_msg($this->uid,$log);				
				list ($width, $height) = @getimagesize($avatar);				
				if($width > 2800 || $height >2800){
					$s = $this->pro_avatar($avatar, $this->uid, $width, $height);
					if(!$s){					
						echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
						echo '<script type="text/javascript">alert("' . $this->myupload->display_errors('','') . '");</script>';
            			exit;
					}
					
				}			
			    /*if(!$this->fdfs->file_exist(config_item('fastdfs_group'),$this->_getMasterFile())){
					$ext = pathinfo($avatar,PATHINFO_EXTENSION);
					$Mfdata = $this->fdfs->uploadFile(realpath($avatar),$ext);
					//echo $Mfdata['filename'];
					$this->redisdb->set('avatar:'.$this->uid,$Mfdata['filename']);				
				}*/            
                echo '<script type="text/javascript">$(function(){$(".uploadHeader").hide();});</script>';
                echo '<script type="text/javascript">window.parent.hideLoading();window.parent.buildAvatarEditor("' . md5($data['uid']) . '","' . $web_path . '?v=' . time() .
                 '","photo");</script>';
            }
            else
            {
                echo '<script type="text/javascript">alert("保存图片失败");</script>';
                exit();
            }             
        }
    }

    /**
     * 通过本地上传方式更新头像
     *
     * 操作相册、头像
     * @author lvxinxin
     * @date   2012-04-25
     * @access public
     * @last-modify: 2011-12-09 liuGC
     * @return JS
     */
    public function setProfilePic()
    {         
        if (! $this->uid)
        {
            echo '<script type="text/javascript">alert("session失效!");</script>';
            exit();
        }
        $this->load->library('file_util');
        $from = $this->input->post('from');
        $pic = $this->input->post('pic');
        $pid = $this->input->post('pid');
        $callback = $this->input->post('callback');
        if (! empty($from) && ! empty($pic))
        {
            $upPath = str_replace("\\", "/", '../files/image/avatar/' );
            $avatar = $upPath . $this->mduid . '_f.jpg';
        	if (! is_dir($upPath))
        	{
            	$this->file_util->createDir($upPath);
       		}
            if (file_exists($avatar))
            {
                @unlink($avatar);
            }
            $a = @file_put_contents($avatar, @file_get_contents($pic));
            if ($a > 0)
            {
				/*if(!$this->fdfs->file_exist(config_item('fastdfs_group'),$this->_getMasterFile())){
					$ext = pathinfo($avatar,PATHINFO_EXTENSION);
					$Mfdata = $this->fdfs->uploadFile(realpath($avatar),$ext);
					//echo $Mfdata['filename'];
					$this->redisdb->set('avatar:'.$this->uid,$Mfdata['filename']);				
				}*/
                $this->proPic($avatar,'',false,$pid);
            }
            else
            {
                echo '<script type="text/javascript">alert("相册图片生成失败");</script>';
                exit();
            }
        }
        $upload_config['upload_path'] = str_replace("\\", "/", '../files/image/avatar/'); //上传路径
        $upload_config['allowed_types'] = 'jpg|jpeg|gif|png'; //文件上传类型
        $upload_config['overwrite'] = true; //同名文件覆盖
        $upload_config['file_name'] = $this->mduid . '_f.jpg'; //指定文件名
        $upload_config['max_size'] = 4096;
        $this->load->library('MyUpload', $upload_config);
        @header("Expires: 0");
        @header("Cache-Control: private, post-check=0, pre-check=0, max-age=0", FALSE);
        @header("Pragma: no-cache"); 
        
        if (! is_dir($upload_config['upload_path']))
        {
            $this->file_util->createDir($upload_config['upload_path']);
        }
        if ($this->myupload->do_upload('FileData'))
        {
			$img_info = $this->myupload->data();
            $filePath = $upload_config['upload_path'] . $this->mduid . '_f.jpg';
			
            $this->proPic($filePath,$callback);
        }
        else
        {
			//$this->display('cover_img_upload.html');
			
            echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
            die("<script>parent.". $callback ."({'status':0,'data':'novia','msg':'" . $this->myupload->display_errors('', '') . "'});</script>");
			
		}
         
    }
	
    /**
     * 设置封面
     */
    public function set_cover()
    {
		//$this->load->library('xhprof');
    	//$this->xhprof->open();
        //$uid = $this->getLoginUID();
		$this->load->library('Storage');
		$this->fdfs = $this->storage->getInstance();
        $height = abs($this->input->post('top'));       
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = '../files/image/avatar/' . $this->mduid . '_thumb.jpg';
        $config['new_image'] = $this->mduid . '_cover.jpg';
        $config['y_axis'] = $height;
        $config['height'] = 315;
        
        $this->image_lib->initialize($config);
        if (! $this->image_lib->crop())
        {
            die(json_encode(array('status' => 0, 'msg' => $this->image_lib->display_errors('', ''))));             
        }
        else
        {
			$fpath = realpath( '../files/image/avatar/'  . $this->mduid  .'_cover.jpg');
			if($fpath != false){
				if(!$this->fdfs->file_exist(config_item('fastdfs_group'),$this->_getMasterFile())){
					//$ext = ltrim($img_info['file_ext'],'.');
					$Mfdata = $this->fdfs->uploadFile($fpath,'jpg');
					//echo $Mfdata['filename'];
					$this->redisdb->set('avatar:'.$this->uid,$Mfdata['filename']);				
				}
			}
			
			$this->_delFile('_cover.jpg');
			$data = $this->_saveFile('../files/image/avatar/'.$this->mduid . '_cover.jpg','_cover');
			if(is_array($data)){
				$fpath = 'http://' . config_item('fastdfs_host') . '/' . config_item('fastdfs_group') . '/' . $data['filename'].'?v='.time();
				set_cache('cover'.$this->uid,$fpath);
			}			
            die(json_encode(array('status' => 1,'data'=>$height)));
        }
    }

    /**
     *上传头像
     */
    public function avatar_upload()
    {      
        
        if (! $this->uid)
        {
            echo '<script type="text/javascript">alert("session失效!");</script>';
            exit();
        }
        
        $upload_config['upload_path'] = str_replace("\\", "/", '../files/image/avatar/' ); //上传路径
        $upload_config['allowed_types'] = 'jpg|jpeg|gif|png|pjpeg|x-png'; //文件上传类型
        $upload_config['overwrite'] = true; //同名文件覆盖
        $upload_config['file_name'] = $this->mduid.'.jpg'; //指定文件名
        $upload_config['max_size'] = 4096;
        $this->load->library('file_util');
        if (! is_dir($upload_config['upload_path']))
        {
            $this->file_util->createDir($upload_config['upload_path']);
        }
        $this->load->library('MyUpload', $upload_config);
        @header("Expires: 0");
        @header("Cache-Control: private, post-check=0, pre-check=0, max-age=0", FALSE);
        @header("Pragma: no-cache");
        if ($this->myupload->do_upload('Filedata'))
        {
        	$img_info = $this->myupload->data();					
			if($img_info['image_width'] > 2800 || $img_info['image_height'] > 2800){				
				$s = $this->pro_avatar($upload_config['upload_path'].md5($this->uid).'.jpg', $this->uid, $img_info['image_width'], $img_info['image_height']);
				if(!$s){					
					echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
					echo '<script type="text/javascript">alert("' . $this->myupload->display_errors('','') . '");</script>';
            		exit;
				}				
			}
            $web_path = WEB_ROOT . 'files/image/avatar/' . $this->mduid . '.jpg?v=' . time();
            $api_path = WEB_ROOT ."single/album/index.php?c=api&m=uploadHead&filePath=";
            $code = urlencode($web_path);
            $flag = file_get_contents($api_path . $code . '&flashUploadUid=' . $this->uid . '&v=' . time());
            //var_dump($_FILES);exit;
            //echo $flag.'--------';
            //echo $api_path.$code.'&flashUploadUid='.sysAuthCode($uid).'&v='.time();
            //exit; 
			
			$log = array(
				'flag'=>$flag,
				'web_path'=>$web_path,
				'api_path'=>$api_path . $code . '&flashUploadUid=' . $this->uid . '&v=' . time(),
			);
			log_user_msg($this->uid,$log);
            if ($flag != 's')
            {
                //echo '<script type="text/javascript">alert("保存至头像相册失败！");</script>';
            }
			/*if(!$this->fdfs->file_exist(config_item('fastdfs_group'),$this->_getMasterFile())){
				$ext = ltrim($img_info['file_ext'],'.');
				$Mfdata = $this->fdfs->uploadFile($img_info['full_path'],$ext);
				//echo $Mfdata['filename'];
				$this->redisdb->set('avatar:'.$this->uid,$Mfdata['filename']);				
			}*/
			
            echo '<script type="text/javascript">window.parent.hideLoading();window.parent.buildAvatarEditor("' . $this->mduid . '","' . $web_path .
         	'","photo");</script>';        
        	exit();
        }
        else
        {        	
            echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';            
            echo '<script type="text/javascript">alert("' . $this->myupload->display_errors('',''). '");parent.hideLoading();</script>';
            exit;
        }       
        
    }

    /**
     *保存头像
     */
    public function avatar_save()
    {        
        $uid = $this->getLoginUID();
		$this->load->library('Storage');
		$this->fdfs = $this->storage->getInstance();
        if (! $uid)
        {
            exit('<script type="text/javascript">alert("登录已过期\r\n请重新登录");window.parent.location.href = "' . WEB_ROOT . 'front/index.php" </script>');
        }
        define('SD_ROOT', dirname(__FILE__) . '/');
        @header("Expires: 0");
        @header("Cache-Control: private, post-check=0, pre-check=0, max-age=0", FALSE);
        @header("Pragma: no-cache");
        $this->load->library('file_util');        
        $type = isset($_GET['type']) ? trim($_GET['type']) : 'big';
        if ($type == 'big')
        {
            $type = 'b';            
        }        
        $pic_id = trim($_GET['photoId']);
        //$pic_id = isset($_GET['photoId']) ? trim($_GET['photoId']) : md5($uid);
        //生成图片存放路径
        $pic_path = WEB_ROOT . 'files/image/avatar/' . $pic_id . "_" . $type . ".jpg";        
        $file_addr = str_replace(WEB_ROOT, str_replace('main', '', FCPATH), $pic_path);
        $file_addr = substr($file_addr, 0, strrpos($file_addr, '/'));
        if (! file_exists($file_addr))
        {
            $this->file_util->createDir($file_addr);
        }        
        $pic_abs_path = $file_addr . substr($pic_path, strrpos($pic_path, '/'));        
        $len = file_put_contents($pic_abs_path, file_get_contents("php://input"));        
        $avtar_img = imagecreatefromjpeg($pic_abs_path);
        imagejpeg($avtar_img, $pic_abs_path, 100);
        
           
		
		$fpath = realpath($pic_abs_path);
		if($fpath != false){
			if(!$this->fdfs->file_exist(config_item('fastdfs_group'),$this->_getMasterFile())){
				//$ext = ltrim($img_info['file_ext'],'.');
				$Mfdata = $this->fdfs->uploadFile($fpath,'jpg');
				//echo $Mfdata['filename'];
				$this->redisdb->set('avatar:'.$this->uid,$Mfdata['filename']);				
			}
		}	
		
		$this->create_avatar($pic_id, $file_addr, $avtar_img); 

		$this->_delete_local_avatar();
		$this->redisdb->set('avatar:is_default'.$this->uid,3);
        $d = new pic_data();
        $d->data->urls[0] = $pic_path;
        $d->status = 1;
        $d->statusText = '上传成功!';
        die(json_encode($d));
    }

    /**
     *生成缩略图！
     */
    public function create_avatar($uid, $file_addr, $res)
    {
        if (empty($uid))
        {
            return false;
        }
        $s30_res = imagecreatetruecolor(30, 30);
        $s50_res = imagecreatetruecolor(50, 50);
        $s100_res = imagecreatetruecolor(100, 100);
        imagecopyresampled($s30_res, $res, 0, 0, 0, 0, 30, 30, 125, 125);
        imagecopyresampled($s50_res, $res, 0, 0, 0, 0, 50, 50, 125, 125);
        imagejpeg($s30_res, $file_addr . '/' . $uid . '_ss.jpg', 100);
        imagejpeg($s50_res, $file_addr . '/' . $uid . '_s.jpg', 100);        
        
        imagecopyresampled($s100_res, $res, 0, 0, 0, 0, 100, 100, 125, 125);        
        imagejpeg($s100_res, $file_addr . '/' . $uid . '_m.jpg', 100);        
        imagedestroy($s30_res);
        imagedestroy($s50_res);
        imagedestroy($s100_res);        
        imagedestroy($res);        
    }
	public function _delete_local_avatar(){
		if (! $this->uid)
        {
            echo '<script type="text/javascript">alert("session失效!");</script>';
            exit();
        }
        $avatar_pic = str_replace("\\", "/", '../files/image/avatar/');
        $avatar_ss = $avatar_pic . $this->mduid . '_ss.jpg';
        $avatar_s = $avatar_pic . $this->mduid . '_s.jpg';
        $avatar_m = $avatar_pic . $this->mduid . '_m.jpg';
        $avatar_b = $avatar_pic . $this->mduid . '_b.jpg';
		$avatar = $avatar_pic .  $this->mduid . '.jpg';
        if (file_exists($avatar_ss))
        {
			$this->_delFile('_ss.jpg');
			$data = $this->_saveFile($avatar_ss,'_ss');			
            @unlink($avatar_ss);
        }
		else{
			$this->_saveFile($avatar_ss,'_ss');
            @unlink($avatar_ss);
		}
        if (file_exists($avatar_s))
        {
			$this->_delFile('_s.jpg');
			$this->_saveFile($avatar_s,'_s');
            @unlink($avatar_s);
        }
		else{
			$this->_saveFile($avatar_s,'_s');
            @unlink($avatar_s);
		}
        if (file_exists($avatar_m))
        {
			$this->_delFile('_m.jpg');
			$this->_saveFile($avatar_m,'_m');
            @unlink($avatar_m);
        }
		else{
			$this->_saveFile($avatar_m,'_m');
            @unlink($avatar_m);
		}
        if (file_exists($avatar_b))
        {
			$this->_delFile('_b.jpg');
			$this->_saveFile($avatar_b,'_b');
            @unlink($avatar_b);
        }
		else{
			$this->_saveFile($avatar_b,'_b');
            @unlink($avatar_b);
		}
		if (file_exists($avatar))
        {
            @unlink($avatar);
        }
	}
    /**
     * 删除头像
     */
    public function delete_avatar()
    {        
        if (! $this->uid)
        {
            echo '<script type="text/javascript">alert("session失效!");</script>';
            exit();
        }
		$this->_delFile('_ss.jpg');
		$this->_delFile('_s.jpg');
		$this->_delFile('_m.jpg');
        $this->_delFile('_b.jpg');
		//$default_avatar_path = str_replace("\\", "/", '../../frontendcore/misc/img/default/');
		//$avatar_ss = $default_avatar_path .  'avatar_ss.gif';
        //$avatar_s = $default_avatar_path .  'avatar_s.gif';
        //$avatar_m = $default_avatar_path .  'avatar_m.gif';
       // $avatar_b = $default_avatar_path .  'avatar_b.gif';
		
		//$this->_saveFile($avatar_ss,'_ss');
		//$this->_saveFile($avatar_s,'_s');
		//$this->_saveFile($avatar_m,'_m');
		//$this->_saveFile($avatar_b,'_b');
		$this->redisdb->set('avatar:is_default'.$this->uid,2);
        exit(json_encode(array('status' => 1,'data'=>MISC_ROOT.'img/default/avatar_b.gif')));
    }

    /**
     * 删除封面
     */
    public function delete_cover()
    {
    	$avatar_pic = str_replace("\\", "/", '../files/image/avatar/');
		$avatar_f = $avatar_pic . $this->mduid . '_f.jpg';
        $avatar_thumb = $avatar_pic . $this->mduid . '_thumb.jpg';
        $avatar_cover = $avatar_pic . $this->mduid . '_cover.jpg';
		@unlink($avatar_f);@unlink($avatar_thumb);@unlink($avatar_thumb);
        $this->_delFile('_cover.jpg');
		set_cache('cover'.$this->uid,null);
        exit(json_encode(array('status' => 1)));
    }
	
    /**
     * 保存图片至相册
     */
    public function save_album($pid = '',$avatar  = false){
    	$uid = $this->getLoginUID();
    	if($avatar){
    		$web_path = WEB_ROOT . 'files/image/avatar/' . $this->mduid . '_b.jpg?v=' . time();
    		$api_path = WEB_ROOT ."single/album/index.php?c=api&m=uploadHead&filePath=";
    	}
    	else{
    		$web_path = WEB_ROOT . 'files/image/avatar/' . $this->mduid . '_f.jpg?v=' . time();
    		$api_path = WEB_ROOT ."single/album/index.php?c=api&m=uploadWithMap&filePath=";
    	}
    	
        
        $code = urlencode($web_path);
        $flag = file_get_contents($api_path . $code . '&flashUploadUid=' . $uid . '&pid='.$pid.'&v=' . time());
        
        //echo $flag."\n";
        //echo $web_path."\n";
        //echo $api_path . $code . '&flashUploadUid=' . sysAuthCode($uid) . '&pid='.$pid.'&v=' . time();
        //exit;
		$log = array(
				'flag'=>$flag,
				'web_path'=>$web_path,
				'api_path'=>$api_path . $code . '&flashUploadUid=' . $uid . '&pid='.$pid.'&v=' . time(),
		);
        log_user_msg($uid,$log);
        if ($flag == 's')
        {
           	return true;
        }
		return false;

    }
    
    /**
     * 图片处理
     */
    public function proPic($filePath,$callback = 'updataCover',$isPost = true,$pid = null)
    {
        $web_path = WEB_ROOT . 'files/image/avatar/'  . $this->mduid . '_thumb.jpg?v=' . time();
        $cover_path = getCover($this->uid);
        $path = array($web_path,$cover_path);
        if (empty($filePath))
        {
            return false;
        }
        list ($width, $height) = getimagesize($filePath);
        if($width < 851 || $height < 301){
        	if($isPost){
        		echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';        		
        		die("<script>parent.". $callback ."({'status':0,'data':'novia','msg':'上传失败！上传的格式不正确，上传的照片宽度最小为851px，高度最小为315px 。图片最大尺寸为4M，端口网支持：jpg,jpeg,gif,png格式图片'});</script>"); 
        		
        	}
        	else{
        		 die(json_encode(array('status'=>0,'data'=>'novia','msg'=>'上传失败！上传的格式不正确，上传的照片宽度最小为851px，高度最小为315px 。图片最大尺寸为4M，端口网支持：jpg,jpeg,gif,png格式图片')));       		
        	}       	
        }
        else{        	
			$nw = 851;
			$nh = intval(($nw/$width)*$height);			
			$config = array(
					'image_library'=>'GD2',
					'source_image'=>$filePath,
					'width'=>$nw,
					'height'=>$nh,
					'new_image'=>$this->mduid . '_thumb.jpg'		
			);
			$this->load->library('image_lib'); 
			$this->image_lib->initialize($config); 		
			if ( ! $this->image_lib->resize())
			{
    			echo  $this->image_lib->display_errors('','');
    			exit;
			}
			else{
				if ($isPost)
            	{
            		$this->save_album();//暂时不做判断
                	$json = json_encode(array('status' => 1,'data'=>$path,'msg' => 'success')); 					
                	die("<script>parent.". $callback ."(" . $json . ");</script>");
            	}
            	else
            	{
            		$this->save_album($pid);//暂时不做判断
                	die(json_encode(array('status' => 1,'data'=>$path,'msg' => 'success')));
            	}
			}
        	        	
        }        
    }

    /**
     *保存摄像头
     */
    public function avatar_camera_save()
    {
        if (! $this->uid)
        {
            exit('<script type="text/javascript">alert("登录已过期\r\n请重新登录");window.parent.location.href = "' . WEB_ROOT . 'front/index.php" </script>');
        }
        define('SD_ROOT', dirname(__FILE__) . '/');
        @header("Expires: 0");
        @header("Cache-Control: private, post-check=0, pre-check=0, max-age=0", FALSE);
        @header("Pragma: no-cache");
        $this->load->library('file_util');
           
        $pic_path = WEB_ROOT . 'files/image/avatar/' . $this->mduid . "_b.jpg";
        //echo $pic_path;exit;
        $file_addr = str_replace(WEB_ROOT, str_replace('main', '', FCPATH), $pic_path);
        $file_addr = substr($file_addr, 0, strrpos($file_addr, '/'));
        if (! file_exists($file_addr))
        {
            $this->file_util->createDir($file_addr);
        }
        $pic_abs_path = $file_addr . substr($pic_path, strrpos($pic_path, '/'));        
        $len = file_put_contents($pic_abs_path, file_get_contents("php://input"));
        
        $avtar_img = imagecreatefromjpeg($pic_abs_path);
		
        imagejpeg($avtar_img, $pic_abs_path, 100); 
		/*if(!$this->fdfs->file_exist(config_item('fastdfs_group'),$this->_getMasterFile())){
			$ext = pathinfo($pic_abs_path,PATHINFO_EXTENSION);
			$Mfdata = $this->fdfs->uploadFile(realpath($pic_abs_path),$ext);
			//echo $Mfdata['filename'];
			$this->redisdb->set('avatar:'.$this->uid,$Mfdata['filename']);				
		}*/
        //$this->create_avatar($this->mduid, $file_addr, $avtar_img);  
        $this->save_album('',true);      
        $d = new pic_data();
        $d->data->urls[0] = $pic_path;
        $d->status = 1;
        $d->statusText = '上传成功!';
        die(json_encode($d));
    }
    
	/**
	 * 处理头像上传图片的最大高度和宽度  默认是w:2800 || h:2800
	 * @author lvxinxin
	 * @date 2012-04-19
	 */
	function pro_avatar($avatar_path,$uid,$w,$h){
		//ini_set('memory_limit', '100M');
		if(empty($uid)){
			return false;
		}
		$wavg = sprintf('%.2f',2800/$w);
		$havg = sprintf('%.2f',2800/$h);
		if($wavg < $havg){
			$navg = $wavg;
		}
		else {
			$navg = $havg;
		}
		$nw = intval($w * $navg);
		$nh = intval($h * $navg);		
		$config = array(
					'image_library'=>'GD2',
					'source_image'=>$avatar_path,
					'width'=>$nw,
					'height'=>$nh		
		);
		$this->load->library('image_lib'); 
		$this->image_lib->initialize($config); 		
		if ( ! $this->image_lib->resize())
		{
    		echo  $this->image_lib->display_errors('','');
		}
		else{
			return true;
		}
	}
	
	public function _getMasterFile(){
		return $this->redisdb->get('avatar:'.$this->uid);
	}
	
	public function _saveFile($file,$size){		
		$this->load->library('Storage');
		$this->fdfs = $this->storage->getInstance();
		if(empty($file) || empty($size)) return false;
		$fpath = realpath($file);		
		return $this->fdfs->uploadSlaveFile($fpath,$this->_getMasterFile(),$size,'jpg');
		
		
	}
	
	public function _delFile($size){
		$this->load->library('Storage');
		$this->fdfs = $this->storage->getInstance();
		$fname = rtrim($this->redisdb->get('avatar:'.$this->uid),'.jpg').$size;
		return $this->fdfs->deleteFile(config_item('fastdfs_group'),$fname);		
	}
	
	public function test(){
		echo get_cache('avatar'.$this->uid.'_s');
		echo 'avatar'.$this->uid.'_s.jpg'."<br />";
		echo get_cache('avatar'.$this->uid.'_ss');
		echo 'avatar'.$this->uid.'_ss.jpg'."<br />";
		echo get_cache('avatar'.$this->uid.'_m');
		echo 'avatar'.$this->uid.'_m.jpg'."<br />";
		echo get_cache('avatar'.$this->uid.'_b');
		echo 'avatar'.$this->uid.'_b.jpg'."<br />";
		echo get_cache('avatar'.$this->uid.'_cover');
		echo "<br />";
	}
}

/**
 * 仅供头像上传的类
 *
 * @author
 * @date
 * @version 1.0
 * @description 头像上传相关数据
 * @history <author><time><version><desc>
 */
class pic_data
{
    public $data;
    public $status;
    public $statusText;

    public function __construct()
    {
        $this->data->urls = array();
    }
}
?>