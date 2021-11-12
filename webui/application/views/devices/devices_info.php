<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<? if ($this->session->flashdata('success_result')): ?>
	<div class="alert alert-success mt-2" role="alert"><?=$this->session->flashdata('success_result');?></div>
<? endif;?>

<? if ($this->session->flashdata('error_result')): ?>
	<div class="alert alert-danger mt-2" role="alert"><?=$this->session->flashdata('error_result');?></div>
<? endif;?>

<div class="row">
	<div class="col-9">
		<div class="card mt-2">
			<div class="card-header"><i class="fa fa-info-circle"></i> <?=lang('devices_info_panel_about_title')?></div>
			<div class="card-body">
				<table class="table table-hover table-sm">
					<tr>
						<th><?=lang('devices_info_panel_about_model');?></th>
						<td><?=$device_info['model_info']['friendly_name']; ?></td>
					</tr>
					<tr>
						<th><?=lang('devices_info_panel_about_ipaddr');?></th>
						<td><a href="<?=prep_url($device_info['ip_addr']); ?>"  target="_blank" title="<?=lang('devices_info_panel_about_ipaddr_linktitle');?>"><?=$device_info['ip_addr']; ?></a></td>
					</tr>
					<tr>
						<th><?=lang('devices_info_panel_about_macaddr');?></th>
						<td><?=$device_info['mac_addr']; ?></td>
					</tr>
					<? if ($this->settings_model->syssettings_get('monitoring_enable') == 'on'): ?>
					<tr>
						<th><?=lang('devices_info_panel_about_statusonline');?></th>
						<td>
							<? if ($device_info['status_online'] == '1'): ?>
								<span class="badge bg-success"><?=lang('devices_info_panel_about_statusonline_on'); ?></span>
							<? else: ?>
								<span class="badge bg-danger"><?=lang('devices_info_panel_about_statusonline_off'); ?></span>
							<? endif;?>
							(<?=lang('devices_info_panel_about_statusonline_changetime'); ?> <?=$device_info['status_online_changetime'];?>)
						</td>
					</tr>
					<? endif; ?>
					<tr>
						<th><?=lang('devices_info_panel_about_statusactive');?></th>
						<td>
							<? if ($device_info['status_active'] == '1'): ?>
								<span class="badge bg-success"><?=lang('devices_info_panel_about_statusactive_on'); ?></span>
							<? else: ?>
								<span class="badge bg-danger"><?=lang('devices_info_panel_about_statusactive_off'); ?></span>
							<? endif;?>
						</td>
					</tr>
					<tr>
						<th><?=lang('devices_info_panel_about_descr');?></th>
						<td><?=$device_info['descr']; ?></td>
					</tr>
					<tr>
						<th><?=lang('devices_info_panel_about_fw');?></th>
						<td>
							<?=$device_info['fw_version']; ?>
							<? if (isset($device_info['fw_version_pinned']) AND $device_info['fw_version_pinned'] != '0'): ?>
								(<?=lang('devices_info_panel_about_fw_pinned');?>: <?=$device_info['fw_version_pinned'];?>)
							<? endif; ?>
						
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
	<div class="col-3">
		<div class="card mt-2">
			<div class="card-header"><i class="fa fa-wrench"></i> <?=lang('devices_info_panel_actions_title')?></div>
			<div class="card-body">
				<button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#ModalAddEdit" data-bs-actiontype="edit" data-bs-id="<?=$device_info['id'];?>">
					<i class="fa fa-edit"></i> <?=lang('main_btn_edit');?>
				</button><br />
				<button type="button" class="btn btn-outline-info btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#ModalLogs">
					<i class="fa fa-list-ul"></i> <?=lang('devices_info_btn_logs');?>
				</button><br />
				<button type="button" class="btn btn-outline-danger btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#ModalDelete" data-bs-id="<?=$device_info['id'];?>">
					<i class="fa fa-trash-alt"></i> <?=lang('main_btn_del');?>
				</button>
				<hr class="hr" />
				<? if ($device_info['admin_password'] != ""): ?>
					<button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalCTIQuery" data-bs-action="cti_reboot"><i class="fa fa-sync"></i> <?=lang('devices_info_btn_cti_reboot');?></button>
				<? else: ?>
					<div class="alert alert-info" role="alert">
						<span data-bs-toggle="tooltip" title="<?=lang('devices_info_panel_actions_cti_na_descr');?>"><?=lang('devices_info_panel_actions_cti_na_error');?></span>
					</div>
				<? endif;?>
			</div>
		</div>
	</div>
