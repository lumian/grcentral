<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/****************************************************************
	GRCentral v0.3
	File:			application\controllers\Phonebook.php
	Description:	Controller for phonebook management
	
	2021 (c) Copyright GRCentral
	Get this on Github: http://github.com/lumian/grcentral
****************************************************************/

class Phonebook extends CI_Controller {
	
	private $title = '';
	
	public function __construct()
	{
		parent::__construct();
		
		$this->grcentral->installed_check();
		$this->load->database();
		
		if (!$this->grcentral->is_user())
		{
			redirect(index_page());
		}
		
		$this->lang->load('phonebook');
		$this->load->model('phonebook_model');
	}
	
	private function _RenderPage()
	{
		$template_page_data = array(
			'content'		=> $this->content,
		);
		
		$full_page_data = array(
			'title'			=> $this->config->item('site_title', 'grcentral')." - ".lang('main_menu_phonebook').$this->title,
			'content'		=> $this->load->view('phonebook/template', $template_page_data, TRUE),
		);
		
		$this->load->view('template', $full_page_data);
	}
	
	// AJAX functions
	public function ajax($func=NULL, $param=NULL)
	{
		if (!$this->input->is_ajax_request()) { show_404(current_url()); }
		$result_data['result'] = 'error';
		
		if (!is_null($func) AND !is_null($param))
		{
			// Get info about abonent
			if ($func == 'abonent_get' AND is_numeric($param))
			{
				$query = $this->phonebook_model->abonent_get(array('id'=>$param));
				
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
	
	// Controller index page
	public function index()
	{
		$abonents_list = $this->phonebook_model->abonents_getlist();
		
		$page_data = array(
			'abonents_list'		=> $abonents_list,
		);
		
		$this->content = $this->load->view('phonebook/abonents_list', $page_data, TRUE);
		$this->_RenderPage();
	}
	
	public function actions($action=NULL, $param=NULL)
	{
		if ($action == 'add_abonent' AND is_null($param))
		{
			// Add new abonent
			if (!is_null($this->input->post('first_name')) AND !is_null($this->input->post('last_name')) AND !is_null($this->input->post('phone_work')) AND !is_null($this->input->post('status')))
			{
				$phone_work = htmlspecialchars(trim($this->input->post('phone_work')));
				$check_abonent = $this->phonebook_model->abonent_get(array('phone_work'=>$phone_work));
				
				if ($check_abonent === FALSE)
				{
					$post_data = array(
						'first_name'		=> htmlspecialchars(trim($this->input->post('first_name'))),
						'last_name'			=> htmlspecialchars(trim($this->input->post('last_name'))),
						'phone_work'		=> $phone_work,
						'status'			=> htmlspecialchars(trim($this->input->post('status'))),
						'data_source'		=> 'manual'
					);
					
					$query = $this->phonebook_model->abonent_add($post_data);
					if ($query != FALSE)
					{
						$this->session->set_flashdata('success_result', lang('phonebook_abonents_flashdata_addabonent_success'));
					}
					else
					{
						$this->session->set_flashdata('error_result', lang('phonebook_abonents_flashdata_addabonent_error'));
					}
				}
				else
				{
					$this->session->set_flashdata('error_result', lang('phonebook_abonents_flashdata_addabonent_error').' '.lang('phonebook_abonents_flashdata_addabonent_error_phoneuse'));
				}
				
				redirect('/phonebook/');
			}
			else
			{
				show_404(current_url());
			}
		}
		elseif ($action == 'edit_abonent' AND !is_null($param) AND is_numeric($param))
		{
			// Edit abonent
			if (!is_null($this->input->post('first_name')) AND !is_null($this->input->post('last_name')) AND !is_null($this->input->post('phone_work')) AND !is_null($this->input->post('status')))
			{
				$abonent_info = $this->phonebook_model->abonent_get(array('id'=>$param));
				
				if ($abonent_info != FALSE)
				{
					$post_data = array(
						'first_name'		=> htmlspecialchars(trim($this->input->post('first_name'))),
						'last_name'			=> htmlspecialchars(trim($this->input->post('last_name'))),
						'phone_work'		=> htmlspecialchars(trim($this->input->post('phone_work'))),
						'status'			=> htmlspecialchars(trim($this->input->post('status'))),
						'data_source'		=> 'manual'
					);
					
					$query = $this->phonebook_model->abonent_edit($param, $post_data);
					
					if ($query != FALSE)
					{
						$this->session->set_flashdata('success_result', lang('phonebook_abonents_flashdata_editabonent_success'));
					}
					else
					{
						$this->session->set_flashdata('error_result', lang('phonebook_abonents_flashdata_editabonent_error'));
					}
					redirect('/phonebook/');
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
		}
		elseif ($action == 'del_abonent' AND !is_null($param) AND is_numeric($param))
		{
			// Delete abonent
			$abonent_info = $this->phonebook_model->abonent_get(array('id'=>$param));
			
			if ($abonent_info != FALSE)
			{
				$query = $this->phonebook_model->abonent_del($param);
				
				if ($query != FALSE)
				{
					$this->session->set_flashdata('success_result', lang('phonebook_abonents_flashdata_delabonent_success'));
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
			redirect('/phonebook/');
		}
		elseif ($action == 'abonent_changestatus' AND !is_null($param) AND is_numeric($param))
		{
			// Abonent: Change status
			$abonent_info = $this->phonebook_model->abonent_get(array('id'=>$param));
			
			if ($abonent_info != FALSE)
			{
				if ($abonent_info['status'] == '1')
				{
					$new_status = '0';
				}
				else 
				{
					$new_status = '1';
				}
				$query = $this->phonebook_model->abonent_change_status($param, $new_status);
				
				if ($query != FALSE)
				{
					$this->session->set_flashdata('success_result', lang('phonebook_abonents_flashdata_changestatus_success'));
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
			redirect('/phonebook/');
		}
		elseif ($action == 'abonent_transformsource' AND !is_null($param) AND is_numeric($param))
		{
			// Abonent: Transform source: accounts to manual
			$abonent_info = $this->phonebook_model->abonent_get(array('id'=>$param));
			
			if ($abonent_info != FALSE)
			{
				$query = $this->phonebook_model->abonent_transform_source($param, 'manual');
				
				if ($query != FALSE)
				{
					$this->session->set_flashdata('success_result', lang('phonebook_abonents_flashdata_transformsource_success'));
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
			redirect('/phonebook/');
		}
		else
		{
			
			show_404(current_url());
		}
	}
}
