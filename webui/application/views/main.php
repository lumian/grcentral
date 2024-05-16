<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<? if ($this->session->flashdata('success_result')): ?>
<div class="alert alert-success mt-2" role="alert"><?=$this->session->flashdata('success_result');?></div>
<? endif;?>

<? if ($this->session->flashdata('error_result')): ?>
<div class="alert alert-danger mt-2" role="alert"><?=$this->session->flashdata('error_result');?></div>
<? endif;?>

<div class="h-100 p-5 bg-light border rounded-3">
	<h1><?=lang('main_page_title');?></h1>
	<p class="lead"><?=lang('main_page_text');?></p>
	<? if (!$this->grcentral->is_user()):?>
	<small><?=lang('main_page_nonauth_text');?></small>
	<? else: ?>
	<small><?=lang('main_page_auth_text');?></small>
	<? endif;?>
</div>