</div>

<div class="card mt-2">
	<div class="card-header"><i class="fa fa-users"></i> <?=lang('devices_info_panel_accounts_title')?></div>
	<div class="card-body">
		<? if ($this->settings_model->syssettings_get('hide_help_header_msg') != 'on'): ?>
		<p><?=lang('devices_info_panel_accounts_description');?></p>
		<? endif; ?>
		<div class="btn-group btn-group-sm" role="group">
			<button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#ModalAccountsEdit"><i class="fa fa-edit"></i> <?=lang('devices_info_btn_accounts_edit');?></button>
			<a href="<?=lang('main_helpurl_devices_accounts');?>" target="_blank" title="<?=lang('main_helpurl_urltitle');?>" type="button" class="btn btn-outline-info"><i class="fa fa-question-circle"></i></a>
		</div>
		
		<table class="table table-hover table-bordered table-sm mt-2">
			<thead>
				<th><?=lang('devices_info_table_accounts_position');?></th>
				<th><?=lang('devices_info_table_accounts_name');?></th>
				<th><?=lang('devices_info_table_accounts_userid');?></th>
				<th><?=lang('devices_info_table_accounts_authid');?></th>
				<th><?=lang('devices_info_table_accounts_password');?></th>
				<th><?=lang('devices_info_table_accounts_voipsrv1');?></th>
				<th><?=lang('devices_info_table_accounts_voipsrv2');?></th>
				<th><?=lang('devices_info_table_accounts_status');?></th>
			</thead>
			<tbody>
				<? if ($accounts_list != FALSE): ?>
				<? foreach($accounts_list as $pos => $account): ?>
				<tr>
					<td><?=$pos;?></td>
					<td><?=$account['name'];?></td>
					<td><?=$account['userid'];?></td>
					<td><?=$account['authid'];?></td>
					<td><?=$account['password'];?></td>
					<td>
						<!-- VoIP Server #1 -->
						<? if (isset($servers_list[$account['voipsrv1']])): ?>
							<?=$servers_list[$account['voipsrv1']]['name'];?>
						<? else: ?>
						<?=lang('devices_info_table_accounts_voipsrv_na');?>
						<? endif; ?>
					</td>
					<td>
						<!-- VoIP Server #2 -->
						<? if (isset($servers_list[$account['voipsrv2']])): ?>
							<?=$servers_list[$account['voipsrv2']]['name'];?>
						<? else: ?>
						<?=lang('devices_info_table_accounts_voipsrv_na');?>
						<? endif; ?>
					</td>
					<td>
						<? if ($account['active'] === "1"): ?>
							<div class="badge bg-success" style="width: 2rem;" data-toggle="tooltip" title="<?=lang('devices_info_table_accounts_status_on');?>"><i class="fa fa-phone"></i></div>
						<? else: ?>
							<div class="badge bg-danger" style="width: 2rem;" data-toggle="tooltip" title="<?=lang('devices_info_table_accounts_status_off');?>"><i class="fa fa-phone-slash"></i></div>
						<? endif;?>
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
	</div>
</div>

