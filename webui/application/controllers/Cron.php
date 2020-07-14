<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		// Loading models:
		$this->load->model('settings_model');
		$this->load->model('phones_model');
		$this->load->model('tempdata_model');
	}
	
	public function webcron($type=NULL)
	{
		if (!$this->grcentral->is_user())
		{
			redirect(index_page());
		}
		$result = FALSE;
		
		if ($type == 'gencfg')
		{
			$result = $this->generate_cfg();
		}
		else
		{
			show_404();
		}
		
		if ($result == TRUE)
		{
			echo "Task completed: ".$type.PHP_EOL;
		}
	}
	
	public function clicron($type=NULL)
	{
		$result = FALSE;
		
		if ($this->input->is_cli_request())
		{
			if ($type == 'gencfg')
			{
				$result = $this->generate_cfg();
			}
		}
		else
		{
			echo "Error: Only CLI requests are allowed.";
		}
		if ($result == TRUE)
		{
			echo "Task completed: ".$type.PHP_EOL;
		}
	}
	
	//
	// Service functions
	//
	private function generate_cfg()
	{
		$this->tempdata_model->put_value('settings_need_apply', '0');
		$phones_list = $this->phones_model->getlist();
		$params_list = $this->settings_model->params_getlist();
		$models_list = $this->settings_model->models_getlist(array('group_data'=>TRUE));
		$servers_list = $this->settings_model->servers_getlist();
		
		if ($phones_list != FALSE AND $params_list != FALSE AND $models_list != FALSE AND $servers_list != FALSE)
		{
			$xml_data = FALSE;
			
			foreach ($phones_list as $phone)
			{
				$params_id = $models_list[$phone['model_id']]['params_group_id'];
				$params_array_src = json_decode($params_list[$params_id]['params_json_data'], TRUE);
				$params_array = array();
				
				foreach($params_array_src as $param_string)
				{
					if (mb_stripos($param_string, "=") != FALSE)
					{
						$string_array = explode("=", $param_string);
						$key = trim($string_array[0]);
						$param = trim($string_array[1]);
						$params_array[$key] = $param;
					}
				}
				
				if (isset($params_array['P2']))
				{
					// Update admin password in DB for CTI
					$this->phones_model->edit($phone['id'], array('admin_password' => $params_array['P2']));
				}
				else
				{
					// Clear admin password in DB.
					$this->phones_model->edit($phone['id'], array('admin_password' => ''));
				}
				
				$accounts_array = json_decode($phone['accounts_data'], TRUE);
				
				if ($accounts_array != NULL)
				{
					foreach($accounts_array as $acc_num=>$acc_info)
					{
						if ($acc_num == '1')
						{
							$params_array['P271']	= $acc_info['active'];
							$params_array['P270']	= $acc_info['name'];
							$params_array['P47']	= $servers_list[$acc_info['voipsrv1']]['server'];
							$params_array['P2312']	= $servers_list[$acc_info['voipsrv2']]['server'];
							$params_array['P35']	= $acc_info['userid'];
							$params_array['P36']	= $acc_info['authid'];
							$params_array['P34']	= $acc_info['password'];
							$params_array['P3']		= $acc_info['name'];
							$params_array['P2380']	= '1';
						}
						if ($acc_num == '2')
						{
							$params_array['P401'] 	= $acc_info['active'];
							$params_array['P417']	= $acc_info['name'];
							$params_array['P402']	= $servers_list[$acc_info['voipsrv1']]['server'];
							$params_array['P2412']	= $servers_list[$acc_info['voipsrv2']]['server'];
							$params_array['P404']	= $acc_info['userid'];
							$params_array['P405']	= $acc_info['authid'];
							$params_array['P406']	= $acc_info['password'];
							$params_array['P407']	= $acc_info['name'];
							$params_array['P2480']	= '1';
						}
						if ($acc_num == '3')
						{
							$params_array['P501'] 	= $acc_info['active'];
							$params_array['P517']	= $acc_info['name'];
							$params_array['P502']	= $servers_list[$acc_info['voipsrv1']]['server'];
							$params_array['P2512']	= $servers_list[$acc_info['voipsrv2']]['server'];
							$params_array['P504']	= $acc_info['userid'];
							$params_array['P505']	= $acc_info['authid'];
							$params_array['P506']	= $acc_info['password'];
							$params_array['P507']	= $acc_info['name'];
							$params_array['P2580']	= '1';
						}
						if ($acc_num == '4')
						{
							$params_array['P601'] 	= $acc_info['active'];
							$params_array['P617']	= $acc_info['name'];
							$params_array['P602']	= $servers_list[$acc_info['voipsrv1']]['server'];
							$params_array['P2612']	= $servers_list[$acc_info['voipsrv2']]['server'];
							$params_array['P604']	= $acc_info['userid'];
							$params_array['P605']	= $acc_info['authid'];
							$params_array['P606']	= $acc_info['password'];
							$params_array['P607']	= $acc_info['name'];
							$params_array['P2680']	= '1';
						}
					}
				}
				
				$xml_data[] = array(
					'mac'				=> $phone['mac_addr'],
					'params'			=> $params_array
				);
			}
			
			if (is_array($xml_data))
			{
				foreach($xml_data as $xml)
				{
					$put_data = '<?xml version="1.0" encoding="UTF-8" ?>'.PHP_EOL;
					$put_data .= '<gs_provision version="1">'.PHP_EOL;
					$put_data .= '	<mac>'.$xml['mac'].'</mac>'.PHP_EOL;
					$put_data .= '	<config version="1">'.PHP_EOL;
					
					foreach($xml['params'] as $key=>$value)
					{
						$put_data .= '		<'.$key.'>'.$value.'</'.$key.'>'.PHP_EOL;
					}
					
					$put_data .= '	</config>'.PHP_EOL;
					$put_data .= '</gs_provision>'.PHP_EOL;
					
					$xml_path = $this->config->item('storage_path', 'grcentral').'cfg/cfg'.$xml['mac'].'.xml';
					file_put_contents($xml_path, $put_data);
					chmod($xml_path, 0666);
				}
				return TRUE;
			}
		}
		return FALSE;
	}
}
