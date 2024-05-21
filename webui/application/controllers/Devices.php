<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.4
	File:			application\controllers\Devices.php
	Description:	Controller for devices management
	
	2020-2024 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

class Devices extends CI_Controller {
	
	private $title = '';
	
	public function __construct()
	{
		parent::__construct();
		
		$this->grcentral->installed_check();
		
		if (!$this->grcentral->is_user())
		{
			redirect(index_page());
		}
		
		$this->lang->load('devices');
		$this->load->model('devices_model');
		$this->load->model('logger_model');
	}
	
	private function _RenderPage()
	{
		$template_page_data = array(
			'content'		=> $this->content,
		);
		
		$full_page_data = array(
			'title'			=> $this->config->item('site_title', 'grcentral')." - ".lang('main_menu_devices').$this->title,
			'content'		=> $this->load->view('devices/template', $template_page_data, TRUE),
		);
		
		$this->load->view('template', $full_page_data);
	}
	
	// AJAX functions
	public function ajax($func=NULL, $param=NULL)
	{
		if (!$this->input->is_ajax_request()) { show_404(current_url()); }
		$result_data['result'] = 'error';
		
		// Devices ajax query
		if (!is_null($func) AND !is_null($param))
		{
			if ($func == 'get' AND is_numeric($param))
			{
				$query = $this->devices_model->get(array('id'=>$param));
				
				if ($query != FALSE)
				{
					$result_data = array(
						'result'	=> 'success',
						'data'		=> $query
					);
				}
			}
			if ($func == 'get_accounts' AND is_numeric($param))
			{
				$query = $this->devices_model->get(array('id'=>$param));
				
				if ($query != FALSE)
				{
					$result_data = array(
						'result'	=> 'success',
						'data'		=> json_decode($query['accounts_data'],TRUE)
					);
				}
			}
			if ($func == 'cti_reboot' AND is_numeric($param))
			{
				$query = $this->devices_model->get(array('id' => $param));
				if ($query != FALSE AND is_array($query))
				{
					if (isset($query['ip_addr']) AND isset($query['admin_password']) AND $query['admin_password'] != '')
					{
						$get_url = 'http://'.$query['ip_addr'].'/cgi-bin/api-sys_operation?passcode='.$query['admin_password'].'&request=REBOOT';
						
						$data = @file_get_contents($get_url);
						$get_data = json_decode($data, TRUE);
						
						if ($get_data != NULL AND isset($get_data['response']) AND isset($get_data['body']) AND $get_data['response'] == 'success' AND $get_data['body'] == 'savereboot')
						{
							$result_data = array(
								'result'	=> 'success',
							);
						}
						
					}
				}
			}
			if ($func == 'get_logs' AND is_numeric($param))
			{
				$query = $this->logger_model->get_logs(array('unit_id'=>$param, 'type'=>'provisioning'));
				
				if ($query != FALSE)
				{
					foreach($query as $row)
					{
						$query_result[] = array(
							'type'		=> $row['type'],
							'log_data'	=> json_decode($row['log_data'], TRUE),
							'datetime'	=> $row['datetime']
						);
					}
					
					$result_data = array(
						'result'	=> 'success',
						'data'		=> (isset($query_result) ? $query_result : FALSE)
					);
				}
			}
			if ($func == 'get_fw_bymodel' AND is_numeric($param))
			{
				$model_info = $this->settings_model->models_get(array('id'=>$param));
				
				if ($model_info != FALSE)
				{
					$fw_list = $this->settings_model->fw_getlist(array('group_id' => $model_info['group_id']));
					
					if ($fw_list != FALSE)
					{
						$result_data = array(
							'result'	=> 'success',
							'data'		=> $fw_list
						);
					}
				}
			}
		}
		echo json_encode($result_data);
	}
	
	// Controller index page
	public function index()
	{
		$devices_list = $this->devices_model->getlist();
		$models_list = $this->settings_model->models_getlist();
		$groups_list = $this->settings_model->models_group_getlist();
		$fw_list = array();
		
		if ($groups_list != FALSE)
		{
			foreach ($groups_list as $group)
			{
				$fw_list[$group['id']] = array(
					'group_info'	=> $group,
					'items'			=> $this->settings_model->fw_getlist(array('group_id' => $group['id']))
				);
			}
		}
		
		$page_data = array(
			'devices_list'		=> $devices_list,
			'models_list'		=> $models_list,
			'fw_list'			=> $fw_list
		);
		
		$this->content = $this->load->view('devices/devices_list', $page_data, TRUE);
		$this->_RenderPage();
	}
	
