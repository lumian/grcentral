<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.4
	File:			application\controllers\Settings.php
	Description:	
	
	2020-2024 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

class Settings extends CI_Controller {
	
	private $title = '';
	
	public function __construct()
	{
		parent::__construct();
		
		$this->grcentral->installed_check();
		
		if (!$this->grcentral->is_user())
		{
			redirect(index_page());
		}
		
		$this->lang->load('settings');
	}
	
	private function _RenderPage()
	{
		$template_page_data = array(
			'content'		=> $this->content,
		);
		
		$full_page_data = array(
			'title'			=> $this->config->item('site_title', 'grcentral')." - ".lang('main_menu_settings').$this->title,
			'content'		=> $this->load->view('settings/template', $template_page_data, TRUE),
		);
		
		$this->load->view('template', $full_page_data);
	}
	
	// AJAX functions
	public function ajax($type=NULL, $func=NULL, $param=NULL)
	{
		if (!$this->input->is_ajax_request()) { show_404(current_url()); }
		
		$result_data['result'] = 'error';
		
		// Models ajax query
		if ($type == 'models' AND !is_null($func) AND !is_null($param))
		{
			if ($func == 'get' AND is_numeric($param))
			{
				$query = $this->settings_model->models_get(array('id'=>$param));
				if ($query != FALSE)
				{
					$result_data = array(
						'result'	=> 'success',
						'data'		=> $query
					);
				}
			}
			elseif ($func == 'get_group' AND is_numeric($param))
			{
				$query = $this->settings_model->models_group_get(array('id'=>$param));
				if ($query != FALSE)
				{
					$result_data = array(
						'result'	=> 'success',
						'data'		=> $query
					);
				}
			}
		}
		// Params ajax query
		elseif ($type == 'params' AND !is_null($func) AND !is_null($param))
		{
			if ($func == 'get' AND is_numeric($param))
			{
				$query = $this->settings_model->params_get(array('id'=>$param));
				if ($query != FALSE)
				{
					$result_data = array(
						'result'	=> 'success',
						'data'		=> $query
					);
				}
			}
		}
		// Servers ajax query
		elseif ($type == 'servers' AND !is_null($func) AND !is_null($param))
		{
			if ($func == 'get' AND is_numeric($param))
			{
				$query = $this->settings_model->servers_get(array('id'=>$param));
				if ($query != FALSE)
				{
					$result_data = array(
						'result'	=> 'success',
						'data'		=> $query
					);
				}
			}
		}
		elseif ($type == 'system_update' AND $func == 'check' AND is_null($param))
		{
			$query_data = @file_get_contents($this->config->item('url_version_file', 'update'));
			
			if ($query_data != FALSE)
			{
				$update_data = json_decode($query_data, TRUE);
				$current_version = $this->config->item('version', 'grcentral');
				
				if (!is_null($update_data) AND $update_data != FALSE AND isset($update_data['base']))
				{
					if (isset($update_data['base']) AND isset($update_data['base']['version']))
					{
						$update_settings['checkupdate_last_datetime'] = date('Y-m-d H:i:s');
						$update_settings['checkupdate_version'] = $update_data['base']['version'];
						
						if (isset($update_data['base']['release_date']) AND isset($update_data['base']['release_url']))
						{
							$update_settings['checkupdate_version_info'] = json_encode(array('release_date' => $update_data['base']['release_date'], 'release_url' => $update_data['base']['release_url']));
						}
						else
						{
							$update_settings['checkupdate_version_info'] = '';
						}
					}
					else
					{
						$update_settings['checkupdate_version'] = '';
						$update_settings['checkupdate_version_info'] = '';
					}
					
					if (isset($update_settings['checkupdate_version']) AND $update_settings['checkupdate_version'] != '')
					{
						$compare_version = version_compare($current_version, $update_settings['checkupdate_version']);
						
						if ($compare_version < 0)
						{
							$update_settings['checkupdate_status'] = 'need_update';
						}
						else
						{
							$update_settings['checkupdate_status'] = 'actual';
						}
					}
					
					$this->settings_model->syssettings_update($update_settings);
					
					$result_data = array(
						'result'	=> 'success'
					);
				}
			}
		}
		echo json_encode($result_data);
	}
	
