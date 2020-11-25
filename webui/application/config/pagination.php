<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// 
// Default configs config for GRCentral
//
$config['num_links']		= '5';
$config['use_page_numbers']	= FALSE;
$config['first_tag_open'] 	= '<li class="page-item">';
$config['first_tag_close'] 	= '</li>';
$config['last_tag_open'] 	= '<li class="page-item">';
$config['last_tag_close'] 	= '</li>';
$config['next_tag_open'] 	= '<li class="page-item">';
$config['next_tag_close'] 	= '</li>';
$config['prev_tag_open'] 	= '<li class="page-item">';
$config['prev_tag_close'] 	= '</li>';
$config['cur_tag_open']		= '<li class="page-item active"><a class="page-link" href="#">';
$config['cur_tag_close']	= '</a></li>';
$config['num_tag_open']		= '<li class="page-item">';
$config['num_tag_close']	= '</li>';
$config['attributes']		= array('class' => 'page-link');