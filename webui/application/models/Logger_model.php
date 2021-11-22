<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.3
	File:			application\models\Logger_model.php
	Description:	Database queries for logging
	
	2021 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

class Logger_model extends CI_Model {
	
	function get_logs($params=NULL)
	{
		if (!is_null($params))
		{
			$this->db->select('*')->from('logs_data');
			
			// Set unit_id
			if (isset($params['unit_id']) AND is_numeric($params['unit_id']))
			{
				$this->db->where('unit_id', $params['unit_id']);
			}
			
			// Set type
			if (isset($params['type']) AND is_string($params['type']))
			{
				if ($params['type'] == 'provisioning')
				{
					$types = array('device_get_cfg', 'device_get_fw', 'device_get_pb');
					$this->db->where_in('type', $types);
				}
				elseif ($params['type'] == 'api')
				{
					$types = array('api_get');
					$this->db->where_in('type', $types);
				}
				else
				{
					$this->db->where('type', $params['type']);
				}
			}
			
			// Set limit
			if (isset($params['limit']) AND is_numeric($params['limit']))
			{
				if (isset($params['start']) AND is_numeric($params['start']))
				{
					$this->db->limit($params['limit'], $params['start']);
				}
				else
				{
					$this->db->limit($params['limit']);
				}
			}
			
			$this->db->order_by('datetime', 'DESC');
			if (isset($params['get_total']) AND $params['get_total'] == TRUE)
			{
				$result = $this->db->count_all_results();
			}
			else
			{
				$result = $this->db->get()->result_array();
			}
			
			if (isset($result))
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
	
	function clean_logs($params=NULL)
	{
		// Selecting all logs of the specified type
		if (isset($params['type']))
		{
			if ($params['type'] == 'provisioning')
			{
				$where_type_array = array('device_get_pb', 'device_get_fw', 'device_get_cfg');
			}
			elseif ($params['type'] == 'api')
			{
				$where_type_array = array('api_get');
			}
			elseif ($params['type'] == 'all')
			{
				$where_type_array = array('device_get_pb', 'device_get_fw', 'device_get_cfg', 'api_get');
			}
			else
			{
				return FALSE;
			}
			$this->db->where_in('type', $where_type_array);
		}
		else
		{
			return FALSE;
		}
		
		if (isset($params['min_date']) OR isset($params['unit_id']))
		{
			// Selecting all logs less than the specified date
			if (isset($params['min_date']) AND $this->grcentral->is_date($params['min_date']) != FALSE)
			{
				$this->db->where('datetime <', $params['min_date']);
			}
			
			// Selecting all logs of the specified unit
			if (isset($params['unit_id']) AND is_numeric($params['unit_id']))
			{
				$this->db->where('unit_id', $params['unit_id']);
			}
			
			$result = $this->db->delete('logs_data');
			
			if ($result != FALSE)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}
}