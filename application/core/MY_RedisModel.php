<?php

/**
 * Redis模型，负责从redis中取数据
 * @author 应晓斌
 */
require_cache(APPPATH . 'core' . DS . 'MY_Redis' . EXT);
class MY_RedisModel
{
	/**
	 * Redis 连接
	 * @var Redis
	 */
	protected $_redis;
	
	public function __construct()
	{
		$this->_redis = MY_Redis::getInstance();
	}
	
}