<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.1
	File:			application\models\Tempdata_model.php
	Description:	Database queries for tempdata table
	
	2020 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

class Tempdata_model extends CI_Model {
	
	function get_value($variable=NULL)
	{
		if (!is_null($variable) AND is_string($variable))
		{
			$this->db->select('*')->from('temp_data')->where('variable', $variable);
			$result = $this->db->get()->result_array();
			
			if (count($result) === 1)
			{
				return $result[0]['value'];
			}
		}
		return FALSE;
	}
	
	function put_value($variable=NULL,$value=NULL)
	{
		if (is_string($variable) AND is_string($value))
		{
			$get_value = $this->get_value($variable);
			
			if ($get_value === FALSE)
			{
				$result = $this->db->insert('temp_data', array('variable' => $variable, 'value' => $value));
			}
			else
			{
				$result = $this->db->update('temp_data', array('value' => $value), array('variable' => $variable));
			}
			return $result;
		}
		return FALSE;
	}
}