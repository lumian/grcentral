<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.3
	File:			application\controllers\Api.php
	Description:	API for GRCentral.
	
	2020 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

class Api extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		// Loading models:
		$this->load->model('phonebook_model');
	}
	
	public function v1($category=NULL)
	{
		$result = array(
			'result'		=> NULL,
			'error'			=> TRUE
		);
				
		if (!is_null($category))
		{
			if ($category == 'phonebook')
			{
				$query_type = $this->uri->segment(4);
				$query_subtype = $this->uri->segment(5);
				
				if (!is_null($query_type) AND !is_null($query_subtype))
				{
					if ($query_type == 'full' AND ($query_subtype == 'active' OR $query_subtype == 'all'))
					{
						$query_result = $this->_v1_phonebook_get($query_type, $query_subtype);
					}
					if ($query_type == 'contact' AND is_numeric($query_subtype))
					{
						$query_result = $this->_v1_phonebook_get($query_type, $query_subtype);
					}
				}
			}
		}
		
		if (isset($query_result) AND isset($query_result['data']) AND isset($query_result['error']))
		{
			if ($query_result['error'] == FALSE AND is_array($query_result['data']))
			{
				$result['error'] = FALSE;
				$result['result'] = $query_result['data'];
			}
		}
		$result_json = json_encode($result, JSON_UNESCAPED_UNICODE);
		echo($result_json);
	}
	
	private function _v1_phonebook_get($type=NULL, $param=NULL)
	{
		$result = array(
			'data'		=> NULL,
			'error'		=> TRUE
		);
		
		if (!is_null($type))
		{
			if ($type == 'full' AND !is_null($param))
			{
				if ($param == 'all')
				{
					$phonebook = $this->phonebook_model->abonents_getlist();
				}
				
				if ($param == 'active')
				{
					$phonebook = $this->phonebook_model->abonents_getlist(array('status'=>'1'));
				}
				
				if ($phonebook != FALSE)
				{
					foreach($phonebook as $contact)
					{
						$result_data[$contact['id']] = array(
							'first_name'		=> $contact['first_name'],
							'last_name'			=> $contact['last_name'],
							'phone_work'		=> $contact['phone_work']
						);
					}
				}
			}
			
			if ($type == 'contact' AND !is_null($param) AND is_numeric($param))
			{
				$contact_info = $this->phonebook_model->abonent_get(array('phone_work'=>$param));
				
				if ($contact_info != FALSE)
				{
					$result_data = array(
						'first_name'		=> $contact_info['first_name'],
						'last_name'			=> $contact_info['last_name'],
						'phone_work'		=> $contact_info['phone_work']
					);
				}
			}
			
			if (isset($result_data) AND is_array($result_data))
			{
				$result = array(
					'data'		=> $result_data,
					'error'		=> FALSE
				);
			}
		}
		return $result;
	}
}
