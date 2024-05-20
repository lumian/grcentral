<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<? if ($this->settings_model->syssettings_get('hide_help_header_msg') != 'on'): ?>
<div class="card mt-2 shadow-sm">
	<div class="card-body">
		<?=lang('settings_index_text');?>
	</div>
</div>
<?endif;?>

<div class="row">
	<div class="col-8">
		<div class="card mt-2 shadow-sm">
			<div class="card-header">
				<?=lang('settings_index_service_state');?>
			</div>
			<table class="table table-hover table-sm">
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
							<span class="badge bg-success"><?=lang('settings_index_status_on');?></span>
							<? else: ?>
							<span class="badge bg-danger" data-bs-toggle="tooltip" title="<?=lang('settings_index_status_off_descr');?>"><?=lang('settings_index_status_off');?></span>
							<? endif; ?>
						</td>
						<td><?=$service['info'];?></td>
					</tr>
					<? endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-4">
		<div class="card mt-2 shadow-sm">
			<div class="card-header">
				<?=lang('settings_index_update_title');?>
			</div>
			<div class="card-body">
				<? if ($updates != FALSE): ?>
					<ul class="list-unstyled">
						<li><?=lang('settings_index_update_current_version');?>: <?=$this->config->item('version', 'grcentral');?>
						<li><?=lang('settings_index_update_actual_version');?>: <?=$updates['version_actual'];?>
						<li><?=lang('settings_index_update_last_check');?>: <?=$updates['last_check'];?>
					</ul>
					<? if ($updates['need_update'] == TRUE): ?>
						<div class="alert alert-primary text-center" role="alert">
							<?=lang('settings_index_update_need_update_yes');?>
							<? if (isset($updates['version_info']) AND !is_null($updates['version_info'])): ?>
								<br />
								<?=lang('settings_index_update_release_date');?>: <?=$updates['version_info']['release_date'];?><br />
								<a href="<?=$updates['version_info']['release_url'];?>" target="_blank"><?=lang('settings_index_update_release_url');?></a>
							<? endif; ?>
						</div>
					<? else: ?>
						<div class="alert alert-success text-center" role="alert">
							<?=lang('settings_index_update_need_update_no');?>
						</div>
					<? endif; ?>
				<? else: ?>
					<?=lang('settings_index_update_not_start');?>
				<? endif; ?>
				<hr />
				<button type="button" class="btn btn-outline-success btn-sm w-100" data-bs-toggle="modal" data-bs-target="#ModalCheckUpdate"><?=lang('settings_index_update_btn_start_check');?></button>
			</div>
	</div>
</div>

<div class="modal fade" id="ModalCheckUpdate" tabindex="-1" role="dialog" aria-labelledby="ModalCheckUpdateLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalCheckUpdateLabel"><?=lang('settings_index_update_title');?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body text-center">
				<div class="d-flex align-items-center">
					<strong><?=lang('main_message_loading');?></strong>
					<div class="spinner-grow ms-auto text-warning" role="status" aria-hidden="true"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	document.getElementById('ModalCheckUpdate').addEventListener('show.bs.modal', function (event) {
		var modal = $(this)
		$.ajax({
			url: '<?=site_url("settings/ajax/system_update/check/");?>',
			dataType: 'json',
			success: function(data) {
				if (data.result == 'success') {
					modal.find('.modal-body').html('<div class="alert alert-success" role="alert"><?=lang("settings_index_update_alert_ok");?></div>')
					setTimeout(function() {
						$('#ModalCheckUpdate').modal('hide');
					}, 3000);
				} else {
					modal.find('.modal-body').html('<div class="alert alert-danger" role="alert"><?=lang("settings_index_update_alert_error");?></div>')
					setTimeout(function() {
						$('#ModalCheckUpdate').modal('hide');
					}, 3000);
				}
			},
		});
	})
	
	document.getElementById('ModalCheckUpdate').addEventListener('hidden.bs.modal', function (event) {
		location.reload();
	})
</script>
