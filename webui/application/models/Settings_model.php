<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.3
	File:			application\models\Settings_model.php
	Description:	Database queries for the Settings controller
	
	2021 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

class Settings_model extends CI_Model {
	
	//
	// Phone models query
	//
	function models_get($params=NULL)
	{
		if (!is_null($params))
		{
			$this->db->select('*')->from('settings_models');
			
			if (isset($params['id']) AND is_numeric($params['id']))
			{
				$this->db->where('id', $params['id']);
			}
			elseif (isset($params['tech_name']) AND is_string($params['tech_name']))
			{
				$this->db->where('tech_name', $params['tech_name']);
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
	
	function models_getlist($params=NULL)
	{
		$this->db->from('settings_models')->order_by('friendly_name', 'ASC');
		if (!is_null($params) AND isset($params['group_id']) AND is_numeric($params['group_id']))
		{
			$this->db->where('group_id', $params['group_id']);
		}
		if (!is_null($params) AND isset($params['group_data']) AND $params['group_data'] == TRUE)
		{
			$this->db->select('
					settings_models.*,
					settings_models_group.name AS group_name,
					settings_models_group.params_group_id,
					settings_models_group.params_conf_acc_atatus,
					settings_models_group.params_conf_acc_name,
					settings_models_group.params_conf_srv_main,
					settings_models_group.params_conf_srv_reserve,
					settings_models_group.params_conf_sip_userid,
					settings_models_group.params_conf_sip_authid,
					settings_models_group.params_conf_sip_passwd,
					settings_models_group.params_conf_show_name,
					settings_models_group.params_conf_acc_display,
					settings_models_group.params_conf_voicemail
				
			');
			$this->db->join('settings_models_group', 'settings_models_group.id = settings_models.group_id');
		}
		$query = $this->db->get()->result_array();
		if (count($query) > 0)
		{
			foreach ($query as $row)
			{
				$result[$row['id']] = $row;
			}
			if (isset($result))
			{
				return $result;
			}
		}
		return FALSE;
	}
	
	function models_add($data=NULL)
	{
		if (!is_null($data) AND is_array($data) AND isset($data['tech_name']) AND isset($data['friendly_name']) AND isset($data['group_id']))
		{
			$add_data = array(
				'tech_name'					=> $data['tech_name'],
				'friendly_name' 			=> $data['friendly_name'],
				'group_id'					=> $data['group_id']
			);
			$this->db->insert('settings_models', $add_data);
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
		return FALSE;
	}
	
	function models_edit($id=NULL, $data=NULL)
	{
		if (!is_null($id) AND is_numeric($id) AND !is_null($data) AND is_array($data) AND isset($data['tech_name']) AND isset($data['friendly_name']) AND isset($data['group_id']))
		{
			$update_data = array(
				'tech_name'					=> $data['tech_name'],
				'friendly_name' 			=> $data['friendly_name'],
				'group_id'					=> $data['group_id']
			);
			$this->db->where('id', $id);
			$query = $this->db->update('settings_models', $update_data);
			return TRUE;
		}
		return FALSE;
	}
	
	function models_del($id=NULL)
	{
		if (!is_null($id) AND is_numeric($id['id']))
		{
			$this->db->where('id', $id);
			$query = $this->db->delete('settings_models');
			return TRUE;
		}
		return FALSE;
	}
	
	function models_group_get($params=NULL)
	{
		if (!is_null($params))
		{
			if (isset($params['id']) AND is_numeric($params['id']))
			{
				$this->db->select('*')->from('settings_models_group')->where('id', $params['id']);
				$result = $this->db->get()->result_array();
			}
			if (isset($result) AND count($result) == 1)
			{
				return $result[0];
			}
		}
		return FALSE;
	}
	
	function models_group_getlist($params=NULL)
	{
		$this->db->select('*')->from('settings_models_group')->order_by('name', 'ASC');
		if (!is_null($params) AND isset($params['params_group_id']) AND is_numeric($params['params_group_id']))
		{
			$this->db->where('params_group_id', $params['params_group_id']);
		}
		$result = $this->db->get()->result_array();
		if (count($result) > 0)
		{
			return $result;
		}
		return FALSE;
	}
	
	function models_group_add($data=NULL)
	{
		if (!is_null($data) AND is_array($data) AND isset($data['name']) AND is_numeric($data['params_group_id']) AND isset($data['params_conf_acc_atatus'])
			AND isset($data['params_conf_acc_name']) AND isset($data['params_conf_srv_main']) AND isset($data['params_conf_srv_reserve'])
			AND isset($data['params_conf_sip_userid']) AND isset($data['params_conf_sip_authid']) AND isset($data['params_conf_sip_passwd'])
			AND isset($data['params_conf_show_name']) AND isset($data['params_conf_acc_display']) AND isset($data['params_conf_voicemail']))
		{
			$add_data = array(
				'name'						=> $data['name'],
				'params_group_id'			=> $data['params_group_id'],
				'params_conf_acc_atatus'	=> $data['params_conf_acc_atatus'],
				'params_conf_acc_name'		=> $data['params_conf_acc_name'],
				'params_conf_srv_main'		=> $data['params_conf_srv_main'],
				'params_conf_srv_reserve'	=> $data['params_conf_srv_reserve'],
				'params_conf_sip_userid'	=> $data['params_conf_sip_userid'],
				'params_conf_sip_authid'	=> $data['params_conf_sip_authid'],
				'params_conf_sip_passwd'	=> $data['params_conf_sip_passwd'],
				'params_conf_show_name'		=> $data['params_conf_show_name'],
				'params_conf_acc_display'	=> $data['params_conf_acc_display'],
				'params_conf_voicemail'		=> $data['params_conf_voicemail']
			);
			$this->db->insert('settings_models_group', $add_data);
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
		return FALSE;
	}
	
	function models_group_edit($id=NULL, $data=NULL)
	{
		if (!is_null($data) AND is_array($data) AND isset($data['name']) AND is_numeric($data['params_group_id']) AND isset($data['params_conf_acc_atatus'])
			AND isset($data['params_conf_acc_name']) AND isset($data['params_conf_srv_main']) AND isset($data['params_conf_srv_reserve'])
			AND isset($data['params_conf_sip_userid']) AND isset($data['params_conf_sip_authid']) AND isset($data['params_conf_sip_passwd'])
			AND isset($data['params_conf_show_name']) AND isset($data['params_conf_acc_display']) AND isset($data['params_conf_voicemail']))
		{
			$update_data = array(
				'name'						=> $data['name'],
				'params_group_id'			=> $data['params_group_id'],
				'params_conf_acc_atatus'	=> $data['params_conf_acc_atatus'],
				'params_conf_acc_name'		=> $data['params_conf_acc_name'],
				'params_conf_srv_main'		=> $data['params_conf_srv_main'],
				'params_conf_srv_reserve'	=> $data['params_conf_srv_reserve'],
				'params_conf_sip_userid'	=> $data['params_conf_sip_userid'],
				'params_conf_sip_authid'	=> $data['params_conf_sip_authid'],
				'params_conf_sip_passwd'	=> $data['params_conf_sip_passwd'],
				'params_conf_show_name'		=> $data['params_conf_show_name'],
				'params_conf_acc_display'	=> $data['params_conf_acc_display'],
				'params_conf_voicemail'		=> $data['params_conf_voicemail']
			);
			$this->db->where('id', $id);
			$query = $this->db->update('settings_models_group', $update_data);
			return TRUE;
		}
		return FALSE;
	}
	
	function models_group_del($id=NULL)
	{
		if (!is_null($id) AND is_numeric($id['id']))
		{
			$this->db->where('id', $id);
			$query = $this->db->delete('settings_models_group');
			return TRUE;
		}
		return FALSE;
	}
	
	//
	// FW query
	//
	function fw_get($params=NULL)
	{
		if (!is_null($params))
		{
			if (isset($params['id']) AND is_numeric($params['id']))
			{
				$this->db->select('*')->from('settings_fw')->where('id', $params['id']);
				$result = $this->db->get()->result_array();
			}
			if (isset($result) AND count($result) == 1)
			{
				return $result[0];
			}
		}
		return FALSE;
	}
	
	function fw_getlist($params=NULL)
	{
		if (!is_null($params) AND isset($params['group_id']) AND is_numeric($params['group_id']))
		{
			$this->db->select('*')->from('settings_fw')->where('group_id', $params['group_id'])->order_by('version', 'ASC');
			
			if (isset($params['status']) AND is_numeric($params['status']))
			{
				$this->db->where('status', $params['status']);
			}
			$result_db = $this->db->get()->result_array();
			if (count($result_db) > 0)
			{
				// Natural sorting
				foreach ($result_db as $key=>$value)
				{
					$tmp_array[$key] = $value['version'];
				}
				natsort($tmp_array);
				foreach ($tmp_array as $key=>$value)
				{
					$result[] = $result_db[$key];
				}
				
				return $result;
			}
		}
		return FALSE;
	}
	
	function fw_add($data=NULL)
	{
		if (!is_null($data) AND is_array($data) AND isset($data['group_id']) AND isset($data['version']) AND isset($data['file_name']) AND isset($data['file_name_real']) AND isset($data['status']))
		{
			$add_data = array(
				'group_id'			=> $data['group_id'],
				'version' 			=> $data['version'],
				'status' 			=> $data['status'],
				'file_name'			=> $data['file_name'],
				'file_name_real'	=> $data['file_name_real']
			);
			$this->db->insert('settings_fw', $add_data);
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
		return FALSE;
	}
	
	function fw_del($id=NULL)
	{
		if (!is_null($id) AND is_numeric($id['id']))
		{
			$this->db->where('id', $id);
			$query = $this->db->delete('settings_fw');
			return TRUE;
		}
		return FALSE;
	}
	
	function fw_change_status($fw_info=NULL, $status=NULL)
	{
		if (!is_null($fw_info) AND is_array($fw_info) AND isset($fw_info['id']) AND is_numeric($fw_info['id']) AND isset($fw_info['group_id']) AND is_numeric($fw_info['group_id']) AND !is_null($status) AND is_numeric($status))
		{
			$this->db->update('settings_fw', array('status' => '0'), array('group_id' => $fw_info['group_id']));
			$this->db->update('settings_fw', array('status' => $status), array('id' => $fw_info['id']));
			return TRUE;
		}
		return FALSE;
	}
	
	//
	// Params query
	//
	function params_get($params=NULL)
	{
		if (!is_null($params))
		{
			if (isset($params['id']) AND is_numeric($params['id']))
			{
				$this->db->select('*')->from('settings_params')->where('id', $params['id']);
				$result = $this->db->get()->result_array();
			}
			if (isset($result) AND count($result) == 1)
			{
				return $result[0];
			}
		}
		return FALSE;
	}
	
	function params_getlist($params=NULL)
	{
		$this->db->select('*')->from('settings_params')->order_by('name', 'ASC');
		if (!is_null($params) AND isset($params['parent_id']) AND is_numeric($params['parent_id']))
		{
			$this->db->where('parent_id', $params['parent_id']);
		}
		$result_query = $this->db->get()->result_array();
		if (count($result_query) > 0)
		{
			foreach($result_query as $row)
			{
				$result[$row['id']] = $row;
			}
			return $result;
		}
		return FALSE;
	}
	
	function params_add($data=NULL)
	{
		if (!is_null($data) AND is_array($data) AND isset($data['name']) AND isset($data['description']) AND isset($data['params_source_data']) AND isset($data['params_json_data']))
		{
			$add_data = array(
				'name'					=> $data['name'],
				'description'			=> $data['description'],
				'params_source_data'	=> $data['params_source_data'],
				'params_json_data'		=> $data['params_json_data']
			);
			$this->db->insert('settings_params', $add_data);
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
		return FALSE;
	}
	
	function params_edit($id=NULL, $data=NULL)
	{
		if (!is_null($data) AND is_array($data) AND isset($data['name']) AND isset($data['description']) AND isset($data['params_source_data']) AND isset($data['params_json_data']))
		{
			$update_data = array(
				'name'					=> $data['name'],
				'description'			=> $data['description'],
				'params_source_data'	=> $data['params_source_data'],
				'params_json_data'		=> $data['params_json_data']
			);
			$this->db->where('id', $id);
			$query = $this->db->update('settings_params', $update_data);
			return TRUE;
		}
		return FALSE;
	}
	
	function params_del($id=NULL)
	{
		if (!is_null($id) AND is_numeric($id['id']))
		{
			$this->db->where('id', $id);
			$query = $this->db->delete('settings_params');
			return TRUE;
		}
		return FALSE;
	}

	//
	// Servers query
	//
	function servers_get($params=NULL)
	{
		if (!is_null($params))
		{
			if (isset($params['id']) AND is_numeric($params['id']))
			{
				$this->db->select('*')->from('settings_servers')->where('id', $params['id']);
				$result = $this->db->get()->result_array();
			}
			if (isset($result) AND count($result) == 1)
			{
				return $result[0];
			}
		}
		return FALSE;
	}
	
	function servers_getlist()
	{
		$this->db->select('*')->from('settings_servers')->order_by('name', 'ASC');
		$result_query = $this->db->get()->result_array();
		if (count($result_query) > 0)
		{
			foreach($result_query as $row)
			{
				$result[$row['id']] = $row;
			}
			return $result;
		}
		return FALSE;
	}
	
	function servers_add($data=NULL)
	{
		if (!is_null($data) AND is_array($data) AND isset($data['name']) AND isset($data['description']) AND isset($data['server']))
		{
			$add_data = array(
				'name'					=> $data['name'],
				'description'			=> $data['description'],
				'server'				=> $data['server']
			);
			
			if (isset($data['voicemail_number']))
			{
				$add_data['voicemail_number'] = $data['voicemail_number'];
			}
			
			$this->db->insert('settings_servers', $add_data);
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
		return FALSE;
	}
	
	function servers_edit($id=NULL, $data=NULL)
	{
		if (!is_null($data) AND is_array($data) AND isset($data['name']) AND isset($data['description']) AND isset($data['server']))
		{
			$update_data = array(
				'name'					=> $data['name'],
				'description'			=> $data['description'],
				'server'				=> $data['server']
			);
			
			if (isset($data['voicemail_number']))
			{
				$update_data['voicemail_number'] = $data['voicemail_number'];
			}
			
			$this->db->where('id', $id);
			$query = $this->db->update('settings_servers', $update_data);
			return TRUE;
		}
		return FALSE;
	}
	
	function servers_del($id=NULL)
	{
		if (!is_null($id) AND is_numeric($id['id']))
		{
			$this->db->where('id', $id);
			$query = $this->db->delete('settings_servers');
			return TRUE;
		}
		return FALSE;
	}
	
	//
	// System settings query
	//
	
	function syssettings_get($key=NULL)
	{
		if (!is_null($key) AND is_string($key))
		{
			$this->db->select('*')->from('settings_system')->where('key', $key);
			$result = $this->db->get()->result_array();
			
			if (count($result) === 1)
			{
				return $result[0]['value'];
			}
		}
		return FALSE;
	}
	
	function syssettings_getlist()
	{
		$this->db->select('*')->from('settings_system');
		$result_query = $this->db->get()->result_array();
		if (count($result_query) > 0)
		{
			foreach($result_query as $row)
			{
				$result[$row['key']] = $row['value'];
			}
			return $result;
		}
		return FALSE;
	}
	
	function syssettings_update($put_data=NULL)
	{
		$settings_list = $this->syssettings_getlist();
		
		if (!is_null($put_data))
		{
			foreach($put_data as $key => $value)
			{
				if (isset($settings_list[$key]))
				{
					$update_data[] = array(
						'key'		=> $key,
						'value'		=> $value
					);
				}
				else
				{
					$insert_data[] = array(
						'key'		=> $key,
						'value'		=> $value
					);
				}
			}
			
			if (isset($update_data))
			{
				$this->db->update_batch('settings_system', $update_data, 'key');
			}
			if (isset($insert_data))
			{
				$this->db->insert_batch('settings_system', $insert_data);
			}
			return TRUE;
		}
		return FALSE;
	}
	
	function syssettings_default($param='system')
	{
		if ($param == 'system')
		{
			$default_settings = array(
				'access_device_by_ip'		=> 'on',
				'auto_update_ip_addr'		=> 'off',
				'hide_help_header_msg'		=> 'off',
				'monitoring_enable'			=> 'off',
				'cfg_enable_get'			=> 'on',
				'auto_add_devices'			=> 'off',
				'fw_enable_update'			=> 'on',
				'fw_update_only_friend'		=> 'on',
				'pb_generate_enable'		=> 'on',
				'pb_collect_accounts'		=> 'on',
				'api_enable'				=> 'off'
			);
		}
		elseif ($param == 'update')
		{
			$default_settings = array(
				'checkupdate_last_datetime'		=> '',
				'checkupdate_version'			=> '',
				'checkupdate_version_info'		=> '',
				'checkupdate_status'			=> ''
			);
		}
		else
		{
			$default_settings = FALSE;
		}
		
		if (isset($default_settings) AND $default_settings != FALSE AND is_array($default_settings))
		{
			$this->syssettings_update($default_settings);
			return TRUE;
		}
		
		return FALSE;
	}
}