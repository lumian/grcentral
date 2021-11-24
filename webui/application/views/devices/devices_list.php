<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<? if ($this->settings_model->syssettings_get('hide_help_header_msg') != 'on'): ?>
<div class="card mt-2">
	<div class="card-body">
		<?=lang('devices_index_description_text');?>
	</div>
</div>
<? endif; ?>

<div class="btn-group btn-group-sm mt-2" role="group">
	<button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#ModalAddEdit" data-bs-actiontype="new"><i class="fa fa-plus-square"></i> <?=lang('devices_index_btn_new');?></button>
	<a href="<?=lang('main_helpurl_devices');?>" target="_blank" title="<?=lang('main_helpurl_urltitle');?>" type="button" class="btn btn-outline-secondary"><i class="fa fa-question-circle"></i></a>
</div>


<? if ($this->session->flashdata('success_result')): ?>
	<div class="alert alert-success mt-2" role="alert"><?=$this->session->flashdata('success_result');?></div>
<? endif;?>

<? if ($this->session->flashdata('error_result')): ?>
	<div class="alert alert-danger mt-2" role="alert"><?=$this->session->flashdata('error_result');?></div>
<? endif;?>

<table class="table table-hover table-bordered table-sm mt-2">
	<thead>
		<th>#</th>
		<th><?=lang('devices_index_table_descr');?></th>
		<th><?=lang('devices_index_table_macaddr');?></th>
		<th><?=lang('devices_index_table_ipaddr');?></th>
		<? if ($this->settings_model->syssettings_get('monitoring_enable') == 'on'): ?>
		<th><?=lang('devices_index_table_status_online');?></th>
		<? endif; ?>
		<th><?=lang('devices_index_table_model');?></th>
		<th><?=lang('devices_index_table_accounts');?></th>
		<th><?=lang('devices_index_table_fwversion');?></th>
		<th><?=lang('main_table_actions');?></th>
	</thead>
	
	<tbody>
		<? if ($devices_list != FALSE): ?>
			<? $device_count = 0; ?>
			<? foreach($devices_list as $device): ?>
				<? $device_count = $device_count +1; ?>
				<? if ($device['status_active'] === '0'): ?><tr class="table-active"><? else: ?><tr><? endif;?>
					<td><?=$device_count;?></td>
					<td><?=$device['descr'];?></td>
					<td><?=$device['mac_addr'];?></td>
					<td>
						<a href="<?=prep_url($device['ip_addr']);?>" target="_blank" title="<?=lang('devices_index_table_ipaddr_linktitle');?>"><?=$device['ip_addr'];?></a>
					</td>
					<? if ($this->settings_model->syssettings_get('monitoring_enable') == 'on'): ?>
					<td>
						<? if ($device['status_online'] === '1'): ?>
							<span class="text-success"><span class="fa fa-bezier-curve"></span></span>
						<? else: ?>
							<span class="text-danger"><span class="fa fa-bezier-curve"></span></span>
						<? endif; ?>
					</td>
					<? endif; ?>
					<td>
						<? if ($device['model_id'] != '0' AND isset($models_list[$device['model_id']])): ?>
							<?=$models_list[$device['model_id']]['friendly_name'];?>
						<? else: ?>
							<?=lang('devices_index_table_model_na');?>
						<? endif; ?>
					</td>
					<td>
						<? if (isset($device['accounts_data']) AND json_decode($device['accounts_data']) != NULL): ?>
							<? foreach(json_decode($device['accounts_data'], TRUE) as $account): ?>
								<?=$account['userid'];?>&nbsp;
							<? endforeach; ?>
						<? else: ?>
							<?=lang('devices_index_table_accounts_na');?>
						<? endif;?>
					</td>
					<td>
						<? if (isset($device['fw_version']) AND $device['fw_version'] != ''): ?>
							<?=$device['fw_version'];?>
						<? else: ?>
							<?=lang('devices_index_table_fwversion_na');?>
						<? endif; ?>
						<? if (isset($device['fw_version_pinned']) AND $device['fw_version_pinned'] != '0'): ?>
							<span data-bs-toggle="tooltip" title="<?=lang('devices_index_table_fwversionpinned_help');?>: <?=$device['fw_version_pinned'];?>"><i class="fa fa-lock"></i></span>
						<? endif; ?>
					</td>
					<td>
						<div class="btn-group w-100" role="group">
							<a href="<?=site_url('devices/info/'.$device['id']);?>" type="button" class="btn btn-outline-secondary btn-sm" title="<?=lang('devices_index_btn_infotitle');?>">
								<i class="fa fa-info-circle"></i>
							</a>
							<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalAddEdit" data-bs-actiontype="edit" data-bs-id="<?=$device['id'];?>" title="<?=lang('main_btn_edit');?>">
								<i class="fa fa-edit"></i>
							</button>
							<button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#ModalDelete" data-bs-id="<?=$device['id'];?>" title="<?=lang('main_btn_del');?>">
								<i class="fa fa-trash-alt"></i>
							</button>
						</div>
					</td>
				</tr>
			<? endforeach; ?>
		<? else: ?>
			<tr class="table-primary">
				<td colspan="8"><?=lang('main_message_nodata');?></td>
			</tr>
		<? endif; ?>
	</tbody>
</table>

<?=$this->load->view('devices/devices_actions', NULL, TRUE); ?>