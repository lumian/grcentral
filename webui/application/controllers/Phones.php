<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Phones extends CI_Controller {
	
	private $title = '';
	
	public function __construct()
	{
		parent::__construct();
		
		$this->lang->load('phones');
		$this->load->model('phones_model');
		$this->load->model('settings_model');
	}
	
	private function _RenderPage()
	{
		$template_page_data = array(
			'content'		=> $this->content,
		);
		
		$full_page_data = array(
			'title'			=> $this->config->item('site_title', 'grcentral')." - ".lang('main_menu_phones').$this->title,
			'content'		=> $this->load->view('phones/template', $template_page_data, TRUE),
		);
		
		$this->load->view('template', $full_page_data);
	}
	
	// AJAX functions
	public function ajax($func=NULL, $param=NULL)
	{
		if (!$this->input->is_ajax_request()) { show_404(current_url()); }
		$result_data['result'] = 'error';
		
		// Phones ajax query
		if (!is_null($func) AND !is_null($param))
		{
			if ($func == 'get' AND is_numeric($param))
			{
				$query = $this->phones_model->get(array('id'=>$param));
				
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
				$query = $this->phones_model->get(array('id'=>$param));
				
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
				
			}
		}
		echo json_encode($result_data);
	}
	
	// Controller index page
	public function index()
	{
		$phones_list = $this->phones_model->getlist();
		$models_list = $this->settings_model->models_getlist();
		
		$page_data = array(
			'phones_list'		=> $phones_list,
			'models_list'		=> $models_list
		);
		$this->title = '- '.lang('phones_title');
		$this->content = $this->load->view('phones/phones_list', $page_data, TRUE);
		$this->_RenderPage();
	}
	
	public function info($param=NULL)
	{
		if (!is_null($param) AND is_numeric($param))
		{
			$phone_info = $this->phones_model->get(array('id' => $param));
			
			if ($phone_info != FALSE)
			{
				$servers_list = $this->settings_model->servers_getlist();
				$phone_info['model_info'] = $this->settings_model->models_get(array('id'=>$phone_info['model_id']));
				
				// accounts:
				if ($phone_info['accounts_data'] != NULL)
				{
					$accounts_list = json_decode($phone_info['accounts_data'], TRUE);
				}
				else
				{
					$accounts_list = FALSE;
				}
				
				$page_data = array(
					'phone_info'		=> $phone_info,
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
		
		$this->title = '- '.lang('phones_info_title');
		$this->content = $this->load->view('phones/phones_info', $page_data, TRUE);
		$this->_RenderPage();
	}
	
	public function actions($action=NULL, $param=NULL)
	{
		if ($action == 'add' AND is_null($param))
		{
			// Add new phone
			if (!is_null($this->input->post('mac_addr')) AND !is_null($this->input->post('ip_addr')) AND !is_null($this->input->post('model_id')) AND !is_null($this->input->post('status_active')))
			{
				$post_data = array(
					'mac_addr'		=> mb_strtolower(htmlspecialchars(trim($this->input->post('mac_addr')))),
					'ip_addr'		=> htmlspecialchars(trim($this->input->post('ip_addr'))),
					'model_id'		=> htmlspecialchars(trim($this->input->post('model_id'))),
					'status_active'	=> htmlspecialchars(trim($this->input->post('status_active')))
				);
				if (!is_null($this->input->post('descr'))) { $post_data['descr'] = htmlspecialchars(trim($this->input->post('descr'))); }
				
				$query = $this->phones_model->add($post_data);
				
				if ($query != FALSE)
				{
					$this->session->set_flashdata('success_result', lang('phones_flashdata_addsuccess'));
				}
				else
				{
					$this->session->set_flashdata('error_result', lang('phones_flashdata_adderror'));
				}
				redirect('/phones/');
			}
			else
			{
				show_404(current_url());
			}
		}
		elseif ($action == 'edit' AND !is_null($param) AND is_numeric($param))
		{
			// Edit phone
			if (!is_null($this->input->post('mac_addr')) AND !is_null($this->input->post('ip_addr')) AND !is_null($this->input->post('model_id')) AND !is_null($this->input->post('status_active')))
			{
				$post_data = array(
					'mac_addr'		=> mb_strtolower(htmlspecialchars(trim($this->input->post('mac_addr')))),
					'ip_addr'		=> htmlspecialchars(trim($this->input->post('ip_addr'))),
					'model_id'		=> htmlspecialchars(trim($this->input->post('model_id'))),
					'status_active'	=> htmlspecialchars(trim($this->input->post('status_active')))
				);
				if (!is_null($this->input->post('descr'))) { $post_data['descr'] = htmlspecialchars(trim($this->input->post('descr'))); }
				
				$query = $this->phones_model->edit($param, $post_data);
				
				if ($query != FALSE)
				{
					$this->session->set_flashdata('success_result', lang('phones_flashdata_editsuccess'));
				}
				else
				{
					$this->session->set_flashdata('error_result', lang('phones_flashdata_editerror'));
				}
				redirect('/phones/');
			}
			else
			{
				show_404(current_url());
			}
		}
		elseif ($action == 'del' AND !is_null($param) AND is_numeric($param))
		{
			// Delete phone
			$phone_info = $this->phones_model->get(array('id'=>$param));
			
			if ($phone_info != FALSE)
			{
				$query = $this->phones_model->del($param);
				
				if ($query != FALSE)
				{
					$this->session->set_flashdata('success_result', lang('phones_flashdata_delsuccess'));
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
			redirect('/phones/');
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
			
			$query = $this->phones_model->edit_accounts($param, $post_data);
				
			if ($query != FALSE)
			{
				$this->session->set_flashdata('success_result', lang('phones_flashdata_account_editsuccess'));
			}
			else
			{
				$this->session->set_flashdata('error_result', lang('phones_flashdata_account_editerror'));
			}
			redirect('/phones/info/'.$param);
		}
		else
		{
			show_404(current_url());
		}
	}
}
