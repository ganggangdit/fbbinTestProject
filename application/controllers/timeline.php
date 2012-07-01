<?php

/**
 * 获取首页时间线，信息流数据
 * 
 * @author 应晓斌
 *
 */
class Timeline extends MY_Controller {
	
	/**
	 * 获取某个用户的时间线数据
	 */
	public function getTimelineYears()
	{
		if ($this->isAjax()) {
			$uid = $_POST['uid'];
			$viewerId = $this->uid;
			
			if (empty($uid) || empty($viewerId)) {
				echo json_encode(array('status' => 0, 'msg' => '传递参数不正确'));
				exit();
			}
			
			$this->load->model('TimelineModel');
			$data = $this->TimelineModel->getTimelineYears($uid, $viewerId);
			echo json_encode(array('status' => 1, 'data' => $data));
			exit();
		}
	}
	
	/**
	 * 获取年度热点
	 * 
	 * @param int $uid  被访问的用户ID
	 */
	public function getYearHottestFeeds()
	{	
		if ($this->isAjax()) {
			$uid = $_POST['uid'];
			$year = $_POST['year'];
			$viewerId = $this->uid;
			$birthday = isset($_POST['birthday']) ? $_POST['birthday'] : '-inf';
			
			if (empty($uid) || empty($year) || empty($viewerId)) {
				echo json_encode(array('status' => 0, 'msg' => '传递参数不正确'));
				exit();
			}
			
			$this->load->model('TimelineModel');
			
			echo json_encode($this->TimelineModel->getYearHottestFeeds($uid, $year, $viewerId, $birthday));
			exit();
		}
	}
	
	/**
	 * 获取时间轴上的用户数据
	 * 
	 * @param int $uid  被访问的用户ID
	 */
	//public function getFragmentFeeds($uid, $year, $month, $startScore, $lastTopicId, $page)
	public function getFragmentFeeds()
	{
		if ($this->isAjax()) {
			$uid = (int)$_POST['uid'];
			$year = (int)$_POST['year'];
			$month = (int)$_POST['month'];
			$startScore = isset($_POST['startScore']) ? $_POST['startScore'] : 0;
			$lastTopicId = isset($_POST['lastTopicId']) ? $_POST['lastTopicId'] : 0;
			$endScore = isset($_POST['birthday']) ? $_POST['birthday'] : 0;
			
			$viewerId = $this->uid;
			
			if (empty($uid) || empty($year) || empty($month)) {
				echo json_encode(array('status' => 0, 'msg' => '传递参数不正确'));
				exit();
			}
			
			$this->load->model('TimelineModel');
			echo json_encode($this->TimelineModel->getFragmentFeeds($uid, $year, $month, $viewerId, $startScore, $endScore, $lastTopicId));
			exit();
		}
	}
	
        
    public function updateHighlight() {
    	if ($this->isAjax()) {
    		$res = array(
    				'status' => 0
    		);
    		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    			$tid = $this->input->post('tid');
    			$highlight = $this->input->post('highlight');
    			$fiends = call_soap('timeline', 'Timeline', 'updateTimelineHighlight', array('tid' => $tid, $highlight));
    			$res['status'] = 1;
    		}
    		return json_encode($res);
    		exit();
    	}
    }
}

