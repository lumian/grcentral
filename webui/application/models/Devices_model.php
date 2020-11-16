<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.2
	File:			application\models\Devices_model.php
	Description:	Database queries for the Devices controller
	
	2020 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

class Devices_model extends CI_Model {
	
	//
	// Devices query
	//
	function get($params=NULL)
	{
		if (!is_null($params))
		{
			$this->db->select('*')->from('devices_data');
			
			if (isset($params['id']) AND is_numeric($params['id']))
			{
				$this->db->where('id', $params['id']);
			}
			elseif (isset($params['mac_addr']) AND is_string($params['mac_addr']) AND mb_strlen($params['mac_addr']) == '12')
			{
				$this->db->where('mac_addr', $params['mac_addr']);
			}
			else
			{
				return FALSE;
			}
			$result = $this->db->get()->result_array();
			
			if (isset($result) AND count($result) == 1)
			{
				return $result[0];
			}
		}
		return FALSE;
	}
	
	function getlist()
	{
		$this->db->select()->from('devices_data')->order_by('descr', 'ASC');
		$result = $this->db->get()->result_array();
		if (count($result) > 0)
		{
			return $result;
		}
		return FALSE;
	}
	
	function add($data=NULL)
	{
		if (!is_null($data) AND is_array($data) AND isset($data['mac_addr']) AND isset($data['ip_addr']) AND isset($data['model_id']) AND isset($data['status_active']))
		{
			$add_data = array(
				'mac_addr'			=> $data['mac_addr'],
				'ip_addr' 			=> $data['ip_addr'],
				'model_id'			=> $data['model_id'],
				'status_active'		=> $data['status_active']
			);
			if (isset($data['descr'])) { $add_data['descr'] = $data['descr']; }
			if (isset($data['params_source_data'])) {$add_data['params_source_data'] = $data['params_source_data']; }
			if (isset($data['params_json_data'])) { $add_data['params_json_data'] = $data['params_json_data']; }
			if (isset($data['fw_version'])) { $add_data['fw_version'] = $data['fw_version']; }
			if (isset($data['fw_version_pinned'])) { $add_data['fw_version_pinned'] = $data['fw_version_pinned']; }
			
			$this->db->insert('devices_data', $add_data);
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
		return FALSE;
	}
	
	function edit($id=NULL, $data=NULL)
	{
		if (is_numeric($id) AND !is_null($data) AND is_array($data))
		{
			$update_data = array();
			if (isset($data['mac_addr']))			{ $update_data['mac_addr']			= $data['mac_addr']; }
			if (isset($data['ip_addr']))			{ $update_data['ip_addr']			= $data['ip_addr']; }
			if (isset($data['model_id']))			{ $update_data['model_id']			= $data['model_id']; }
			if (isset($data['status_active']))		{ $update_data['status_active']		= $data['status_active']; }
			if (isset($data['descr']))				{ $update_data['descr']				= $data['descr']; }
			if (isset($data['params_source_data']))	{ $update_data['params_source_data']= $data['params_source_data']; }
			if (isset($data['params_json_data']))	{ $update_data['params_json_data']	= $data['params_json_data']; }
			if (isset($data['fw_version']))			{ $update_data['fw_version']		= $data['fw_version']; }
			if (isset($data['fw_version_pinned']))	{ $update_data['fw_version_pinned']	= $data['fw_version_pinned']; }
			if (isset($data['admin_password']))		{ $update_data['admin_password']	= $data['admin_password']; }
			
			$this->db->where('id', $id);
			$query = $this->db->update('devices_data', $update_data);
			return TRUE;
		}
		return FALSE;
	}
	
	function edit_accounts($id=NULL, $data=NULL)
	{
		if (is_numeric($id) AND !is_null($data) AND is_array($data) AND isset($data['accounts_data']))
		{
			$update_data = array(
				'accounts_data'			=> $data['accounts_data']
			);
			
			$this->db->where('id', $id);
			$query = $this->db->update('devices_data', $update_data);
			return TRUE;
		}
		return FALSE;
	}
	
	function del($id=NULL)
	{
		if (!is_null($id) AND is_numeric($id['id']))
		{
			$this->db->where('id', $id);
			$query = $this->db->delete('devices_data');
			return TRUE;
		}
		return FALSE;
	}
}