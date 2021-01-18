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
				<? foreach($services as $service): ?>
				<tr>
					<td><?=$service['name'];?></td>
					<td>
						<? if ($service['status'] == 'on'):  ?>
						<span class="badge badge-success"><?=lang('settings_index_status_on');?></span>
						<? else: ?>
						<span class="badge badge-danger" data-toggle="tooltip" data-placement="top" title="<?=lang('settings_index_status_off_descr');?>"><?=lang('settings_index_status_off');?></span>
						<? endif; ?>
					</td>
					<td><?=$service['info'];?></td>
				</tr>
				<? endforeach; ?>
			</tbody>
		</table>
	</div>
</div>