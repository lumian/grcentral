<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<? if ($this->settings_model->syssettings_get('hide_help_header_msg') != 'on'): ?>
<div class="card mt-2">
	<div class="card-body shadow-sm">
		<?=lang('logs_monitoring_description_text');?>
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

<? if ($this->settings_model->syssettings_get('monitoring_enable') == 'on'): ?>

	<? if ($pagination_links != ''): ?>
	<nav aria-label="Navigation">
		<ul class="pagination pagination-sm mt-2">
			<?=$pagination_links;?>
		</ul>
	</nav>
	<? endif; ?>

	<table class="table table-hover table-bordered table-sm mt-2">
		<thead>
			<th width="20%"><?=lang('logs_monitoring_table_datetime');?></th>
			<th><?=lang('logs_monitoring_table_device');?></th>
			<th><?=lang('logs_monitoring_table_device_ip');?></th>
			<th width="30%"><?=lang('logs_monitoring_table_result');?></th>
		</thead>
		
		<tbody>
			<? if ($logs_list != FALSE): ?>
				<? foreach($logs_list as $log): ?>
					<tr>
						<td>
							<!-- datetime -->
							<?=$log['datetime'];?>
						</td>
						
						<td>
							<!-- device -->
							<? if (isset($devices_list[$log['unit_id']]['descr'])): ?>
								<a href="<?=site_url('devices/info/'.$log['unit_id']);?>" title="<?=lang('logs_monitoring_table_device_linkdescr');?>"><?=$devices_list[$log['unit_id']]['descr'];?></a>
							<? else: ?>
								<?=$log['unit_id']; ?>
							<? endif; ?>
						</td>
						
						<td>
							<!-- device ip -->
							<? if (isset($devices_list[$log['unit_id']]['ip_addr'])): ?>
								<a href="http://<?=$devices_list[$log['unit_id']]['ip_addr'];?>/" target="_blank" title="<?=lang('logs_monitoring_table_device_ip_linkdescr');?>"><?=$devices_list[$log['unit_id']]['ip_addr'];?></a>
							<? else: ?>
								N/A
							<? endif; ?>
						</td>
						
						<td>
							<!-- result -->
							<? if ($log['log_data'] === '0'): ?>
								<span class="text-danger"><i class="fa fa-globe text-danger"></i> <?=lang('logs_monitoring_table_result_error');?></span>
							<? elseif ($log['log_data'] === '1'): ?>
								<span class="text-success"><i class="fa fa-globe"></i> <?=lang('logs_monitoring_table_result_ok');?></span>
							<? else: ?>
								N/A
							<? endif; ?>
						</td>
					</tr>
				<? endforeach; ?>
			<? else: ?>
				<tr class="table-primary">
					<td colspan="3"><?=lang('main_message_nodata');?></td>
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

<? else: ?>
	<div class="alert alert-primary mt-2" role="alert"><?=lang('logs_monitoring_disabled');?></div>
<? endif; ?>