<!-- ModalAccountsEdit -->
<div class="modal fade" id="ModalAccountsEdit" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ModalAccountsEditLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalAccountsEditLabel"><?=lang('devices_info_modal_accounts_title');?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="ModalAccountsEditForm" method="post" action="<?=site_url('devices/actions/edit_accounts/'.$device_info['id']);?>">
					<!-- Account #1 -->
					<div class="row">
						<div class="col">
							<strong><?=lang('devices_info_modal_accounts_account');?> #1 (<?=lang('devices_info_modal_accounts_mustbefilled')?>)</strong>
						</div>
						<div class="col">
							&nbsp;
						</div>
						<div class="col">
							<select class="form-select form-select-sm" name="acc1_active" required>
								<option value="">-- <?=lang('devices_info_modal_accounts_active');?> --</option>
								<option value='0'><?=lang('devices_info_modal_accounts_active_off');?></option>
								<option value='1'><?=lang('devices_info_modal_accounts_active_on');?></option>
							</select>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('devices_info_modal_accounts_name');?>" name="acc1_name" required>
						</div>
						<div class="col">
							<select class="form-select form-select-sm" name="acc1_voipsrv1" required>
								<option value="">-- <?=lang('devices_info_modal_accounts_voipsrv1');?> --</option>
								<? if ($servers_list != FALSE): ?>
								<? foreach($servers_list as $server): ?>
								<option value='<?=$server['id'];?>'><?=$server['name'];?></option>
								<? endforeach; ?>
								<? endif; ?>
							</select>
						</div>
						<div class="col">
							<select class="form-select form-select-sm" name="acc1_voipsrv2" required>
								<option value="">-- <?=lang('devices_info_modal_accounts_voipsrv2');?> --</option>
								<? if ($servers_list != FALSE): ?>
								<? foreach($servers_list as $server): ?>
								<option value='<?=$server['id'];?>'><?=$server['name'];?></option>
								<? endforeach; ?>
								<? endif; ?>
							</select>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('devices_info_modal_accounts_userid');?>" name="acc1_userid" required>
						</div>
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('devices_info_modal_accounts_authid');?>" name="acc1_authid" required>
						</div>
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('devices_info_modal_accounts_password');?>" name="acc1_password" required>
						</div>
					</div>
					<hr class="hr">
					<!-- Account #2 -->
					<div class="row">
						<div class="col">
							<strong><?=lang('devices_info_modal_accounts_account');?> #2</strong>
						</div>
						<div class="col">
							&nbsp;
						</div>
						<div class="col">
							<select class="form-select form-select-sm" name="acc2_active">
								<option value="">-- <?=lang('devices_info_modal_accounts_active');?> --</option>
								<option value='0'><?=lang('devices_info_modal_accounts_active_off');?></option>
								<option value='1'><?=lang('devices_info_modal_accounts_active_on');?></option>
							</select>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('devices_info_modal_accounts_name');?>" name="acc2_name">
						</div>
						<div class="col">
							<select class="form-select form-select-sm" name="acc2_voipsrv1">
								<option value="">-- <?=lang('devices_info_modal_accounts_voipsrv1');?> --</option>
								<? if ($servers_list != FALSE): ?>
								<? foreach($servers_list as $server): ?>
								<option value='<?=$server['id'];?>'><?=$server['name'];?></option>
								<? endforeach; ?>
								<? endif; ?>
							</select>
						</div>
						<div class="col">
							<select class="form-select form-select-sm" name="acc2_voipsrv2">
								<option value="">-- <?=lang('devices_info_modal_accounts_voipsrv2');?> --</option>
								<? if ($servers_list != FALSE): ?>
								<? foreach($servers_list as $server): ?>
								<option value='<?=$server['id'];?>'><?=$server['name'];?></option>
								<? endforeach; ?>
								<? endif; ?>
							</select>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('devices_info_modal_accounts_userid');?>" name="acc2_userid">
						</div>
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('devices_info_modal_accounts_authid');?>" name="acc2_authid">
						</div>
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('devices_info_modal_accounts_password');?>" name="acc2_password">
						</div>
					</div>
					<hr class="hr">
					<!-- Account #3 -->
					<div class="row">
						<div class="col">
							<strong><?=lang('devices_info_modal_accounts_account');?> #3</strong>
						</div>
						<div class="col">
							&nbsp;
						</div>
						<div class="col">
							<select class="form-select form-select-sm" name="acc3_active">
								<option value="">-- <?=lang('devices_info_modal_accounts_active');?> --</option>
								<option value='0'><?=lang('devices_info_modal_accounts_active_off');?></option>
								<option value='1'><?=lang('devices_info_modal_accounts_active_on');?></option>
							</select>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('devices_info_modal_accounts_name');?>" name="acc3_name">
						</div>
						<div class="col">
							<select class="form-select form-select-sm" name="acc3_voipsrv1">
								<option value="">-- <?=lang('devices_info_modal_accounts_voipsrv1');?> --</option>
								<? if ($servers_list != FALSE): ?>
								<? foreach($servers_list as $server): ?>
								<option value='<?=$server['id'];?>'><?=$server['name'];?></option>
								<? endforeach; ?>
								<? endif; ?>
							</select>
						</div>
						<div class="col">
							<select class="form-select form-select-sm" name="acc3_voipsrv2">
								<option value="">-- <?=lang('devices_info_modal_accounts_voipsrv2');?> --</option>
								<? if ($servers_list != FALSE): ?>
								<? foreach($servers_list as $server): ?>
								<option value='<?=$server['id'];?>'><?=$server['name'];?></option>
								<? endforeach; ?>
								<? endif; ?>
							</select>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('devices_info_modal_accounts_userid');?>" name="acc3_userid">
						</div>
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('devices_info_modal_accounts_authid');?>" name="acc3_authid">
						</div>
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('devices_info_modal_accounts_password');?>" name="acc3_password">
						</div>
					</div>
					<hr class="hr">
					<!-- Account #4 -->
					<div class="row">
						<div class="col">
							<strong><?=lang('devices_info_modal_accounts_account');?> #4</strong>
						</div>
						<div class="col">
							&nbsp;
						</div>
						<div class="col">
							<select class="form-select form-select-sm" name="acc4_active">
								<option value="">-- <?=lang('devices_info_modal_accounts_active');?> --</option>
								<option value='0'><?=lang('devices_info_modal_accounts_active_off');?></option>
								<option value='1'><?=lang('devices_info_modal_accounts_active_on');?></option>
							</select>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('devices_info_modal_accounts_name');?>" name="acc4_name">
						</div>
						<div class="col">
							<select class="form-select form-select-sm" name="acc4_voipsrv1">
								<option value="">-- <?=lang('devices_info_modal_accounts_voipsrv1');?> --</option>
								<? if ($servers_list != FALSE): ?>
								<? foreach($servers_list as $server): ?>
								<option value='<?=$server['id'];?>'><?=$server['name'];?></option>
								<? endforeach; ?>
								<? endif; ?>
							</select>
						</div>
						<div class="col">
							<select class="form-select form-select-sm" name="acc4_voipsrv2">
								<option value="">-- <?=lang('devices_info_modal_accounts_voipsrv2');?> --</option>
								<? if ($servers_list != FALSE): ?>
								<? foreach($servers_list as $server): ?>
								<option value='<?=$server['id'];?>'><?=$server['name'];?></option>
								<? endforeach; ?>
								<? endif; ?>
							</select>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('devices_info_modal_accounts_userid');?>" name="acc4_userid">
						</div>
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('devices_info_modal_accounts_authid');?>" name="acc4_authid">
						</div>
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('devices_info_modal_accounts_password');?>" name="acc4_password">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"><?=lang('main_btn_cancel');?></button>
				<button type="submit" class="btn btn-outline-success btn-sm" form="ModalAccountsEditForm"><?=lang('main_btn_save');?></button>
			</div>
		</div>
	</div>
