<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="card mt-2">
	<div class="card-body">
		<h1><?=lang('settings_index_head');?></h1>
		<p><?=lang('settings_index_text');?></p>
		<hr class="hr">
		<h3><?=lang('settings_index_service_state');?></h3>
		<table class="table table-hover table-bordered table-sm mt-2">
			<thead>
				<tr>
					<th><?=lang('settings_index_service_table_name');?></th>
					<th><?=lang('settings_index_service_table_status');?></th>
					<th><?=lang('settings_index_service_table_info');?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Config Service</td>
					<td>
						<? if ($services['cfg']['status'] == 'on'):  ?>
						<span class="badge badge-success"><?=lang('settings_index_status_on');?></span>
						<? else: ?>
						<span class="badge badge-danger" data-toggle="tooltip" data-placement="top" title="<?=lang('settings_index_status_off_descr');?>"><?=lang('settings_index_status_off');?></span>
						<? endif; ?>
					</td>
					<td><?=$services['cfg']['info'];?></td>
				</tr>
				<tr>
					<td>Firmware update Service</td>
					<td>
						<? if ($services['fw']['status'] == 'on'):  ?>
						<span class="badge badge-success"><?=lang('settings_index_status_on');?></span>
						<? else: ?>
						<span class="badge badge-danger" data-toggle="tooltip" data-placement="top" title="<?=lang('settings_index_status_off_descr');?>"><?=lang('settings_index_status_off');?></span>
						<? endif; ?>
					</td>
					<td><?=$services['fw']['info'];?></td>
				</tr>
				<tr>
					<td>Phonebook XML Service</td>
					<td>
						<? if ($services['phonebook']['status'] == 'on'):  ?>
						<span class="badge badge-success"><?=lang('settings_index_status_on');?></span>
						<? else: ?>
						<span class="badge badge-danger" data-toggle="tooltip" data-placement="top" title="<?=lang('settings_index_status_off_descr');?>"><?=lang('settings_index_status_off');?></span>
						<? endif; ?>
					</td>
					<td><?=$services['phonebook']['info'];?></td>
				</tr>
				<tr>
					<td>Monitoring Service</td>
					<td>
						<? if ($services['monitoring']['status'] == 'on'):  ?>
						<span class="badge badge-success"><?=lang('settings_index_status_on');?></span>
						<? else: ?>
						<span class="badge badge-danger" data-toggle="tooltip" data-placement="top" title="<?=lang('settings_index_status_off_descr');?>"><?=lang('settings_index_status_off');?></span>
						<? endif; ?>
					</td>
					<td><?=$services['monitoring']['info'];?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>