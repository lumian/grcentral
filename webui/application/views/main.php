<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<? if ($this->session->flashdata('success_result')): ?>
<div class="alert alert-success mt-2" role="alert"><?=$this->session->flashdata('success_result');?></div>
<? endif;?>

<? if ($this->session->flashdata('error_result')): ?>
<div class="alert alert-danger mt-2" role="alert"><?=$this->session->flashdata('error_result');?></div>
<? endif;?>
<div class="jumbotron">
	<h1><?=lang('main_page_title');?></h1>
	<p class="lead"><?=lang('main_page_text');?></p>
	<? if (!$this->grcentral->is_user()):?>
	<small><?=lang('main_page_nonauth_text');?></small>
	<? else: ?>
	<small><?=lang('main_page_auth_text');?></small>
	<hr class="hr">
	<a href="<?=site_url('devices');?>" type="button" class="btn btn-primary"><i class="fa fa-phone-square-alt"></i> <?=lang('main_page_btn_devices');?></a>
	<a href="<?=site_url('phonebook');?>" type="button" class="btn btn-primary"><i class="fa fa-address-book"></i> <?=lang('main_page_btn_phonebook');?></a>
	<a href="<?=site_url('logs/provisioning');?>" type="button" class="btn btn-primary"><i class="fa fa-list-ul"></i> <?=lang('main_page_btn_logs');?></a>
	<a href="<?=site_url('settings');?>" type="button" class="btn btn-primary"><i class="fa fa-cog"></i> <?=lang('main_page_btn_settings');?></a>
	<? endif;?>
</div>