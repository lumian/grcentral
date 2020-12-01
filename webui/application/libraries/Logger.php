<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.3
	File:			application\libraries\Logger.php
	Description:	Log functions for GRCentral.
	
	2020 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

class Logger {
	
	var $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('logger_model');
	}
	
	public function device_get_cfg($id=NULL, $data=NULL)
	{
		if (!is_null($id) AND is_numeric($id) AND is_array($data))
		{
			$log_data = array(
				'unit_id'	=> $id,
				'type'		=> 'device_get_cfg',
				'datetime'	=> date('Y-m-d H:i:s'),
				'log_data'	=> json_encode($data)
			);
			$result = $this->CI->logger_model->add_log($log_data);
			return $result;
		}
	}
	
	public function device_get_fw($id=NULL, $data=NULL)
	{
		if (!is_null($id) AND is_numeric($id) AND is_array($data))
		{
			$log_data = array(
				'unit_id'	=> $id,
				'type'		=> 'device_get_fw',
				'datetime'	=> date('Y-m-d H:i:s'),
				'log_data'	=> json_encode($data)
			);
			$result = $this->CI->logger_model->add_log($log_data);
			return $result;
		}
	}
	
	public function device_get_pb($id=NULL, $data=NULL)
	{
		if (!is_null($id) AND is_numeric($id) AND is_array($data))
		{
			$log_data = array(
				'unit_id'	=> $id,
				'type'		=> 'device_get_pb',
				'datetime'	=> date('Y-m-d H:i:s'),
				'log_data'	=> json_encode($data)
			);
			$result = $this->CI->logger_model->add_log($log_data);
			return $result;
		}
	}
}
