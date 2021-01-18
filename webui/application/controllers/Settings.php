<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.3
	File:			application\controllers\Settings.php
	Description:	
	
	2020 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

class Settings extends CI_Controller {
	
	private $title = '';
	
	public function __construct()
	{
		parent::__construct();
		
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
		echo json_encode($result_data);
	}
	
	// Settings index page
	public function index()
	{
		$page_data = array(
			'modules_status'	=> array(
				'fw_enable_update'		=> $this->settings_model->syssettings_get('fw_enable_update'),
				'cfg_enable_get'		=> $this->settings_model->syssettings_get('cfg_enable_get'),
				'pb_generate_enable'	=> $this->settings_model->syssettings_get('pb_generate_enable')
			)
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
			if (!is_null($this->input->post('version')) AND !is_null($this->input->post('group_id')) AND !is_null($this->input->post('previous_version')) AND !is_null($this->input->post('status')) AND is_numeric($this->input->post('status')))
			{
				$upload_config = array(
					'upload_path'		=> $this->config->item('storage_path', 'grcentral').'fw/',
					'allowed_types'		=> 'bin',
					'encrypt_name'		=> TRUE
				);
				
				$this->load->library('upload', $upload_config);
				
				if ($this->upload->do_upload('userfile'))
				{
					$upload_data = $this->upload->data();
					
					$post_data = array(
						'version'			=> htmlspecialchars(trim($this->input->post('version'))),
						'previous_version'	=> htmlspecialchars(trim($this->input->post('previous_version'))),
						'group_id'			=> htmlspecialchars(trim($this->input->post('group_id'))),
						'status'			=> htmlspecialchars(trim($this->input->post('status'))),
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
					$this->session->set_flashdata('error_result', lang('settings_fw_flashdata_addsuccess').$this->upload->display_errors());
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
				$query = $this->settings_model->fw_change_status($param, $new_status);
				
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
		else
		{
			show_404(current_url());
		}
		$this->title = " - ".lang('settings_syssettings_pagetitle');
		$this->content = $this->load->view('settings/syssettings/syssettings_list', $page_data, TRUE);
		$this->_RenderPage();
	}
}