</div>
<script>
	document.getElementById('ModalAccountsEdit').addEventListener('show.bs.modal', function (event) {
		var button = event.relatedTarget
		var modal = $(this)
		$.ajax({
			url: '<?=site_url("devices/ajax/get_accounts/".$device_info["id"]);?>',
			dataType: 'json',
			success: function(data) {
				if (data.result == 'success') {
					modal.find('.modal-body select[name=acc1_active]').val(data.data[1].active)
					modal.find('.modal-body input[name=acc1_name]').val(data.data[1].name)
					modal.find('.modal-body select[name=acc1_voipsrv1]').val(data.data[1].voipsrv1)
					modal.find('.modal-body select[name=acc1_voipsrv2]').val(data.data[1].voipsrv2)
					modal.find('.modal-body input[name=acc1_userid]').val(data.data[1].userid)
					modal.find('.modal-body input[name=acc1_authid]').val(data.data[1].authid)
					modal.find('.modal-body input[name=acc1_password]').val(data.data[1].password)
					modal.find('.modal-body select[name=acc2_active]').val(data.data[2].active)
					modal.find('.modal-body input[name=acc2_name]').val(data.data[2].name)
					modal.find('.modal-body select[name=acc2_voipsrv1]').val(data.data[2].voipsrv1)
					modal.find('.modal-body select[name=acc2_voipsrv2]').val(data.data[2].voipsrv2)
					modal.find('.modal-body input[name=acc2_userid]').val(data.data[2].userid)
					modal.find('.modal-body input[name=acc2_authid]').val(data.data[2].authid)
					modal.find('.modal-body input[name=acc2_password]').val(data.data[2].password)
					modal.find('.modal-body select[name=acc3_active]').val(data.data[3].active)
					modal.find('.modal-body input[name=acc3_name]').val(data.data[3].name)
					modal.find('.modal-body select[name=acc3_voipsrv1]').val(data.data[3].voipsrv1)
					modal.find('.modal-body select[name=acc3_voipsrv2]').val(data.data[3].voipsrv2)
					modal.find('.modal-body input[name=acc3_userid]').val(data.data[3].userid)
					modal.find('.modal-body input[name=acc3_authid]').val(data.data[3].authid)
					modal.find('.modal-body input[name=acc3_password]').val(data.data[3].password)
					modal.find('.modal-body select[name=acc4_active]').val(data.data[4].active)
					modal.find('.modal-body input[name=acc4_name]').val(data.data[4].name)
					modal.find('.modal-body select[name=acc4_voipsrv1]').val(data.data[4].voipsrv1)
					modal.find('.modal-body select[name=acc4_voipsrv2]').val(data.data[4].voipsrv2)
					modal.find('.modal-body input[name=acc4_userid]').val(data.data[4].userid)
					modal.find('.modal-body input[name=acc4_authid]').val(data.data[4].authid)
					modal.find('.modal-body input[name=acc4_password]').val(data.data[4].password)
				} else {
					alert('<?=lang("main_error_ajaxload");?>')
				}
			}
		});
	})
