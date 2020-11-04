<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.2
	File:			application\models\Phonebook_model.php
	Description:	Database queries for the Phonebook controller
	
	2020 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

class Phonebook_model extends CI_Model {
	
	//
	// Abonents query
	//
	function abonent_get($params=NULL)
	{
		if (!is_null($params))
		{
			$this->db->select('*')->from('phonebook_data');
			
			if (isset($params['id']) AND is_numeric($params['id']))
			{
				$this->db->where('id', $params['id']);
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
	
	function abonent_change_status($id=NULL, $status=NULL)
	{
		if (!is_null($id) AND is_numeric($id) AND !is_null($status) AND is_numeric($status))
		{
			$update_data = array(
				'status'	=> $status
			);
			$this->db->where('id', $id);
			$query = $this->db->update('phonebook_data', $update_data);
			return TRUE;
		}
		return FALSE;
	}
	
	function abonent_add($data=NULL)
	{
		if (!is_null($data) AND is_array($data) AND isset($data['first_name']) AND isset($data['last_name']) AND isset($data['phone_work']) AND isset($data['status']) AND isset($data['data_source']))
		{
			$add_data = array(
				'first_name'		=> $data['first_name'],
				'last_name' 		=> $data['last_name'],
				'phone_work'		=> $data['phone_work'],
				'status'			=> $data['status'],
				'data_source'		=> $data['data_source']
			);
			$this->db->insert('phonebook_data', $add_data);
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
		return FALSE;
	}
	
	function abonent_edit($id=NULL, $data=NULL)
	{
		if (!is_null($id) AND is_numeric($id) AND !is_null($data) AND is_array($data) AND isset($data['first_name']) AND isset($data['last_name']) AND isset($data['phone_work']) AND isset($data['status']) AND isset($data['data_source']))
		{
			$update_data = array(
				'first_name'		=> $data['first_name'],
				'last_name' 		=> $data['last_name'],
				'phone_work'		=> $data['phone_work'],
				'status'			=> $data['status'],
				'data_source'		=> $data['data_source']
			);
			$this->db->where('id', $id);
			$query = $this->db->update('phonebook_data', $update_data);
			return TRUE;
		}
		return FALSE;
	}
	
	function abonent_del($id=NULL)
	{
		if (!is_null($id) AND is_numeric($id['id']))
		{
			$this->db->where('id', $id);
			$query = $this->db->delete('phonebook_data');
			return TRUE;
		}
		return FALSE;
	}
	
	function abonents_getlist()
	{
		$this->db->select()->from('phonebook_data')->order_by('first_name', 'ASC')->order_by('last_name', 'ASC');
		$result = $this->db->get()->result_array();
		if (count($result) > 0)
		{
			return $result;
		}
		return FALSE;
	}
}