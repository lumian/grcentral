<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Grcentral {
	
	var $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	public function is_user()
	{
		$logged_in = $this->CI->session->userdata('logged_in');
		
		if ($logged_in == $this->CI->config->item('login', 'auth'))
		{
			return TRUE;
		}
		return FALSE;
	}
	
	// Function for giving files to devices. Change as you like.
	public function forcedownload($file_name=NULL, $file_path=NULL)
	{
		if (file_exists($file_path))
		{
			$this->_download_ci($file_name, $file_path);
			//$this->_download_direct($file_name, $file_path);
		}
		else
		{
			show_404();
		}
	}
	
	private function _download_direct($file_name, $file_path)
	{
		if (ob_get_level()) {
				ob_end_clean();
			}
			
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename=' . basename($file_name));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file_path));

			if ($fd = fopen($file_path, 'rb'))
			{
				while (!feof($fd))
				{
					print fread($fd, 1024);
				}
				fclose($fd);
			}
			exit;
	}
	
	private function _download_ci($file_name, $file_path)
	{
		$this->CI->load->helper('download');
		$data = file_get_contents($file_path);
		force_download($$file_name, $data);
	}
}