</script>

<? if ($device_info['admin_password'] != ""): ?>
<!-- ModalCTIQuery -->
<div class="modal fade" id="ModalCTIQuery" tabindex="-1" role="dialog" aria-labelledby="ModalCTIQueryLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalDeleteLabel"><?=lang('devices_info_modal_cti_title');?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body text-center">
				<div class="spinner-border text-warning" role="status">
					<span class="sr-only"><?=lang('main_message_loading');?></span>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	document.getElementById('ModalCTIQuery').addEventListener('show.bs.modal', function (event) {
		var button = event.relatedTarget
		var modal = $(this)
		var action = button.getAttribute('data-bs-action')
		if (action == 'cti_reboot') {
			$.ajax({
				url: '<?=site_url("devices/ajax/cti_reboot/".$device_info["id"]);?>',
				dataType: 'json',
				success: function(data) {
					if (data.result == 'success') {
						modal.find('.modal-body').html('<div class="alert alert-success" role="alert"><?=lang("devices_info_modal_cti_querysuccess");?></div>')
						setTimeout(function() {
							$('#ModalCTIQuery').modal('hide');
						}, 3000);
					} else {
						modal.find('.modal-body').html('<div class="alert alert-danger" role="alert"><?=lang("devices_info_modal_cti_queryerror");?></div>')
					}
				},
			});
		}
	})
	
	document.getElementById('ModalCTIQuery').addEventListener('hidden.bs.modal', function (event) {
		location.reload();
	})
</script>
<? endif;?>

<!-- ModalLogs -->
<div class="modal fade" id="ModalLogs" tabindex="-1" role="dialog" aria-labelledby="ModalLogsLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalLogsLabel"><?=lang('devices_index_modallogs_title');?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p><?=lang('devices_index_modallogs_descr');?></p>
				<table class="table table-hover table-sm mt-2">
					<thead>
						<tr>
							<th><?=lang('devices_index_modallogs_table_date');?></th>
							<th><?=lang('devices_index_modallogs_table_type');?></th>
							<th><?=lang('devices_index_modallogs_table_fwversion');?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="3" class="text-center">
								<div class="spinner-border text-warning" role="status">
									<span class="sr-only"><?=lang('main_message_loading');?></span>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"><?=lang('main_btn_cancel');?></button>
			</div>
		</div>
	</div>
</div>
<script>
	document.getElementById('ModalLogs').addEventListener('show.bs.modal', function (event) {
		var button = event.relatedTarget
		var modal = $(this)
		var table_stings = ''
		$.ajax({
			url: '<?=site_url("devices/ajax/get_logs/".$device_info["id"]);?>',
			dataType: 'json',
			success: function(data) {
				if (data.result == 'success') {
					$.each( data.data, function( key, value ){
						table_stings = table_stings + '<tr><td>' + value.datetime + '</td><td>' + value.type + '</td><td>' + value.log_data.fw_version + '</td></tr>';
					});
				} else {
					table_stings = '<tr colspan="3" class="text-center"><td class="table-primary" colspan="3"><?=lang("devices_index_modallogs_table_nodata");?></td></tr>';
				}
				modal.find('.modal-body table tbody').html(table_stings);
			}
		});
	})
</script>
<?=$this->load->view('devices/devices_actions', NULL, TRUE); ?>