	public function info($param=NULL)
	{
		if (!is_null($param) AND is_numeric($param))
		{
			$device_info = $this->devices_model->get(array('id' => $param));
			if ($device_info == FALSE)
			{
				show_404();
			}
			
			if ($device_info != FALSE)
			{
				$servers_list = $this->settings_model->servers_getlist();
				$device_info['model_info'] = $this->settings_model->models_get(array('id'=>$device_info['model_id']));
				
				if ($this->settings_model->syssettings_get('monitoring_enable') == 'on')
				{
					$monitoring['count_ok'] = $this->logger_model->get_logs(array('unit_id'=>$param, 'type'=>'monitoring', 'log_data'=> '1', 'get_total' => TRUE));
					$monitoring['all'] = $this->logger_model->get_logs(array('unit_id'=>$param, 'type'=>'monitoring', 'get_total' => TRUE));
					
					if ($monitoring['count_ok'] !== FALSE AND $monitoring['all'] !== FALSE AND $monitoring['all'] != 0)
					{
						$device_available = round($monitoring['count_ok'] / ($monitoring['all'] / 100), 0, PHP_ROUND_HALF_UP);
					}
					else
					{
						$device_available = '0';
					}
				}
				else
				{
					$device_available = '0';
				}
				
				// accounts:
				if ($device_info['accounts_data'] != NULL)
				{
					$accounts_list = json_decode($device_info['accounts_data'], TRUE);
				}
				else
				{
					$accounts_list = FALSE;
				}
				
				$page_data = array(
					'device_info'		=> $device_info,
					'accounts_list'		=> $accounts_list,
					'servers_list'		=> $servers_list,
					'models_list'		=> $this->settings_model->models_getlist(),
					'device_available'	=> $device_available
				);
			}
			else
			{
				show_404();
			}
		}
		else
		{
			show_404();
		}
		
		$this->title = ' - '.lang('devices_info_pagetitle');
		$this->content = $this->load->view('devices/devices_info', $page_data, TRUE);
		$this->_RenderPage();
	}
	
