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
			<th colspan="2"><?=lang('settings_syssettings_title_provisioning');?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<strong><?=lang('settings_syssettings_auto_add_devices_name');?></strong></br>
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
		<tr>
			<td>
				<strong><?=lang('settings_syssettings_fw_update_only_friend_name');?></strong></br>
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
</table>
</form>