<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.2
	File:			application\models\Logger_model.php
	Description:	Database queries for logging
	
	2020 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

class Logger_model extends CI_Model {
	
	function get_logs($params=NULL)
	{
		if (!is_null($params))
		{
			$this->db->select('*')->from('logs_data');
			
			if (isset($params['unit_id']) AND is_numeric($params['unit_id']) AND isset($params['type']) AND is_string($params['type']))
			{
				$this->db->where('unit_id', $params['unit_id']);
				
				if ($params['type'] = 'provisioning')
				{
					$types = array('device_get_cfg', 'device_get_fw', 'device_get_pb');
					$this->db->where_in('type', $types);
				}
				else
				{
					$this->db->where('type', $params['type']);
				}
				if (isset($params['limit']) AND is_numeric($params['limit']))
				{
					$this->db->limit($params['limit']);
				}
				$this->db->order_by('datetime', 'DESC');
			}
			else
			{
				return FALSE;
			}
			$result = $this->db->get()->result_array();
			
			if (isset($result) AND count($result) > 0)
			{
				return $result;
			}
		}
		return FALSE;
	}
	
	function add_log($data=NULL)
	{
		if (!is_null($data) AND is_array($data))
		{
			$this->db->insert('logs_data', $data);
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
		return FALSE;
	}
}