	// Settings index page
	public function index()
	{
		$this->load->model('devices_model');
		
		// Services info:
		$services = array(
			'cfg'			=> array(
				'name'			=> 'Config service',
				'status'		=> $this->settings_model->syssettings_get('cfg_enable_get'),
				'info'			=> "URL: ".parse_url(base_url(), PHP_URL_HOST)."/provisioning/cfg"
			),
			'fw'			=> array(
				'name'			=> 'Firmware update service',
				'status'		=> $this->settings_model->syssettings_get('fw_enable_update'),
				'info'			=> "URL: ".parse_url(base_url(), PHP_URL_HOST)."/provisioning/fw"
			),
			'pb'			=> array(
				'name'			=> 'Phonebook XML Service',
				'status'		=> $this->settings_model->syssettings_get('pb_generate_enable'),
				'info'			=> "URL: ".parse_url(base_url(), PHP_URL_HOST)."/provisioning/pb"
			),
			'monitoring'	=> array(
				'name'			=> 'Monitoring service',
				'status'		=> $this->settings_model->syssettings_get('monitoring_enable'),
				'info'			=> ''
			)
		);
		
		// Monitoring service:
		if ($services['monitoring']['status'] == 'on')
		{
			$devices_list = $this->devices_model->getlist();
			
			if ($devices_list != FALSE AND count($devices_list) > 0)
			{
				$monitoring_count = array(
					'online_device'		=> 0,
					'offline_device'	=> 0,
					'disabled_device'	=> 0
				);
				
				foreach($devices_list as $device)
				{
					if ($device['status_active'] == '1')
					{
						if ($device['status_online'] == '1')
						{
							++$monitoring_count['online_device'];
						}
						else
						{
							++$monitoring_count['offline_device'];
						}
					}
					else
					{
						++$monitoring_count['disabled_device'];
					}
				}
				$services['monitoring']['info'] = "Online: ".$monitoring_count['online_device']." | Offline: ".$monitoring_count['offline_device']." | Disabled: ".$monitoring_count['disabled_device'];
			}
			else
			{
				$services['monitoring']['info'] = "";
			}
		}
		else
		{
			$services['monitoring']['info'] = "";
		}
		
		$updates_last_check = $this->settings_model->syssettings_get('checkupdate_last_datetime');
		
		if ($updates_last_check != FALSE AND !is_null($updates_last_check))
		{
			$update_status = $this->settings_model->syssettings_get('checkupdate_status');
			
			$updates = array(
				'last_check'		=> date('d.m.Y H:i:s', strtotime($updates_last_check)),
				'version_actual'	=> $this->settings_model->syssettings_get('checkupdate_version'),
				'need_update'		=> (($update_status == 'actual') ? FALSE : TRUE)
			);
			
			if ($update_status == 'need_update')
			{
				$version_info = $this->settings_model->syssettings_get('checkupdate_version_info');
				
				if ($version_info != FALSE)
				{
					$updates['version_info'] = json_decode($version_info, TRUE);
				}
			}
		}
		else
		{
			$updates = FALSE;
		}
		
		// Page data
		$page_data = array(
			'services'	=> $services,
			'updates'	=> $updates
		);
		
		$this->content = $this->load->view('settings/main', $page_data, TRUE);
		$this->_RenderPage();
	}
	
