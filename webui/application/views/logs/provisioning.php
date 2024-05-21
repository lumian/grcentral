<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<? if ($this->settings_model->syssettings_get('hide_help_header_msg') != 'on'): ?>
<div class="card mt-2">
	<div class="card-body shadow-sm">
		<?=lang('logs_provisioning_description_text');?>
	</div>
</div>
<? endif; ?>

<div class="btn-group btn-group-sm mt-2" role="group">
	<a href="<?=lang('main_helpurl_logs');?>" target="_blank" title="<?=lang('main_helpurl_urltitle');?>" type="button" class="btn btn-outline-secondary"><i class="fa fa-question-circle"></i></a>
</div>

<? if ($this->session->flashdata('success_result')): ?>
	<div class="alert alert-success mt-2 shadow-sm" role="alert"><?=$this->session->flashdata('success_result');?></div>
<? endif;?>

<? if ($this->session->flashdata('error_result')): ?>
	<div class="alert alert-danger mt-2 shadow-sm" role="alert"><?=$this->session->flashdata('error_result');?></div>
<? endif;?>

<? if ($pagination_links != ''): ?>
<nav aria-label="Navigation">
	<ul class="pagination pagination-sm mt-2">
		<?=$pagination_links;?>
	</ul>
</nav>
<? endif; ?>

<table class="table table-hover table-bordered table-sm mt-2">
	<thead>
		<th><?=lang('logs_provisioning_table_datetime');?></th>
		<th><?=lang('logs_provisioning_table_device');?></th>
		<th><?=lang('logs_provisioning_table_type');?></th>
		<th><?=lang('logs_provisioning_table_fwversion');?></th>
	</thead>
	
	<tbody>
		<? if ($logs_list != FALSE): ?>
			<? foreach($logs_list as $log): ?>
				<tr>
					<td><?=$log['datetime'];?></td>
					
					
					<td>
						[ID: <?=$log['unit_id'];?>]&nbsp;
						<? if (isset($devices_list[$log['unit_id']])): ?>
						<a href="<?=site_url('devices/info/'.$log['unit_id'].'/');?>" target="_blank" title="<?=lang('logs_provisioning_table_device_linktitle');?>"><?=$devices_list[$log['unit_id']]['descr'];?></a>
						<? endif;?>
					</td>
					
					
					<td>
						<? if ($log['type'] == 'device_get_cfg'): ?>
							<i class="fa fa-align-justify"></i> <?=lang('logs_provisioning_table_type_device_get_cfg');?>
						<? elseif ($log['type'] == 'device_get_fw'): ?>
							<i class="fa fa-microchip"></i> <?=lang('logs_provisioning_table_type_device_get_fw');?>
						<? elseif ($log['type'] == 'device_get_pb'): ?>
							<i class="fa fa-address-book"></i> <?=lang('logs_provisioning_table_type_device_get_pb');?>
						<? else: ?>
							<i class="fa fa-cog"></i> <?=$log['type']; ?>
						<? endif; ?>
					</td>
					<td><? $log_data = json_decode($log['log_data']); echo $log_data->fw_version; ?></td>
				</tr>
			<? endforeach; ?>
		<? else: ?>
			<tr class="table-primary">
				<td colspan="5"><?=lang('main_message_nodata');?></td>
			</tr>
		<? endif; ?>
	</tbody>
</table>

<? if ($pagination_links != ''): ?>
<nav aria-label="Navigation">
	<ul class="pagination pagination-sm mt-2">
		<?=$pagination_links;?>
	</ul>
</nav>
<? endif; ?>
