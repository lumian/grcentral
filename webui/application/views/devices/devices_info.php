<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<? if ($this->session->flashdata('success_result')): ?>
	<div class="alert alert-success mt-2 shadow-sm" role="alert"><?=$this->session->flashdata('success_result');?></div>
<? endif;?>

<? if ($this->session->flashdata('error_result')): ?>
	<div class="alert alert-danger mt-2 shadow-sm" role="alert"><?=$this->session->flashdata('error_result');?></div>
<? endif;?>

<div class="row">
	<div class="col-12">
		<div class="card mt-2">
			<div class="card-header"><i class="fa fa-wrench"></i> <?=lang('devices_info_panel_actions_title')?></div>
			<div class="card-body">
					<div class="btn-group w-100" role="group">
						<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalAddEdit" data-bs-actiontype="edit" data-bs-id="<?=$device_info['id'];?>">
							<i class="fa fa-edit"></i> <?=lang('main_btn_edit');?>
						</button>
						<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalLogs">
							<i class="fa fa-list-ul"></i> <?=lang('devices_info_btn_logs');?>
						</button>
						<button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#ModalDelete" data-bs-id="<?=$device_info['id'];?>">
							<i class="fa fa-trash-alt"></i> <?=lang('main_btn_del');?>
						</button>
						<button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalRebootDevice"<? if ($device_info['admin_password'] == ""): ?> disabled<?endif;?>><i class="fa fa-sync"></i> <?=lang('devices_info_btn_cti_reboot');?></button>
					</div>
			</div>
			<? if ($device_info['admin_password'] == ""): ?>
			<div class="card-footer text-muted">
				<?=lang('devices_info_panel_actions_reboot_na_descr');?>
			</div>
			<? endif; ?>
		</div>
	</div>
	
	<div class="col-6">
		<div class="card mt-2">
			<div class="card-header"><i class="fa fa-info-circle"></i> <?=lang('devices_info_panel_about_title')?></div>
			<table class="table table-sm m-0">
				<tr>
					<th class="ps-2" width="50%"><?=lang('devices_info_panel_about_model');?></th>
					<td class="pe-2" width="50%"><?=$device_info['model_info']['friendly_name']; ?></td>
				</tr>
				<tr>
					<th class="ps-2"><?=lang('devices_info_panel_about_ipaddr');?></th>
					<td class="pe-2"><a href="<?=prep_url($device_info['ip_addr']); ?>"  target="_blank" title="<?=lang('devices_info_panel_about_ipaddr_linktitle');?>"><?=$device_info['ip_addr']; ?></a></td>
				</tr>
				<tr>
					<th class="ps-2"><?=lang('devices_info_panel_about_macaddr');?></th>
					<td class="pe-2"><?=$device_info['mac_addr']; ?></td>
				</tr>
				<tr>
					<th class="ps-2"><?=lang('devices_info_panel_about_descr');?></th>
					<td class="pe-2"><?=$device_info['descr']; ?></td>
				</tr>
			</table>
		</div>
	</div>
	
	<div class="col-3">
		<div class="card mt-2">
			<div class="card-header"><i class="fa fa-wifi"></i> <?=lang('devices_info_panel_status_title')?></div>
			<table class="table table-sm m-0">
				<!-- Active state -->
				<tr>
					<th class="ps-2"><?=lang('devices_info_panel_status_active_title');?></th>
					<td class="pe-2">
						<? if ($device_info['status_active'] == '1'): ?>
							<span class="badge bg-success w-100"><i class="fa fa-check"></i> <?=lang('devices_info_panel_status_active_on'); ?></span>
						<? else: ?>
							<span class="badge bg-danger w-100"><i class="fa fa-ban"></i> <?=lang('devices_info_panel_status_active_off'); ?></span>
						<? endif;?>
					</td>
				</tr>
				<!-- Private params -->
				<tr>
					<th class="ps-2"><?=lang('devices_info_panel_status_privateparams_title');?></th>
					<td class="pe-2">
						<? if ($device_info['params_json_data'] != '' AND $device_info['params_json_data'] !== NULL): ?>
							<span class="badge bg-success w-100"><i class="fa fa-user-cog"></i> <?=lang('devices_info_panel_status_privateparams_yes'); ?></span>
						<? else: ?>
							<span class="badge bg-secondary w-100"><i class="fa fa-user-cog"></i> <?=lang('devices_info_panel_status_privateparams_no'); ?></span>
						<? endif;?>
					</td>
				</tr>
				<!-- Firmware -->
				<tr>
					<th class="ps-2"><?=lang('devices_info_panel_status_fw_title');?></th>
					<td class="pe-2">
						<?=$device_info['fw_version']; ?>
						<? if (isset($device_info['fw_version_pinned']) AND $device_info['fw_version_pinned'] != '0'): ?>
							<span data-bs-toggle="tooltip" title="<?=lang('devices_info_panel_status_fw_pinned');?>">(<i class="fa fa-user-lock"></i> <?=$device_info['fw_version_pinned'];?>)</span>
						<? endif; ?>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<? if ($this->settings_model->syssettings_get('monitoring_enable') == 'on'): ?>
		<div class="col-3">
			<div class="card mt-2">
				<div class="card-header"><i class="fa fa-wifi"></i> <?=lang('devices_info_panel_monitoring_title')?></div>
				
				<table class="table table-sm m-0">
					<!-- Monitoring status -->
					<tr>
						<th class="ps-2"><?=lang('devices_info_panel_status_online_title');?></th>
						<td class="pe-2">
							<? if ($device_info['status_online'] == '1'): ?>
								<span class="badge bg-success w-100"><i class="fa fa-globe"></i> <?=lang('devices_info_panel_status_online_on'); ?></span>
							<? else: ?>
								<span class="badge bg-danger w-100"><i class="fa fa-globe"></i> <?=lang('devices_info_panel_status_online_off'); ?></span>
							<? endif; ?>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="ps-2"><?=lang('devices_info_panel_status_online_changetime').' '.date('H:i:s d-m-Y', strtotime($device_info['status_online_changetime']));?></td>
					</tr>
					<tr>
						<td colspan="2" class="p-1">
							<div class="progress" style="height: 24px">
								<div class="progress-bar bg-success" role="progressbar" style="width: <?=$device_available;?>%" aria-valuenow="<?=$device_available;?>" aria-valuemin="0" aria-valuemax="100"><?=($device_available >= 50) ? $device_available.'% '.lang('devices_info_panel_monitoring_online') : NULL;?></div>
								<div class="progress-bar bg-danger" role="progressbar" style="width: <?=100 - $device_available;?>%" aria-valuenow="<?=100 - $device_available;?>" aria-valuemin="0" aria-valuemax="100"><?=($device_available < 50) ? 100 - $device_available.'% '.lang('devices_info_panel_monitoring_offline') : NULL;?></div>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	<? endif; ?>
