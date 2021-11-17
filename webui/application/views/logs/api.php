<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<? if ($this->settings_model->syssettings_get('hide_help_header_msg') != 'on'): ?>
<div class="card mt-2">
	<div class="card-body">
		<?=lang('logs_api_description_text');?>
	</div>
</div>
<? endif; ?>

<div class="btn-group btn-group-sm mt-2" role="group">
	<a href="<?=lang('main_helpurl_logs');?>" target="_blank" title="<?=lang('main_helpurl_urltitle');?>" type="button" class="btn btn-outline-secondary"><i class="fa fa-question-circle"></i></a>
</div>

<? if ($this->session->flashdata('success_result')): ?>
	<div class="alert alert-success mt-2" role="alert"><?=$this->session->flashdata('success_result');?></div>
<? endif;?>

<? if ($this->session->flashdata('error_result')): ?>
	<div class="alert alert-danger mt-2" role="alert"><?=$this->session->flashdata('error_result');?></div>
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
		<th><?=lang('logs_api_table_datetime');?></th>
		<th><?=lang('logs_api_table_user');?></th>
		<th><?=lang('logs_api_table_query_type');?></th>
		<th><?=lang('logs_api_table_query');?></th>
		<th><?=lang('logs_api_table_error');?></th>
	</thead>
	
	<tbody>
		<? if ($logs_list != FALSE): ?>
			<? foreach($logs_list as $log): ?>
				<? $log_data = json_decode($log['log_data'], TRUE); ?>
				<tr>
					<td>
						<!-- datetime -->
						<?=$log['datetime'];?>
					</td>
					
					
					<td>
						<!-- user -->
						<?=(isset($api_users[$log['unit_id']]['name']) ? $api_users[$log['unit_id']]['name'] : $log['unit_id']); ?> (IP: <?=$log_data['client_ip'];?>)
					</td>
					
					
					<td>
						<!-- query_type -->
						<i class="fa fa-cog"></i> <?=$log['type']; ?>
					</td>
					
					<td>
						<!-- query -->
						<?=$log_data['query']; ?>
					</td>
					
					<td>
						<!-- error -->
						<? if ($log_data['error'] == TRUE):?>
							<span class="text-danger"><i class="fa fa-times-circle"></i> <?=lang('logs_api_table_error_true');?></span>
						<? else:?>
							<span class="text-success"><i class="fa fa-check-circle"></i> <?=lang('logs_api_table_error_false');?></span>
						<? endif;?>
					</td>
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