	public function actions($action=NULL, $param=NULL)
	{
		if ($action == 'add' AND is_null($param))
		{
			// Add new device
			if (!is_null($this->input->post('mac_addr')) AND !is_null($this->input->post('ip_addr')) AND !is_null($this->input->post('model_id')) AND !is_null($this->input->post('status_active')) AND !is_null($this->input->post('fw_version_pinned')))
			{
				$post_data = array(
					'mac_addr'			=> mb_strtolower(htmlspecialchars(trim($this->input->post('mac_addr')))),
					'ip_addr'			=> htmlspecialchars(trim($this->input->post('ip_addr'))),
					'model_id'			=> htmlspecialchars(trim($this->input->post('model_id'))),
					'status_active'		=> htmlspecialchars(trim($this->input->post('status_active'))),
					'fw_version_pinned'	=> htmlspecialchars(trim($this->input->post('fw_version_pinned')))
				);
				if (!is_null($this->input->post('descr'))) { $post_data['descr'] = htmlspecialchars(trim($this->input->post('descr'))); }
				if (!is_null($this->input->post('params_source_data'))) 
				{
					$post_data['params_source_data'] = htmlspecialchars(trim($this->input->post('params_source_data')));
					$params_json_data = $this->grcentral->convert_params_text2json($post_data['params_source_data']);
					
					if ($params_json_data != FALSE)
					{
						$post_data['params_json_data'] = $params_json_data;
					}
					else
					{
						$post_data['params_source_data'] = "";
						$post_data['params_json_data'] = "";
					}
				}
				else
				{
					$post_data['params_source_data'] = "";
					$post_data['params_json_data'] = "";
				}
				
				$query = $this->devices_model->add($post_data);
				
				if ($query != FALSE)
				{
					$this->grcentral->set_cfg_need_apply();
					$this->session->set_flashdata('success_result', lang('devices_index_flashdata_addsuccess'));
				}
				else
				{
					$this->session->set_flashdata('error_result', lang('devices_index_flashdata_adderror'));
				}
				redirect('/devices/');
			}
			else
			{
				show_404(current_url());
			}
		}
		elseif ($action == 'edit' AND !is_null($param) AND is_numeric($param))
		{
			// Edit device
			if (!is_null($this->input->post('mac_addr')) AND !is_null($this->input->post('ip_addr')) AND !is_null($this->input->post('model_id')) AND !is_null($this->input->post('status_active')) AND !is_null($this->input->post('fw_version_pinned')))
			{
				$post_data = array(
					'mac_addr'			=> mb_strtolower(htmlspecialchars(trim($this->input->post('mac_addr')))),
					'ip_addr'			=> htmlspecialchars(trim($this->input->post('ip_addr'))),
					'model_id'			=> htmlspecialchars(trim($this->input->post('model_id'))),
					'status_active'		=> htmlspecialchars(trim($this->input->post('status_active'))),
					'fw_version_pinned'	=> htmlspecialchars(trim($this->input->post('fw_version_pinned')))
				);
				if (!is_null($this->input->post('descr'))) { $post_data['descr'] = htmlspecialchars(trim($this->input->post('descr'))); }
				if (!is_null($this->input->post('params_source_data'))) 
				{
					$post_data['params_source_data'] = htmlspecialchars(trim($this->input->post('params_source_data')));
					$params_json_data = $this->grcentral->convert_params_text2json($post_data['params_source_data']);
					
					if ($params_json_data != FALSE)
					{
						$post_data['params_json_data'] = $params_json_data;
					}
					else
					{
						$post_data['params_source_data'] = "";
						$post_data['params_json_data'] = "";
					}
				}
				else
				{
					$post_data['params_source_data'] = "";
					$post_data['params_json_data'] = "";
				}
				
				$query = $this->devices_model->edit($param, $post_data);
				
				if ($query != FALSE)
				{
					$this->grcentral->set_cfg_need_apply();
					$this->session->set_flashdata('success_result', lang('devices_index_flashdata_editsuccess'));
				}
				else
				{
					$this->session->set_flashdata('error_result', lang('devices_index_flashdata_editerror'));
				}
				if ($this->grcentral->get_local_referer() != FALSE)
				{
					redirect($this->grcentral->get_local_referer());
				}
				else
				{
					redirect('/devices/');
				}
			}
			else
			{
				show_404(current_url());
			}
		}
		elseif ($action == 'del' AND !is_null($param) AND is_numeric($param))
		{
			// Delete device
			$device_info = $this->devices_model->get(array('id'=>$param));
			
			if ($device_info != FALSE)
			{
				$query = $this->devices_model->del($param);
				
				if ($query != FALSE)
				{
					$this->logger_model->clean_logs(array('type'=>'all','unit_id'=>$param));
					
					$this->grcentral->set_cfg_need_apply();
					$this->session->set_flashdata('success_result', lang('devices_index_flashdata_delsuccess'));
				}
				else
				{
					$this->session->set_flashdata('error_result', lang('main_error_db'));
				}
			}
			else
			{
				show_404(current_url());
			}
			redirect('/devices/');
		}
		elseif ($action == 'edit_accounts' AND !is_null($param) AND is_numeric($param))
		{
			// Edit accounts
			// Account #1
			if (!is_null($this->input->post('acc1_active')) AND is_numeric($this->input->post('acc1_active')) AND
				!is_null($this->input->post('acc1_name')) AND is_string($this->input->post('acc1_name')) AND $this->input->post('acc1_name') != "" AND
				!is_null($this->input->post('acc1_voipsrv1')) AND is_numeric($this->input->post('acc1_voipsrv1')) AND
				!is_null($this->input->post('acc1_voipsrv2')) AND is_numeric($this->input->post('acc1_voipsrv2')) AND
				!is_null($this->input->post('acc1_userid')) AND is_string($this->input->post('acc1_userid')) AND $this->input->post('acc1_userid') != "" AND
				!is_null($this->input->post('acc1_authid')) AND is_string($this->input->post('acc1_authid')) AND $this->input->post('acc1_authid') != "" AND
				!is_null($this->input->post('acc1_password')) AND is_string($this->input->post('acc1_password')) AND $this->input->post('acc1_password') != "")
			{
				$accounts_data['1'] = array(
					'active'		=> htmlspecialchars(trim($this->input->post('acc1_active'))),
					'name'			=> htmlspecialchars(trim($this->input->post('acc1_name'))),
					'voipsrv1'		=> htmlspecialchars(trim($this->input->post('acc1_voipsrv1'))),
					'voipsrv2'		=> htmlspecialchars(trim($this->input->post('acc1_voipsrv2'))),
					'userid'		=> htmlspecialchars(trim($this->input->post('acc1_userid'))),
					'authid'		=> htmlspecialchars(trim($this->input->post('acc1_authid'))),
					'password'		=> htmlspecialchars(trim($this->input->post('acc1_password')))
				);
			}
			else
			{
				show_404(current_url());
			}
			// Account #2
			if (!is_null($this->input->post('acc2_active')) AND is_numeric($this->input->post('acc2_active')) AND
				!is_null($this->input->post('acc2_name')) AND is_string($this->input->post('acc2_name')) AND $this->input->post('acc2_name') != "" AND
				!is_null($this->input->post('acc2_voipsrv1')) AND is_numeric($this->input->post('acc2_voipsrv1')) AND
				!is_null($this->input->post('acc2_voipsrv2')) AND is_numeric($this->input->post('acc2_voipsrv2')) AND
				!is_null($this->input->post('acc2_userid')) AND is_string($this->input->post('acc2_userid')) AND $this->input->post('acc2_userid') != "" AND
				!is_null($this->input->post('acc2_authid')) AND is_string($this->input->post('acc2_authid')) AND $this->input->post('acc2_authid') != "" AND
				!is_null($this->input->post('acc2_password')) AND is_string($this->input->post('acc2_password')) AND $this->input->post('acc2_password') != "")
			{
				$accounts_data['2'] = array(
					'active'		=> htmlspecialchars(trim($this->input->post('acc2_active'))),
					'name'			=> htmlspecialchars(trim($this->input->post('acc2_name'))),
					'voipsrv1'		=> htmlspecialchars(trim($this->input->post('acc2_voipsrv1'))),
					'voipsrv2'		=> htmlspecialchars(trim($this->input->post('acc2_voipsrv2'))),
					'userid'		=> htmlspecialchars(trim($this->input->post('acc2_userid'))),
					'authid'		=> htmlspecialchars(trim($this->input->post('acc2_authid'))),
					'password'		=> htmlspecialchars(trim($this->input->post('acc2_password')))
				);
			}
			
			// Account #3
			if (!is_null($this->input->post('acc3_active')) AND is_numeric($this->input->post('acc3_active')) AND
				!is_null($this->input->post('acc3_name')) AND is_string($this->input->post('acc3_name')) AND $this->input->post('acc3_name') != "" AND
				!is_null($this->input->post('acc3_voipsrv1')) AND is_numeric($this->input->post('acc3_voipsrv1')) AND
				!is_null($this->input->post('acc3_voipsrv2')) AND is_numeric($this->input->post('acc3_voipsrv2')) AND
				!is_null($this->input->post('acc3_userid')) AND is_string($this->input->post('acc3_userid')) AND $this->input->post('acc3_userid') != "" AND
				!is_null($this->input->post('acc3_authid')) AND is_string($this->input->post('acc3_authid')) AND $this->input->post('acc3_authid') != "" AND
				!is_null($this->input->post('acc3_password')) AND is_string($this->input->post('acc3_password')) AND $this->input->post('acc3_password') != "")
			{
				$accounts_data['3'] = array(
					'active'		=> htmlspecialchars(trim($this->input->post('acc3_active'))),
					'name'			=> htmlspecialchars(trim($this->input->post('acc3_name'))),
					'voipsrv1'		=> htmlspecialchars(trim($this->input->post('acc3_voipsrv1'))),
					'voipsrv2'		=> htmlspecialchars(trim($this->input->post('acc3_voipsrv2'))),
					'userid'		=> htmlspecialchars(trim($this->input->post('acc3_userid'))),
					'authid'		=> htmlspecialchars(trim($this->input->post('acc3_authid'))),
					'password'		=> htmlspecialchars(trim($this->input->post('acc3_password')))
				);
			}
			
			// Account #4
			if (!is_null($this->input->post('acc4_active')) AND is_numeric($this->input->post('acc4_active')) AND 
				!is_null($this->input->post('acc4_name')) AND is_string($this->input->post('acc4_name')) AND $this->input->post('acc4_name') != "" AND
				!is_null($this->input->post('acc4_voipsrv1')) AND is_numeric($this->input->post('acc4_voipsrv1')) AND
				!is_null($this->input->post('acc4_voipsrv2')) AND is_numeric($this->input->post('acc4_voipsrv2')) AND
				!is_null($this->input->post('acc4_userid')) AND is_string($this->input->post('acc4_userid')) AND $this->input->post('acc4_userid') != "" AND
				!is_null($this->input->post('acc4_authid')) AND is_string($this->input->post('acc4_authid')) AND $this->input->post('acc4_authid') != "" AND
				!is_null($this->input->post('acc4_password')) AND is_string($this->input->post('acc4_password')) AND $this->input->post('acc4_password') != "")
			{
				$accounts_data['4'] = array(
					'active'		=> htmlspecialchars(trim($this->input->post('acc4_active'))),
					'name'			=> htmlspecialchars(trim($this->input->post('acc4_name'))),
					'voipsrv1'		=> htmlspecialchars(trim($this->input->post('acc4_voipsrv1'))),
					'voipsrv2'		=> htmlspecialchars(trim($this->input->post('acc4_voipsrv2'))),
					'userid'		=> htmlspecialchars(trim($this->input->post('acc4_userid'))),
					'authid'		=> htmlspecialchars(trim($this->input->post('acc4_authid'))),
					'password'		=> htmlspecialchars(trim($this->input->post('acc4_password')))
				);
			}
			$accounts_json = json_encode($accounts_data);
			$post_data['accounts_data'] = $accounts_json;
			
			$query = $this->devices_model->edit_accounts($param, $post_data);
				
			if ($query != FALSE)
			{
				$this->grcentral->set_cfg_need_apply();
				$this->session->set_flashdata('success_result', lang('devices_info_flashdata_account_editsuccess'));
			}
			else
			{
				$this->session->set_flashdata('error_result', lang('devices_info_flashdata_account_editerror'));
			}
			redirect('/devices/info/'.$param);
		}
		elseif ($action == 'import_csv' AND is_null($param))
		{
			$post_data = htmlspecialchars(trim($this->input->post('csv_data')));
			if (is_string($post_data))
			{
				$array_data = array_map('trim', explode("\n", $post_data));
				
				if (is_array($array_data) AND count($array_data) > 1)
				{
					$import_devices_data = FALSE;
					
					foreach($array_data as $str_num => $import_data)
					{
						if ($str_num === 0)
						{
							if ($import_data == 'Device Status;Device Model;Device Description;Device IP Address;Device MAC Address;Acc1 status;Acc1 Name;Acc1 UserID;Acc1 AuthID;Acc1 Password;Acc1 VoipSrv1 ID;Acc1 VoipSrv2 ID;Acc2 status;Acc2 Name;Acc2 UserID;Acc2 AuthID;Acc2 Password;Acc2 VoipSrv1 ID;Acc2 VoipSrv2 ID;Acc3 status;Acc3 Name;Acc3 UserID;Acc3 AuthID;Acc3 Password;Acc3 VoipSrv1 ID;Acc3 VoipSrv2 ID;Acc4 status;Acc4 Name;Acc4 UserID;Acc4 AuthID;Acc4 Password;Acc4 VoipSrv1 ID;Acc4 VoipSrv2 ID')
							{
								continue;
							}
							else
							{
								$error_array[] = lang("devices_index_flashdata_import_1ststring_error");
								break;
							}
						}
						else
						{
							$import_array = str_getcsv($import_data,';');
							
							// 0 Device Status
							// 1 Device Model
							// 2 Device Description
							// 3 Device IP Address
							// 4 Device MAC Address
							// 5 Acc1 status
							// 6 Acc1 Name
							// 7 Acc1 UserID
							// 8 Acc1 AuthID
							// 9 Acc1 Password
							// 10 Acc1 VoipSrv1 ID
							// 11 Acc1 VoipSrv2 ID
							// 12 Acc2 status
							// 13 Acc2 Name
							// 14 Acc2 UserID
							// 15 Acc2 AuthID
							// 16 Acc2 Password
							// 17 Acc2 VoipSrv1 ID
							// 18 Acc2 VoipSrv2 ID
							// 19 Acc3 status
							// 20 Acc3 Name
							// 21 Acc3 UserID
							// 22 Acc3 AuthID
							// 23 Acc3 Password
							// 24 Acc3 VoipSrv1 ID
							// 25 Acc3 VoipSrv2 ID
							// 26 Acc4 status
							// 27 Acc4 Name
							// 28 Acc4 UserID
							// 29 Acc4 AuthID
							// 30 Acc4 Password
							// 31 Acc4 VoipSrv1 ID
							// 32 Acc4 VoipSrv2 ID
							
							$model_info = $this->settings_model->models_get(array('tech_name' => $import_array[1]));
							
							if ($model_info != FALSE AND is_array($model_info))
							{
								if ($import_array[5] === '1')
								{
									$accounts_data['1'] = array(
										'active'		=> $import_array[5],
										'name'			=> $import_array[6],
										'voipsrv1'		=> $import_array[10],
										'voipsrv2'		=> $import_array[11],
										'userid'		=> $import_array[7],
										'authid'		=> $import_array[8],
										'password'		=> $import_array[9],
									);
								}
								else
								{
									$error_array[] = lang("devices_index_flashdata_import_1staccdis_error").' '.$str_num;
									break;
								}
								if ($import_array[12] === '1')
								{
									$accounts_data['2'] = array(
										'active'		=> $import_array[12],
										'name'			=> $import_array[13],
										'voipsrv1'		=> $import_array[17],
										'voipsrv2'		=> $import_array[18],
										'userid'		=> $import_array[14],
										'authid'		=> $import_array[15],
										'password'		=> $import_array[16],
									);
								}
								if ($import_array[19] === '1')
								{
									$accounts_data['3'] = array(
										'active'		=> $import_array[19],
										'name'			=> $import_array[20],
										'voipsrv1'		=> $import_array[24],
										'voipsrv2'		=> $import_array[25],
										'userid'		=> $import_array[21],
										'authid'		=> $import_array[22],
										'password'		=> $import_array[23],
									);
								}
								if ($import_array[26] === '1')
								{
									$accounts_data['4'] = array(
										'active'		=> $import_array[26],
										'name'			=> $import_array[27],
										'voipsrv1'		=> $import_array[31],
										'voipsrv2'		=> $import_array[32],
										'userid'		=> $import_array[28],
										'authid'		=> $import_array[29],
										'password'		=> $import_array[30],
									);
								}
								
								if (isset($accounts_data) AND is_array($accounts_data))
								{
									$accounts_json = json_encode($accounts_data);
									
									$import_devices_data[] = array(
										'mac_addr'			=> $import_array[4],
										'ip_addr'			=> $import_array[3],
										'model_id'			=> $model_info['id'],
										'status_active'		=> $import_array[0],
										'descr'				=> $import_array[2],
										'accounts_data'		=> $accounts_json,
									);
								}
								else
								{
									$error_array[] = lang("devices_index_flashdata_import_collectdata_error").' '.$str_num;
									break;
								}
							}
							else
							{
								$error_array[] = lang("devices_index_flashdata_import_model_error").' '.$str_num.' ('.$import_array[1].').';
								break;
							}
						}
					}
				}
				else
				{
					$error_array[] = lang("devices_index_flashdata_import_convert_error");
				}
			}
			else
			{
				$error_array[] = lang("devices_index_flashdata_import_form_error");
			}
			
			if (isset($error_array) AND is_array($error_array))
			{
				$error_text = '<strong>'.lang("devices_index_flashdata_import_title_error").'</strong><ul>';
				foreach($error_array as $error)
				{
					$error_text .= '<li>'.$error.'</li>';
				}
				$error_text .= '</ul>';
				$this->session->set_flashdata('error_result', $error_text);
			}
			
			if (isset($import_devices_data) AND is_array($import_devices_data))
			{
				foreach($import_devices_data as $device)
				{
					$device_info = array(
						'mac_addr'			=> $device['mac_addr'],
						'ip_addr'			=> $device['ip_addr'],
						'model_id'			=> $device['model_id'],
						'status_active'		=> $device['status_active'],
						'descr'				=> $device['descr'],
					);
					$device_id = $this->devices_model->add($device_info);
					
					$acc_info['accounts_data'] = $device['accounts_data'];
					
					if ($device_id != FALSE)
					{
						$this->devices_model->edit_accounts($device_id, $acc_info);
					}
				}
				
				$this->grcentral->set_cfg_need_apply();
				$this->session->set_flashdata('success_result', lang('devices_index_flashdata_import_success').' '.count($import_devices_data));
			}
			redirect('/devices/');
		}
		else
		{
			show_404(current_url());
		}
	}
}
