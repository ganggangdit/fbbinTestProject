<?php
/**
 * +-------------------------------
 * 模型
 * +-------------------------------
 * @author mawenpei<mawenpei@duankou.com>
 * @date <2012/02/14>
 * @version $Id$
 */

class MY_Model
{		
	/**
	 * 构造函数
	 */
	public function __construct()
	{
		log_message('dubug','Model Class Initialized');
	}

//	/**
//	 * 执行一条SQL查询语句
//	 * 
//	 * @param string $sql
//	 */
//	protected function query($sql)
//	{		
//		return call_soap('ddal','Ddal','query',array($sql));
//	}
//	
//	/**
//	 * 执行一条或多条非select的SQL语句
//	 */
//	protected function execute($sql)
//	{
//		return call_soap('ddal','Ddal','execute',array($sql));
//	}
//	
//	/**
//	 * 魔术方法,用来支持调用核心系统中数据访问层的所有方法
//	 */
//	public function __call($method,$params=null)
//	{
//		return call_soap('ddal','Ddal',$method,$params);
//	}
}