	// Device models
	public function models($action=NULL, $param=NULL)
	{
		if (is_null($action) AND is_null($param))
		{
			// List of models
			$models_group = $this->settings_model->models_group_getlist();
			$params_group = $this->settings_model->params_getlist();
			$models_list = FALSE;
			
			if ($models_group != FALSE)
			{
				foreach($models_group as $group)
				{
					$models_list[$group['id']] = array(
						'group_info'	=> $group,
						'items'			=> $this->settings_model->models_getlist(array('group_id'=>$group['id']))
					);
				}
			}
			
			$page_data = array(
				'group_list'	=> $models_group,
				'models_list'	=> $models_list,
				'params_group'	=> $params_group
			);
		}
		elseif ($action == 'add' AND is_null($param))
		{
			// Add new model
			if (!is_null($this->input->post('tech_name')) AND !is_null($this->input->post('friendly_name')) AND !is_null($this->input->post('group_id')))
			{
				$post_data = array(
					'tech_name'					=> htmlspecialchars(trim($this->input->post('tech_name'))),
					'friendly_name'				=> htmlspecialchars(trim($this->input->post('friendly_name'))),
					'group_id'					=> htmlspecialchars(trim($this->input->post('group_id')))
				);
				$query = $this->settings_model->models_add($post_data);
				
				if ($query != FALSE)
				{
					$this->session->set_flashdata('success_result', lang('settings_models_flashdata_addsuccess'));
				}
				else
				{
					$this->session->set_flashdata('error_result', lang('settings_models_flashdata_adderror'));
				}
				redirect('/settings/models');
			}
			else
			{
				show_404(current_url());
			}
		}
		elseif ($action == 'edit' AND is_numeric($param))
		{
			// Edit model
			$model_info = $this->settings_model->models_get(array('id'=>$param));
			
			if ($model_info != FALSE)
			{
				if (!is_null($this->input->post('tech_name')) AND !is_null($this->input->post('friendly_name')) AND !is_null($this->input->post('group_id')))
				{
					$post_data = array(
						'tech_name'			=> htmlspecialchars(trim($this->input->post('tech_name'))),
						'friendly_name'		=> htmlspecialchars(trim($this->input->post('friendly_name'))),
						'group_id'			=> htmlspecialchars(trim($this->input->post('group_id')))
					);
					
					$query = $this->settings_model->models_edit($param, $post_data);
					
					if ($query != FALSE)
					{
						$this->session->set_flashdata('success_result', lang('settings_models_flashdata_editsuccess'));
					}
					else
					{
						$this->session->set_flashdata('error_result', lang('settings_models_flashdata_editerror'));
					}
				}
				else
				{
					show_404(current_url());
				}
			}
			else
			{
				show_404(current_url());
			}
			redirect('/settings/models');
		}
		elseif ($action == 'del' AND is_numeric($param))
		{
			// Delete model
			$model_info = $this->settings_model->models_get(array('id'=>$param));
			
			if ($model_info != FALSE)
			{
				$query = $this->settings_model->models_del($param);
				
				if ($query != FALSE)
				{
					$this->session->set_flashdata('success_result', lang('settings_models_flashdata_delsuccess'));
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
			redirect('/settings/models');
		}
		elseif ($action == 'add_group' AND is_null($param))
		{
			// Add new group
			if (!is_null($this->input->post('name')) AND is_numeric($this->input->post('params_group_id')) AND !is_null($this->input->post('params_conf_acc_atatus'))
				AND !is_null($this->input->post('params_conf_acc_name')) AND !is_null($this->input->post('params_conf_srv_main')) AND !is_null($this->input->post('params_conf_srv_reserve'))
				AND !is_null($this->input->post('params_conf_sip_userid')) AND !is_null($this->input->post('params_conf_sip_authid')) AND !is_null($this->input->post('params_conf_sip_passwd'))
				AND !is_null($this->input->post('params_conf_show_name')) AND !is_null($this->input->post('params_conf_acc_display')) AND !is_null($this->input->post('params_conf_voicemail')))
			{
				$post_data = array(
					'name'						=> htmlspecialchars(trim($this->input->post('name'))),
					'params_group_id'			=> htmlspecialchars(trim($this->input->post('params_group_id'))),
					'params_conf_acc_atatus'	=> htmlspecialchars(trim(str_replace(" ", "", $this->input->post('params_conf_acc_atatus')))),
					'params_conf_acc_name'		=> htmlspecialchars(trim(str_replace(" ", "", $this->input->post('params_conf_acc_name')))),
					'params_conf_srv_main'		=> htmlspecialchars(trim(str_replace(" ", "", $this->input->post('params_conf_srv_main')))),
					'params_conf_srv_reserve'	=> htmlspecialchars(trim(str_replace(" ", "", $this->input->post('params_conf_srv_reserve')))),
					'params_conf_sip_userid'	=> htmlspecialchars(trim(str_replace(" ", "", $this->input->post('params_conf_sip_userid')))),
					'params_conf_sip_authid'	=> htmlspecialchars(trim(str_replace(" ", "", $this->input->post('params_conf_sip_authid')))),
					'params_conf_sip_passwd'	=> htmlspecialchars(trim(str_replace(" ", "", $this->input->post('params_conf_sip_passwd')))),
					'params_conf_show_name'		=> htmlspecialchars(trim(str_replace(" ", "", $this->input->post('params_conf_show_name')))),
					'params_conf_acc_display'	=> htmlspecialchars(trim(str_replace(" ", "", $this->input->post('params_conf_acc_display')))),
					'params_conf_voicemail'		=> htmlspecialchars(trim(str_replace(" ", "", $this->input->post('params_conf_voicemail'))))
				);
				
				$query = $this->settings_model->models_group_add($post_data);
				
				if ($query != FALSE)
				{
					$this->grcentral->set_cfg_need_apply();
					$this->session->set_flashdata('success_result', lang('settings_models_flashdata_addgroupsuccess'));
				}
				else
				{
					$this->session->set_flashdata('error_result', lang('settings_models_flashdata_addgrouperror'));
				}
				redirect('/settings/models');
			}
			else
			{
				show_404(current_url());
			}
		}
		elseif ($action == 'edit_group' AND is_numeric($param))
		{
			// Edit group
			$group_info = $this->settings_model->models_group_get(array('id'=>$param));
			
			if ($group_info != FALSE)
			{
				if (!is_null($this->input->post('name')) AND is_numeric($this->input->post('params_group_id')) AND !is_null($this->input->post('params_conf_acc_atatus'))
					AND !is_null($this->input->post('params_conf_acc_name')) AND !is_null($this->input->post('params_conf_srv_main')) AND !is_null($this->input->post('params_conf_srv_reserve'))
					AND !is_null($this->input->post('params_conf_sip_userid')) AND !is_null($this->input->post('params_conf_sip_authid')) AND !is_null($this->input->post('params_conf_sip_passwd'))
					AND !is_null($this->input->post('params_conf_show_name')) AND !is_null($this->input->post('params_conf_acc_display')) AND !is_null($this->input->post('params_conf_voicemail')))
				{
					$post_data = array(
					'name'						=> htmlspecialchars(trim($this->input->post('name'))),
					'params_group_id'			=> htmlspecialchars(trim($this->input->post('params_group_id'))),
					'params_conf_acc_atatus'	=> htmlspecialchars(trim(str_replace(" ", "", $this->input->post('params_conf_acc_atatus')))),
					'params_conf_acc_name'		=> htmlspecialchars(trim(str_replace(" ", "", $this->input->post('params_conf_acc_name')))),
					'params_conf_srv_main'		=> htmlspecialchars(trim(str_replace(" ", "", $this->input->post('params_conf_srv_main')))),
					'params_conf_srv_reserve'	=> htmlspecialchars(trim(str_replace(" ", "", $this->input->post('params_conf_srv_reserve')))),
					'params_conf_sip_userid'	=> htmlspecialchars(trim(str_replace(" ", "", $this->input->post('params_conf_sip_userid')))),
					'params_conf_sip_authid'	=> htmlspecialchars(trim(str_replace(" ", "", $this->input->post('params_conf_sip_authid')))),
					'params_conf_sip_passwd'	=> htmlspecialchars(trim(str_replace(" ", "", $this->input->post('params_conf_sip_passwd')))),
					'params_conf_show_name'		=> htmlspecialchars(trim(str_replace(" ", "", $this->input->post('params_conf_show_name')))),
					'params_conf_acc_display'	=> htmlspecialchars(trim(str_replace(" ", "", $this->input->post('params_conf_acc_display')))),
					'params_conf_voicemail'		=> htmlspecialchars(trim(str_replace(" ", "", $this->input->post('params_conf_voicemail'))))
				);
					
					$query = $this->settings_model->models_group_edit($param, $post_data);
					
					if ($query != FALSE)
					{
						$this->grcentral->set_cfg_need_apply();
						$this->session->set_flashdata('success_result', lang('settings_models_flashdata_editgroupsuccess'));
					}
					else
					{
						$this->session->set_flashdata('error_result', lang('settings_models_flashdata_editgrouperror'));
					}
				}
				else
				{
					show_404(current_url());
				}
			}
			else
			{
				show_404(current_url());
			}
			redirect('/settings/models');
		}
		elseif ($action == 'del_group' AND is_numeric($param))
		{
			// Delete group
			$group_info = $this->settings_model->models_group_get(array('id'=>$param));
			
			if ($group_info != FALSE)
			{
				$fw_list = $this->settings_model->fw_getlist(array('group_id'=>$group_info['id']));
				$pm_list = $this->settings_model->models_getlist(array('group_id'=>$group_info['id']));
				
				if ($fw_list === FALSE AND $pm_list === FALSE)
				{
					$query = $this->settings_model->models_group_del($param);
					
					if ($query != FALSE)
					{
						$this->grcentral->set_cfg_need_apply();
						$this->session->set_flashdata('success_result', lang('settings_models_flashdata_delgroupsuccess'));
					}
					else
					{
						$this->session->set_flashdata('error_result', lang('main_error_db'));
					}
				}
				else
				{
					$this->session->set_flashdata('error_result', lang('settings_models_flashdata_delgrouperror'));
				}
			}
			else
			{
				show_404(current_url());
			}
			redirect('/settings/models');
		}
		else
		{
			show_404(current_url());
		}
		
		$this->title = " - ".lang('settings_models_pagetitle');
		$this->content = $this->load->view('settings/models/models_list', $page_data, TRUE);
		$this->_RenderPage();
	}
	
	// Firmware
	public function fw($action=NULL, $param=NULL)
	{
		if (is_null($action) AND is_null($param))
		{
			// List of firmware
			$group_list = $this->settings_model->models_group_getlist();
			$fw_list = FALSE;
			
			if ($group_list != FALSE)
			{
				foreach($group_list as $group)
				{
					$fw_list[$group['id']] = array(
						'group_info'	=> $group,
						'items'			=> $this->settings_model->fw_getlist(array('group_id'=>$group['id']))
					);
				}
			}
			
			$page_data = array(
				'group_list'	=> $group_list,
				'fw_list'		=> $fw_list
			);
		}
		elseif ($action == 'add' AND is_null($param))
		{
			// Add new firmware
			
			if (!is_null($this->input->post('version')) AND !is_null($this->input->post('group_id')))
			{
				$upload_config = array(
					'upload_path'		=> $this->config->item('storage_path', 'grcentral').'fw/',
					'allowed_types'		=> 'bin',
					'max_size'			=> $this->grcentral->max_size_upload(),
					'encrypt_name'		=> TRUE
				);
				
				$this->load->library('upload', $upload_config);
				
				if ($this->upload->do_upload('userfile'))
				{
					$upload_data = $this->upload->data();
					
					$post_data = array(
						'version'			=> htmlspecialchars(trim($this->input->post('version'))),
						'group_id'			=> htmlspecialchars(trim($this->input->post('group_id'))),
						'status'			=> '0',
						'file_name'			=> $upload_data['orig_name'],
						'file_name_real'	=> $upload_data['file_name']
					);
					$query = $this->settings_model->fw_add($post_data);
					
					if ($query != FALSE)
					{
						$this->session->set_flashdata('success_result', lang('settings_fw_flashdata_addsuccess'));
					}
				}
				else
				{
					$this->session->set_flashdata('error_result', lang('settings_fw_flashdata_adderror').$this->upload->display_errors());
				}
				redirect('/settings/fw');
			}
			else
			{
				show_404(current_url());
			}
		}
		elseif ($action == 'del' AND is_numeric($param))
		{
			// Delete firmware
			$fw_info = $this->settings_model->fw_get(array('id'=>$param));
			
			if ($fw_info != FALSE)
			{
				$query = $this->settings_model->fw_del($param);
				
				if ($query != FALSE)
				{
					$this->session->set_flashdata('success_result', lang('settings_fw_flashdata_delsuccess'));
					unlink($this->config->item('storage_path', 'grcentral').'fw/'.$fw_info['file_name_real']);
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
			redirect('/settings/fw');
		}
		elseif ($action == 'change_status' AND is_numeric($param))
		{
			// Change FW status
			$fw_info = $this->settings_model->fw_get(array('id'=>$param));
			
			if ($fw_info != FALSE)
			{
				if ($fw_info['status'] == '1')
				{
					$new_status = '0';
				}
				else 
				{
					$new_status = '1';
				}
				$query = $this->settings_model->fw_change_status($fw_info, $new_status);
				
				if ($query != FALSE)
				{
					$this->session->set_flashdata('success_result', lang('settings_fw_flashdata_change_status_success'));
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
			redirect('/settings/fw');
		}
		else
		{
			show_404(current_url());
		}
		
		$this->title = " - ".lang('settings_fw_pagetitle');
		$this->content = $this->load->view('settings/fw/fw_list', $page_data, TRUE);
		$this->_RenderPage();
	}
	
	// Params
	public function params($action=NULL, $param=NULL)
	{
		if (is_null($action) AND is_null($param))
		{
			// List of templates
			$group_list = $this->settings_model->params_getlist();
			$group_list_main = $this->settings_model->params_getlist(array('parent_id','0'));
			
			$page_data = array(
				'group_list'		=> $group_list,
				'group_list_main'	=> $group_list_main
			);
		}
		elseif ($action == 'add' AND is_null($param))
		{
			// Add new template
			if (!is_null($this->input->post('name')) AND !is_null($this->input->post('description')) AND !is_null($this->input->post('params_source_data')))
			{
				$post_data = array(
					'name'					=> htmlspecialchars(trim($this->input->post('name'))),
					'description'			=> htmlspecialchars(trim($this->input->post('description'))),
					'params_source_data'	=> htmlspecialchars(trim($this->input->post('params_source_data')))
				);

				$params_json_data = $this->grcentral->convert_params_text2json($post_data['params_source_data']);
				
				if ($params_json_data != FALSE)
				{
					$post_data['params_json_data'] = $params_json_data;
					
					$query = $this->settings_model->params_add($post_data);
				}
				
				if (isset($query) AND $query != FALSE)
				{
					$this->grcentral->set_cfg_need_apply();
					$this->session->set_flashdata('success_result', lang('settings_params_flashdata_addsuccess'));
				}
				else
				{
					$this->session->set_flashdata('error_result', lang('settings_params_flashdata_adderror'));
				}
				redirect('/settings/params');
			}
			else
			{
				show_404(current_url());
			}
		}
		elseif ($action == 'edit' AND is_numeric($param))
		{
			// Edit template
			$group_info = $this->settings_model->params_get(array('id'=>$param));
			
			if ($group_info != FALSE)
			{
				if (!is_null($this->input->post('name')) AND !is_null($this->input->post('description')) AND !is_null($this->input->post('params_source_data')))
				{
					$post_data = array(
						'name'					=> htmlspecialchars(trim($this->input->post('name'))),
						'description'			=> htmlspecialchars(trim($this->input->post('description'))),
						'params_source_data'	=> htmlspecialchars(trim($this->input->post('params_source_data')))
					);
					
					$params_json_data = $this->grcentral->convert_params_text2json($post_data['params_source_data']);
				
					if ($params_json_data != FALSE)
					{
						$post_data['params_json_data'] = $params_json_data;
						
						$query = $this->settings_model->params_edit($param, $post_data);
					}
					
					if (isset($query) AND $query != FALSE)
					{
						$this->grcentral->set_cfg_need_apply();
						$this->session->set_flashdata('success_result', lang('settings_params_flashdata_editsuccess'));
					}
					else
					{
						$this->session->set_flashdata('error_result', lang('settings_params_flashdata_editerror'));
					}
				}
				else
				{
					show_404(current_url());
				}
			}
			else
			{
				show_404(current_url());
			}
			redirect('/settings/params');
		}
		elseif ($action == 'del' AND is_numeric($param))
		{
			// Delete template
			$group_info = $this->settings_model->params_get(array('id'=>$param));
			
			if ($group_info != FALSE)
			{
				$models_group_list = $this->settings_model->models_group_getlist(array('params_group_id'=>$group_info['id']));
				
				if ($models_group_list === FALSE)
				{
					$query = $this->settings_model->params_del($param);
					
					if ($query != FALSE)
					{
						$this->grcentral->set_cfg_need_apply();
						$this->session->set_flashdata('success_result', lang('settings_params_flashdata_delsuccess'));
					}
					else
					{
						$this->session->set_flashdata('error_result', lang('main_error_db'));
					}
				}
				else
				{
					$this->session->set_flashdata('error_result', lang('settings_params_flashdata_delerror'));
				}
			}
			else
			{
				show_404(current_url());
			}
			redirect('/settings/params');
		}
		else
		{
			show_404(current_url());
		}
		$this->title = " - ".lang('settings_params_pagetitle');
		$this->content = $this->load->view('settings/params/params_list', $page_data, TRUE);
		$this->_RenderPage();
	}
	
	// VoIP servers
	public function servers($action=NULL, $param=NULL)
	{
		if (is_null($action) AND is_null($param))
		{
			// List of servers
			$servers_list = $this->settings_model->servers_getlist();
			
			$page_data = array(
				'servers_list'		=> $servers_list,
			);
		}
		elseif ($action == 'add' AND is_null($param))
		{
			// Add new server
			if (!is_null($this->input->post('name')) AND !is_null($this->input->post('description')) AND !is_null($this->input->post('server')))
			{
				$post_data = array(
					'name'					=> htmlspecialchars(trim($this->input->post('name'))),
					'description'			=> htmlspecialchars(trim($this->input->post('description'))),
					'server'				=> htmlspecialchars(trim($this->input->post('server')))
				);
				
				if (!is_null($this->input->post('voicemail_number')))
				{
					$post_data['voicemail_number'] = htmlspecialchars(trim($this->input->post('voicemail_number')));
				}
				
				$query = $this->settings_model->servers_add($post_data);
				
				if (isset($query) AND $query != FALSE)
				{
					$this->grcentral->set_cfg_need_apply();
					$this->session->set_flashdata('success_result', lang('settings_servers_flashdata_addsuccess'));
				}
				else
				{
					$this->session->set_flashdata('error_result', lang('settings_servers_flashdata_adderror'));
				}
				redirect('/settings/servers');
			}
			else
			{
				show_404(current_url());
			}
		}
		elseif ($action == 'edit' AND is_numeric($param))
		{
			// Edit server
			$server_info = $this->settings_model->servers_get(array('id'=>$param));
			
			if ($server_info != FALSE)
			{
				if (!is_null($this->input->post('name')) AND !is_null($this->input->post('description')) AND !is_null($this->input->post('server')))
				{
					$post_data = array(
						'name'					=> htmlspecialchars(trim($this->input->post('name'))),
						'description'			=> htmlspecialchars(trim($this->input->post('description'))),
						'server'				=> htmlspecialchars(trim($this->input->post('server')))
					);
					
					if (!is_null($this->input->post('voicemail_number')))
					{
						$post_data['voicemail_number'] = htmlspecialchars(trim($this->input->post('voicemail_number')));
					}
					
					$query = $this->settings_model->servers_edit($param, $post_data);
					
					if (isset($query) AND $query != FALSE)
					{
						$this->grcentral->set_cfg_need_apply();
						$this->session->set_flashdata('success_result', lang('settings_servers_flashdata_editsuccess'));
					}
					else
					{
						$this->session->set_flashdata('error_result', lang('settings_servers_flashdata_editerror'));
					}
				}
				else
				{
					show_404(current_url());
				}
			}
			else
			{
				show_404(current_url());
			}
			redirect('/settings/servers');
		}
		elseif ($action == 'del' AND is_numeric($param))
		{
			// Delete server
			$server_info = $this->settings_model->servers_get(array('id'=>$param));
			
			if ($server_info != FALSE)
			{
				$phones_list = FALSE;
				
				if ($phones_list === FALSE)
				{
					$query = $this->settings_model->servers_del($param);
					
					if ($query != FALSE)
					{
						$this->grcentral->set_cfg_need_apply();
						$this->session->set_flashdata('success_result', lang('settings_servers_flashdata_delsuccess'));
					}
					else
					{
						$this->session->set_flashdata('error_result', lang('main_error_db'));
					}
				}
				else
				{
					$this->session->set_flashdata('error_result', lang('settings_servers_flashdata_delerror'));
				}
			}
			else
			{
				show_404(current_url());
			}
			redirect('/settings/servers');
		}
		else
		{
			show_404(current_url());
		}
		$this->title = " - ".lang('settings_servers_pagetitle');
		$this->content = $this->load->view('settings/servers/servers_list', $page_data, TRUE);
		$this->_RenderPage();
	}
	
	// System settings
	public function syssettings($action=NULL, $param=NULL)
	{
		if (is_null($action) AND is_null($param))
		{
			// List of system settings
			$syssettings_list = $this->settings_model->syssettings_getlist();
			
			$page_data = array(
				'syssettings_list'		=> $syssettings_list,
			);
		}
		elseif ($action == 'edit')
		{
			// Edit system settings
			$syssettings_list = $this->settings_model->syssettings_getlist();
			
			// Processing...
			// auto_add_devices
			if (!is_null($this->input->post('auto_add_devices'))) { $settings_data['auto_add_devices'] = 'on'; } else { $settings_data['auto_add_devices'] = 'off'; }
			// fw_update_only_friend
			if (!is_null($this->input->post('fw_update_only_friend'))) { $settings_data['fw_update_only_friend'] = 'on'; } else { $settings_data['fw_update_only_friend'] = 'off'; }
			// pb_generate_enable
			if (!is_null($this->input->post('pb_generate_enable'))) { $settings_data['pb_generate_enable'] = 'on'; } else { $settings_data['pb_generate_enable'] = 'off'; }
			// pb_collect_accounts
			if (!is_null($this->input->post('pb_collect_accounts'))) { $settings_data['pb_collect_accounts'] = 'on'; } else { $settings_data['pb_collect_accounts'] = 'off'; }
			// fw_enable_update
			if (!is_null($this->input->post('fw_enable_update'))) { $settings_data['fw_enable_update'] = 'on'; } else { $settings_data['fw_enable_update'] = 'off'; }
			// cfg_enable_get
			if (!is_null($this->input->post('cfg_enable_get'))) { $settings_data['cfg_enable_get'] = 'on'; } else { $settings_data['cfg_enable_get'] = 'off'; }
			// access_device_by_ip
			if (!is_null($this->input->post('access_device_by_ip'))) { $settings_data['access_device_by_ip'] = 'on'; } else { $settings_data['access_device_by_ip'] = 'off'; }
			// auto_update_ip_addr
			if (!is_null($this->input->post('auto_update_ip_addr'))) { $settings_data['auto_update_ip_addr'] = 'on'; } else { $settings_data['auto_update_ip_addr'] = 'off'; }
			// hide_help_header_msg
			if (!is_null($this->input->post('hide_help_header_msg'))) { $settings_data['hide_help_header_msg'] = 'on'; } else { $settings_data['hide_help_header_msg'] = 'off'; }
			// monitoring_enable
			if (!is_null($this->input->post('monitoring_enable'))) { $settings_data['monitoring_enable'] = 'on'; } else { $settings_data['monitoring_enable'] = 'off'; }
			// api_enable
			if (!is_null($this->input->post('api_enable'))) { $settings_data['api_enable'] = 'on'; } else { $settings_data['api_enable'] = 'off'; }
			
			// DB query for update settings
			$query = $this->settings_model->syssettings_update($settings_data);
			
			if (isset($query) AND $query != FALSE)
			{
				$this->session->set_flashdata('success_result', lang('settings_syssettings_flashdata_editsuccess'));
			}
			else
			{
				$this->session->set_flashdata('error_result', lang('settings_syssettings_flashdata_editerror'));
			}
			redirect('/settings/syssettings');
		}
		elseif ($action == 'reset_settings')
		{
			$result = $this->settings_model->syssettings_default('system');
			if ($result == TRUE)
			{
				$this->session->set_flashdata('success_result', lang('settings_syssettings_flashdata_resetsuccess'));
			}
			else
			{
				$this->session->set_flashdata('success_result', lang('settings_syssettings_flashdata_reseterror'));
			}
			redirect('/settings/syssettings');
		}
		else
		{
			show_404(current_url());
		}
		$this->title = " - ".lang('settings_syssettings_pagetitle');
		$this->content = $this->load->view('settings/syssettings/syssettings_list', $page_data, TRUE);
		$this->_RenderPage();
	}
	
	// Import/Export
	public function importexport($action=NULL, $param=NULL)
	{
		if (!is_null($action) AND $action == 'export_models')
		{
			$model_groups_list = $this->settings_model->models_group_getlist();
			if ($model_groups_list != FALSE AND is_array($model_groups_list))
			{
				$count = 0;
				foreach($model_groups_list as $group)
				{
					$export_data[$count]['group_info'] = array(
						'name'						=> $group['name'],
						'params_conf_acc_atatus'	=> $group['params_conf_acc_atatus'],
						'params_conf_acc_name'		=> $group['params_conf_acc_name'],
						'params_conf_srv_main'		=> $group['params_conf_srv_main'],
						'params_conf_srv_reserve'	=> $group['params_conf_srv_reserve'],
						'params_conf_sip_userid'	=> $group['params_conf_sip_userid'],
						'params_conf_sip_authid'	=> $group['params_conf_sip_authid'],
						'params_conf_sip_passwd'	=> $group['params_conf_sip_passwd'],
						'params_conf_show_name'		=> $group['params_conf_show_name'],
						'params_conf_acc_display'	=> $group['params_conf_show_name'],
						'params_conf_voicemail'		=> $group['params_conf_voicemail']
					);
					
					$models_list = $this->settings_model->models_getlist(['group_id' => $group['id']]);
					if ($models_list != FALSE AND is_array($models_list))
					{
						foreach($models_list as $model)
						{
							$export_data[$count]['group_models'][] = array(
								'tech_name'		=> $model['tech_name'],
								'friendly_name'	=> $model['friendly_name']
							);
						}
					}
					++$count;
				}
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode($export_data, JSON_PRETTY_PRINT))
					->_display();
				exit;
			}
		}
		elseif (!is_null($action) AND $action == 'import_models')
		{
			//
			// Import models data
			//
			if (!is_null($this->input->post('json_data')))
			{
				// get import data from POST
				$import_data = @json_decode($this->input->post('json_data'), TRUE);
				// get params list from DB
				$params_list_db = $this->settings_model->params_getlist();
				// get models group from DB
				$models_group_list_db = $this->settings_model->models_group_getlist();
				
				if (is_array($import_data))
				{
					// Processing the import data
					foreach($import_data as $data)
					{
						// Checking the structure of the array (group info)
						if (isset($data['group_info']) AND is_array($data['group_info']) AND count($data['group_info']) == 11)
						{
							if (isset($data['group_info']['name']) AND isset($data['group_info']['params_conf_acc_atatus']) AND isset($data['group_info']['params_conf_acc_name']) AND isset($data['group_info']['params_conf_srv_main']) AND isset($data['group_info']['params_conf_srv_reserve']) AND isset($data['group_info']['params_conf_sip_userid']) AND isset($data['group_info']['params_conf_sip_authid']) AND isset($data['group_info']['params_conf_sip_passwd']) AND isset($data['group_info']['params_conf_show_name']) AND isset($data['group_info']['params_conf_acc_display']) AND isset($data['group_info']['params_conf_voicemail']))
							{
								$group_info = $data['group_info'];
							}
							else
							{
								$this->session->set_flashdata('error_result', lang("settings_importexport_flashdata_error_dataformatgroup"));
								break;
							}
						}
						else
						{
							$this->session->set_flashdata('error_result', lang("settings_importexport_flashdata_error_dataformatgroup"));
							break;
						}
						
						// Checking the structure of the array (device models in the group)
						if (isset($data['group_models']) AND is_array($data['group_models']))
						{
							foreach($data['group_models'] as $model)
							{
								if (is_array($model) AND count($model) == 2 AND isset($model['tech_name']) AND isset($model['friendly_name']))
								{
									$models_info[] = $model;
								}
								else
								{
									$this->session->set_flashdata('error_result', lang("settings_importexport_flashdata_error_dataformatmodel"));
									break;
								}
							}
						}
						else
						{
							$this->session->set_flashdata('error_result', lang("settings_importexport_flashdata_error_dataformatmodel"));
							break;
						}
						
						// We form a dummy template for the parameters, or we cling to an existing one in the database (we search by name)
						if (isset($group_info) AND isset($models_info))
						{
							// We are looking for a template of parameters in the current database
							if ($params_list_db != FALSE AND is_array($params_list_db))
							{
								foreach($params_list_db as $params_db)
								{
									if ($params_db['name'] == $group_info['name'])
									{
										$params_id = $params_db['id'];
										break;
									}
								}
							}
							
							// If you couldn't find a template, then create a dummy template.
							if (!isset($params_id))
							{
								$params_template = array(
									'name'					=> $group_info['name'],
									'description'			=> 'Autocreated template for '.$group_info['name'],
									'params_source_data'	=> '# This template is created automatically during the import of settings. Please fill it out according to your wishes.',
									'params_json_data'		=> '[]'
								);
								
								
								$params_id = $this->settings_model->params_add($params_template);
								if ($params_id === FALSE)
								{
									$this->session->set_flashdata('error_result', lang("settings_importexport_flashdata_error_dbparams").' ('.$group_info['name'].')');
									break;
								}
								else
								{
									$result_add_params[] = $params_template['name'];
								}
							}
							
							if ($params_id !== FALSE)
							{
								// We have decided on the parameters. We are checking the device group.
								if ($models_group_list_db != FALSE AND is_array($models_group_list_db))
								{
									foreach($models_group_list_db as $model_group_db)
									{
										if ($model_group_db['name'] == $group_info['name'])
										{
											$group_id == $model_group_db['id'];
											break;
										}
									}
								}
								if (!isset($group_id))
								{
									$group_info['params_group_id'] = $params_id;
									$group_id = $this->settings_model->models_group_add($group_info);
									
									if ($group_id === FALSE)
									{
										$this->session->set_flashdata('error_result', lang("settings_importexport_flashdata_error_dbgroups").' ('.$group_info['name'].')');
										break;
									}
									else
									{
										$result_add_groups[] = $group_info['name'];
									}
								}
							}
							
							if ($group_id !== FALSE)
							{
								// We have decided on a group. We check the device models.
								foreach($models_info as $model)
								{
									$model_db = $this->settings_model->models_get(['tech_name'=>$model['tech_name']]);
									if ($model_db === FALSE)
									{
										$model['group_id'] = $group_id;
										$model_id = $this->settings_model->models_add($model);
										if ($model_id === FALSE)
										{
											$this->session->set_flashdata('error_result', lang("settings_importexport_flashdata_error_dbmodel").' ('.$model['tech_name'].')');
											break;
										}
										else
										{
											$result_add_models[] = $model['tech_name'];
										}
									}
								}
								
							}
						}
						unset($data, $group_info, $models_info, $model, $params_db, $params_id, $params_template, $model_group_db, $group_id, $model_db);
					}
					
					if (isset($result_add_params) OR isset($result_add_groups) OR isset($result_add_models))
					{
						$result = '<ul>';
						if (is_array($result_add_params))
						{
							$result .= '<li>'.lang("settings_importexport_flashdata_result_addparams").':';
							foreach($result_add_params as $add_param)
							{
								$result .= ' '.$add_param;
							}
							$result .= '</li>';
						}
						if (is_array($result_add_groups))
						{
							$result .= '<li>'.lang("settings_importexport_flashdata_result_addgroups").':';
							foreach($result_add_groups as $add_group)
							{
								$result .= ' '.$add_group;
							}
							$result .= '</li>';
						}
						if (is_array($result_add_models))
						{
							$result .= '<li>'.lang("settings_importexport_flashdata_result_addmodels").':';
							foreach($result_add_models as $add_model)
							{
								$result .= ' '.$add_model;
							}
							$result .= '</li>';
						}
						$result .= '</ul>';
						$this->session->set_flashdata('success_result', lang("settings_importexport_flashdata_success").$result);
					}
				}
				else
				{
					$this->session->set_flashdata('error_result', lang("settings_importexport_flashdata_error_jsonformat"));
				}
			}
			redirect('/settings/importexport');
		}
		else
		{
			$this->title = " - ".lang('settings_importexport_pagetitle');
			$this->content = $this->load->view('settings/importexport/importexport', NULL, TRUE);
			$this->_RenderPage();
		}
	}
}
