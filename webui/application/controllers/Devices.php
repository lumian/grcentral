<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.2
	File:			application\controllers\Devices.php
	Description:	Controller for devices management
	
	2020 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

class Devices extends CI_Controller {
	
	private $title = '';
	
	public function __construct()
	{
		parent::__construct();
		
		if (!$this->grcentral->is_user())
		{
			redirect(index_page());
		}
		
		$this->lang->load('devices');
		$this->load->model('devices_model');
		$this->load->model('settings_model');
		$this->load->model('tempdata_model');
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
			
			if ($device_info != FALSE)
			{
				$servers_list = $this->settings_model->servers_getlist();
				$device_info['model_info'] = $this->settings_model->models_get(array('id'=>$device_info['model_id']));
				
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
				
				$query = $this->devices_model->add($post_data);
				
				if ($query != FALSE)
				{
					$this->tempdata_model->put_value('settings_need_apply', '1');
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
				
				$query = $this->devices_model->edit($param, $post_data);
				
				if ($query != FALSE)
				{
					$this->tempdata_model->put_value('settings_need_apply', '1');
					$this->session->set_flashdata('success_result', lang('devices_index_flashdata_editsuccess'));
				}
				else
				{
					$this->session->set_flashdata('error_result', lang('devices_index_flashdata_editerror'));
				}
				redirect('/devices');
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
					$this->tempdata_model->put_value('settings_need_apply', '1');
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
				$this->tempdata_model->put_value('settings_need_apply', '1');
				$this->session->set_flashdata('success_result', lang('devices_info_flashdata_account_editsuccess'));
			}
			else
			{
				$this->session->set_flashdata('error_result', lang('devices_info_flashdata_account_editerror'));
			}
			redirect('/devices/info/'.$param);
		}
		else
		{
			show_404(current_url());
		}
	}
}
