<?php
/*
 * 对 CI_Exceptions类的log_exception方法进了重写
 * zeng xiang mo
 */
class MY_Exceptions extends CI_Exceptions {
	function log_exception($severity, $message, $filepath, $line) {
		$severity = (! isset ( $this->levels [$severity] )) ? $severity : $this->levels [$severity];
		log_message ( $severity, $message, $filepath, $line, TRUE );
	}

}