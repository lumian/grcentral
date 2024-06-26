<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<? if ($this->settings_model->syssettings_get('hide_help_header_msg') != 'on'): ?>
<div class="card mt-2 shadow-sm">
  <div class="card-body">
    <?=lang('settings_syssettings_description_text');?>
  </div>
</div>
<? endif; ?>

<div class="btn-group btn-group-sm mt-2" role="group">
	<button type="submit" class="btn btn-outline-success" form="SettingsForm"><?=lang('main_btn_save');?></button>
	<button type="submit" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#ModalDefaultSettings"><?=lang('settings_syssettings_btn_reset_settings');?></button>
	<a href="<?=lang('main_helpurl_settings_system');?>" target="_blank" title="<?=lang('main_helpurl_urltitle');?>" type="button" class="btn btn-outline-secondary"><i class="fa fa-question-circle"></i></a>
</div>

<? if ($this->session->flashdata('success_result')): ?>
<div class="alert alert-success mt-2 shadow-sm" role="alert"><?=$this->session->flashdata('success_result');?></div>
<? endif;?>

<? if ($this->session->flashdata('error_result')): ?>
<div class="alert alert-danger mt-2 shadow-sm" role="alert"><?=$this->session->flashdata('error_result');?></div>
<? endif;?>

<form id="SettingsForm" method="post" action="<?=site_url('settings/syssettings/edit');?>">
<table class="table table-bordered table-sm mt-2">
	<thead>
		<tr>
			<th><?=lang('settings_syssettings_table_title_setting');?></th>
			<th style="width:10%"><?=lang('settings_syssettings_table_title_status');?></th>
		</tr>
	</thead>
	<tbody>
		<!-- General settings -->
		<tr>
			<th colspan="2"><?=lang('settings_syssettings_title_general');?></th>
		</tr>
		<tr>
			<td>
				<?=lang('settings_syssettings_access_device_by_ip_name');?></br>
				<small class="text-muted"><?=lang('settings_syssettings_access_device_by_ip_help');?></small>
			</td>
			<td>
				<? if ($syssettings_list['access_device_by_ip'] == 'on') { $access_device_by_ip = 'checked'; } else { $access_device_by_ip = ''; }?>
				<div class="form-check form-switch">
					<input class="form-check-input" type="checkbox" role="switch" name="access_device_by_ip" id="access_device_by_ip" <?=$access_device_by_ip;?>>
					<label class="custom-control-label" for="access_device_by_ip"></label>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<?=lang('settings_syssettings_auto_update_ip_addr_name');?></br>
				<small class="text-muted"><?=lang('settings_syssettings_auto_update_ip_addr_help');?></small>
			</td>
			<td>
				<? if ($syssettings_list['auto_update_ip_addr'] == 'on') { $auto_update_ip_addr = 'checked'; } else { $auto_update_ip_addr = ''; }?>
				<div class="form-check form-switch">
					<input class="form-check-input" type="checkbox" role="switch" name="auto_update_ip_addr" id="auto_update_ip_addr" <?=$auto_update_ip_addr;?>>
					<label class="custom-control-label" for="auto_update_ip_addr"></label>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<?=lang('settings_syssettings_hide_help_header_msg_name');?></br>
				<small class="text-muted"><?=lang('settings_syssettings_hide_help_header_msg_help');?></small>
			</td>
			<td>
				<? if ($syssettings_list['hide_help_header_msg'] == 'on') { $hide_help_header_msg = 'checked'; } else { $hide_help_header_msg = ''; }?>
				<div class="form-check form-switch">
					<input class="form-check-input" type="checkbox" role="switch" name="hide_help_header_msg" id="hide_help_header_msg" <?=$hide_help_header_msg;?>>
					<label class="custom-control-label" for="hide_help_header_msg"></label>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<?=lang('settings_syssettings_monitoring_enable_name');?></br>
				<small class="text-muted"><?=lang('settings_syssettings_monitoring_enable_help');?></small>
			</td>
			<td>
				<? if ($syssettings_list['monitoring_enable'] == 'on') { $monitoring_enable = 'checked'; } else { $monitoring_enable = ''; }?>
				<div class="form-check form-switch">
					<input class="form-check-input" type="checkbox" role="switch" name="monitoring_enable" id="monitoring_enable" <?=$monitoring_enable;?>>
					<label class="custom-control-label" for="monitoring_enable"></label>
				</div>
			</td>
		</tr>
		<!-- Config server -->
		<tr>
			<th colspan="2"><?=lang('settings_syssettings_title_cfg_server');?></th>
		</tr>
		<tr>
			<td>
				<?=lang('settings_syssettings_cfg_enable_get_name');?></br>
				<small class="text-muted"><?=lang('settings_syssettings_cfg_enable_get_help');?></small>
			</td>
			<td>
				<? if ($syssettings_list['cfg_enable_get'] == 'on') { $cfg_enable_get = 'checked'; } else { $cfg_enable_get = ''; }?>
				<div class="form-check form-switch">
					<input class="form-check-input" type="checkbox" role="switch" name="cfg_enable_get" id="cfg_enable_get" <?=$cfg_enable_get;?>>
					<label class="custom-control-label" for="cfg_enable_get"></label>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<?=lang('settings_syssettings_auto_add_devices_name');?></br>
				<small class="text-muted"><?=lang('settings_syssettings_auto_add_devices_help');?></small>
			</td>
			<td>
				<? if ($syssettings_list['auto_add_devices'] == 'on') { $auto_add_devices = 'checked'; } else { $auto_add_devices = ''; }?>
				<div class="form-check form-switch">
					<input class="form-check-input" type="checkbox" role="switch" name="auto_add_devices" id="auto_add_devices" <?=$auto_add_devices;?>>
					<label class="custom-control-label" for="auto_add_devices"></label>
				</div>
			</td>
		</tr>
		<!-- Firmware server -->
		<tr>
			<th colspan="2"><?=lang('settings_syssettings_title_fw_server');?></th>
		</tr>
		<tr>
			<td>
				<?=lang('settings_syssettings_fw_enable_update_name');?></br>
				<small class="text-muted"><?=lang('settings_syssettings_fw_enable_update_help');?></small>
			</td>
			<td>
				<? if ($syssettings_list['fw_enable_update'] == 'on') { $fw_enable_update = 'checked'; } else { $fw_enable_update = ''; }?>
				<div class="form-check form-switch">
					<input class="form-check-input" type="checkbox" role="switch" name="fw_enable_update" id="fw_enable_update" <?=$fw_enable_update;?>>
					<label class="custom-control-label" for="fw_enable_update"></label>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<?=lang('settings_syssettings_fw_update_only_friend_name');?></br>
				<small class="text-muted"><?=lang('settings_syssettings_fw_update_only_friend_help');?></small>
			</td>
			<td>
				<? if ($syssettings_list['fw_update_only_friend'] == 'on') { $fw_update_only_friend = 'checked'; } else { $fw_update_only_friend = ''; }?>
				<div class="form-check form-switch">
					<input class="form-check-input" type="checkbox" role="switch" name="fw_update_only_friend" id="fw_update_only_friend" <?=$fw_update_only_friend;?>>
					<label class="custom-control-label" for="fw_update_only_friend"></label>
				</div>
			</td>
		</tr>
		<!-- Phonebook server -->
		<tr>
			<th colspan="2"><?=lang('settings_syssettings_title_pb_server');?></th>
		</tr>
		<tr>
			<td>
				<?=lang('settings_syssettings_pb_generate_enable_name');?></br>
				<small class="text-muted"><?=lang('settings_syssettings_pb_generate_enable_help');?></small>
			</td>
			<td>
				<? if ($syssettings_list['pb_generate_enable'] == 'on') { $pb_generate_enable = 'checked'; } else { $pb_generate_enable = ''; }?>
				<div class="form-check form-switch">
					<input class="form-check-input" type="checkbox" role="switch" name="pb_generate_enable" id="pb_generate_enable" <?=$pb_generate_enable;?>>
					<label class="custom-control-label" for="pb_generate_enable"></label>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<?=lang('settings_syssettings_pb_collect_accounts_name');?></br>
				<small class="text-muted"><?=lang('settings_syssettings_pb_collect_accounts_help');?></small>
			</td>
			<td>
				<? if ($syssettings_list['pb_collect_accounts'] == 'on') { $pb_collect_accounts = 'checked'; } else { $pb_collect_accounts = ''; }?>
				<div class="form-check form-switch">
					<input class="form-check-input" type="checkbox" role="switch" name="pb_collect_accounts" id="pb_collect_accounts" <?=$pb_collect_accounts;?>>
					<label class="custom-control-label" for="pb_collect_accounts"></label>
				</div>
			</td>
		</tr>
		<!-- API settings -->
		<tr>
			<th colspan="2"><?=lang('settings_syssettings_title_api');?></th>
		</tr>
		<tr>
			<td>
				<?=lang('settings_syssettings_api_enable_name');?></br>
				<small class="text-muted"><?=lang('settings_syssettings_api_enable_help');?></small>
			</td>
			<td>
				<? if ($syssettings_list['api_enable'] == 'on') { $api_enable = 'checked'; } else { $api_enable = ''; }?>
				<div class="form-check form-switch">
					<input class="form-check-input" type="checkbox" role="switch" name="api_enable" id="api_enable" <?=$api_enable;?>>
					<label class="custom-control-label" for="api_enable"></label>
				</div>
			</td>
		</tr>
	</tbody>
</table>
</form>

<div class="modal fade" id="ModalDefaultSettings" tabindex="-1" role="dialog" aria-labelledby="ModalDefaultSettingsLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalDefaultSettingsLabel"><?=lang('settings_syssettings_modal_reset_title');?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<?=lang('settings_syssettings_modal_reset_confirm');?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"><?=lang('main_btn_cancel');?></button>
				<a type="button" class="btn btn-outline-warning btn-sm" href="/settings/syssettings/reset_settings/"><?=lang('settings_syssettings_btn_reset_settings');?></a>
			</div>
		</div>
	</div>
</div>