</div>

<div class="card mt-2">
	<div class="card-header"><i class="fa fa-users"></i> <?=lang('devices_info_panel_accounts_title')?></div>
	<div class="card-body">
		<? if ($this->settings_model->syssettings_get('hide_help_header_msg') != 'on'): ?>
		<p><?=lang('devices_info_panel_accounts_description');?></p>
		<? endif; ?>
		<div class="btn-group btn-group-sm" role="group">
			<button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#ModalAccountsEdit"><i class="fa fa-edit"></i> <?=lang('devices_info_btn_accounts_edit');?></button>
			<a href="<?=lang('main_helpurl_devices_accounts');?>" target="_blank" title="<?=lang('main_helpurl_urltitle');?>" type="button" class="btn btn-outline-secondary"><i class="fa fa-question-circle"></i></a>
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
							<div class="badge bg-success" style="width: 2rem;" data-bs-toggle="tooltip" title="<?=lang('devices_info_table_accounts_status_on');?>"><i class="fa fa-phone"></i></div>
						<? else: ?>
							<div class="badge bg-danger" style="width: 2rem;" data-bs-toggle="tooltip" title="<?=lang('devices_info_table_accounts_status_off');?>"><i class="fa fa-phone-slash"></i></div>
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
<!-- ModalRebootDevice -->
<div class="modal fade" id="ModalRebootDevice" tabindex="-1" role="dialog" aria-labelledby="ModalRebootDeviceLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalRebootDeviceLabel"><?=lang('devices_info_modal_reboot_title');?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body text-center">
				<?=lang('devices_info_modal_reboot_confirm');?>
			</div>
			<div class="modal-footer">
				<button class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"><?=lang('main_btn_cancel');?></button>
				<button class="btn btn-outline-warning btn-sm" data-bs-target="#ModalRebootDeviceRun" data-bs-toggle="modal">Перезапуск</button>
			</div>
		</div>
	</div>
</div>

<!-- ModalRebootDeviceRun -->
<div class="modal fade" id="ModalRebootDeviceRun" tabindex="-1" role="dialog" aria-labelledby="ModalRebootDeviceRunLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalRebootDeviceRunLabel"><?=lang('devices_info_modal_reboot_title');?></h5>
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
	document.getElementById('ModalRebootDeviceRun').addEventListener('show.bs.modal', function (event) {
		var modal = $(this)
		$.ajax({
			url: '<?=site_url("devices/ajax/cti_reboot/".$device_info["id"]);?>',
			dataType: 'json',
			success: function(data) {
				if (data.result == 'success') {
					modal.find('.modal-body').html('<div class="alert alert-success" role="alert"><?=lang("devices_info_modal_reboot_querysuccess");?></div>')
					setTimeout(function() {
						$('#ModalRebootDeviceRun').modal('hide');
					}, 3000);
				} else {
					modal.find('.modal-body').html('<div class="alert alert-danger" role="alert"><?=lang("devices_info_modal_reboot_queryerror");?></div>')
				}
			},
		});
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
			<div class="modal-body text-center">
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
								<div class="d-flex align-items-center">
									<strong><?=lang('main_message_loading');?></strong>
									<div class="spinner-grow ms-auto text-warning" role="status" aria-hidden="true"></div>
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