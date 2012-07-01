<?php
/**
 * 评论与赞控制器
 * 
 * @author boolee 2012 3 1
 */
class Booleetest extends MY_Controller
{
	public function one(){
		$info	=call_soap('timeline', 'Timeline', 'getTopicByMap', array( 'fid'=>'638743','album' ));
		dump($info);
	}
		public function __construct()
    {
        parent::__construct();
    }
	
}
?>
