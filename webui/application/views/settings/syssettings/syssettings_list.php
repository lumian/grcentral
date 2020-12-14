<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="card mt-2">
  <div class="card-body">
    <?=lang('settings_syssettings_description_text');?>
  </div>
</div>

<div class="btn-group btn-group-sm mt-2" role="group">
	<button type="submit" class="btn btn-outline-success" form="SettingsForm"><?=lang('main_btn_save');?></button>
	<a href="<?=lang('main_helpurl_settings_system');?>" target="_blank" title="<?=lang('main_helpurl_urltitle');?>" type="button" class="btn btn-outline-info"><i class="fa fa-question-circle"></i></a>
</div>

<? if ($this->session->flashdata('success_result')): ?>
<div class="alert alert-success mt-2" role="alert"><?=$this->session->flashdata('success_result');?></div>
<? endif;?>

<? if ($this->session->flashdata('error_result')): ?>
<div class="alert alert-danger mt-2" role="alert"><?=$this->session->flashdata('error_result');?></div>
<? endif;?>

<form id="SettingsForm" method="post" action="<?=site_url('settings/syssettings/edit');?>">
<table class="table table-bordered table-sm mt-2">
	<thead>
		<tr>
			<th colspan="2"><?=lang('settings_syssettings_title_general');?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<?=lang('settings_syssettings_access_device_by_ip_name');?></br>
				<small class="text-muted"><?=lang('settings_syssettings_access_device_by_ip_help');?></small>
			</td>
			<td>
				<? if ($syssettings_list['access_device_by_ip'] == 'on') { $access_device_by_ip = 'checked'; } else { $access_device_by_ip = ''; }?>
				<div class="custom-control custom-switch">
					<input type="checkbox" class="custom-control-input" name="access_device_by_ip" id="access_device_by_ip" <?=$access_device_by_ip;?>>
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
				<div class="custom-control custom-switch">
					<input type="checkbox" class="custom-control-input" name="auto_update_ip_addr" id="auto_update_ip_addr" <?=$auto_update_ip_addr;?>>
					<label class="custom-control-label" for="auto_update_ip_addr"></label>
				</div>
			</td>
		</tr>
	</tbody>
	<thead>
		<tr>
			<th colspan="2"><?=lang('settings_syssettings_title_cfg_server');?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<?=lang('settings_syssettings_cfg_enable_get_name');?></br>
				<small class="text-muted"><?=lang('settings_syssettings_cfg_enable_get_help');?></small>
			</td>
			<td>
				<? if ($syssettings_list['cfg_enable_get'] == 'on') { $cfg_enable_get = 'checked'; } else { $cfg_enable_get = ''; }?>
				<div class="custom-control custom-switch">
					<input type="checkbox" class="custom-control-input" name="cfg_enable_get" id="cfg_enable_get" <?=$cfg_enable_get;?>>
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
				<div class="custom-control custom-switch">
					<input type="checkbox" class="custom-control-input" name="auto_add_devices" id="auto_add_devices" <?=$auto_add_devices;?>>
					<label class="custom-control-label" for="auto_add_devices"></label>
				</div>
			</td>
		</tr>
	</tbody>
	<thead>
		<tr>
			<th colspan="2"><?=lang('settings_syssettings_title_fw_server');?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<?=lang('settings_syssettings_fw_enable_update_name');?></br>
				<small class="text-muted"><?=lang('settings_syssettings_fw_enable_update_help');?></small>
			</td>
			<td>
				<? if ($syssettings_list['fw_enable_update'] == 'on') { $fw_enable_update = 'checked'; } else { $fw_enable_update = ''; }?>
				<div class="custom-control custom-switch">
					<input type="checkbox" class="custom-control-input" name="fw_enable_update" id="fw_enable_update" <?=$fw_enable_update;?>>
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
				<div class="custom-control custom-switch">
					<input type="checkbox" class="custom-control-input" name="fw_update_only_friend" id="fw_update_only_friend" <?=$fw_update_only_friend;?>>
					<label class="custom-control-label" for="fw_update_only_friend"></label>
				</div>
			</td>
		</tr>
	</tbody>
	<thead>
		<tr>
			<th colspan="2"><?=lang('settings_syssettings_title_pb_server');?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<?=lang('settings_syssettings_pb_generate_enable_name');?></br>
				<small class="text-muted"><?=lang('settings_syssettings_pb_generate_enable_help');?></small>
			</td>
			<td>
				<? if ($syssettings_list['pb_generate_enable'] == 'on') { $pb_generate_enable = 'checked'; } else { $pb_generate_enable = ''; }?>
				<div class="custom-control custom-switch">
					<input type="checkbox" class="custom-control-input" name="pb_generate_enable" id="pb_generate_enable" <?=$pb_generate_enable;?>>
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
				<div class="custom-control custom-switch">
					<input type="checkbox" class="custom-control-input" name="pb_collect_accounts" id="pb_collect_accounts" <?=$pb_collect_accounts;?>>
					<label class="custom-control-label" for="pb_collect_accounts"></label>
				</div>
			</td>
		</tr>
	</tbody>
</table>
</form>