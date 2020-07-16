<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<? if ($this->session->flashdata('success_result')): ?>
	<div class="alert alert-success mt-2" role="alert"><?=$this->session->flashdata('success_result');?></div>
<? endif;?>

<? if ($this->session->flashdata('error_result')): ?>
	<div class="alert alert-danger mt-2" role="alert"><?=$this->session->flashdata('error_result');?></div>
<? endif;?>

<div class="card mt-2">
	<div class="card-header"><i class="fa fa-info"></i> <?=lang('devices_info_panel_about_title')?></div>
	<div class="card-body">
		<img src="<?=base_url('style/img/grandstream_logo.png');?>" width="200px" class="rounded float-left mr-4" alt="Grandstream logo">
		<table>
			<tr>
				<td><strong><?=lang('devices_info_panel_about_model');?>:</strong></td>
				<td><?=$device_info['model_info']['friendly_name']; ?></td>
			</tr>
			<tr>
				<td><strong><?=lang('devices_info_panel_about_ipaddr');?>:</strong></td>
				<td><a href="<?=prep_url($device_info['ip_addr']); ?>"  target="_blank"><?=$device_info['ip_addr']; ?></a></td>
			</tr>
			<tr>
				<td><strong><?=lang('devices_info_panel_about_macaddr');?>:</strong></td>
				<td><?=$device_info['mac_addr']; ?></td>
			</tr>
			<tr>
				<td><strong><?=lang('devices_info_panel_about_statusonline');?>:</strong></td>
				<td>
					<? if ($device_info['status_online'] == '1'): ?>
						<div class="badge badge-success text-wrap"><?=lang('devices_info_panel_about_statusonline_on'); ?></div>
					<? else: ?>
						<div class="badge badge-danger text-wrap"><?=lang('devices_info_panel_about_statusonline_off'); ?></div>
					<? endif;?>
				</td>
			</tr>
			<tr>
				<td><strong><?=lang('devices_info_panel_about_statusactive');?>:</strong></td>
				<td>
					<? if ($device_info['status_active'] == '1'): ?>
						<div class="badge badge-success text-wrap"><?=lang('devices_info_panel_about_statusactive_on'); ?></div>
					<? else: ?>
						<div class="badge badge-danger text-wrap"><?=lang('devices_info_panel_about_statusactive_off'); ?></div>
					<? endif;?>
				</td>
			</tr>
			<tr>
				<td><strong><?=lang('devices_info_panel_about_descr');?>:</strong></td>
				<td><?=$device_info['descr']; ?></td>
			</tr>
		</table>
	</div>
</div>
<div class="card mt-2">
	<div class="card-header"><i class="fa fa-network-wired"></i> <?=lang('devices_info_panel_cti_title')?></div>
	<div class="card-body">
		<? if ($device_info['admin_password'] != ""): ?>
			<button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#ModalCTIQuery" data-action="cti_reboot"><i class="fa fa-sync"></i> <?=lang('devices_info_btn_cti_reboot');?></button>
		<? else: ?>
			<div class="alert alert-info" role="alert"><?=lang('devices_info_panel_cti_notavailable');?></div>
		<? endif;?>
	</div>
</div>

<div class="card mt-2">
	<div class="card-header"><i class="fa fa-users"></i> <?=lang('devices_info_panel_accounts_title')?></div>
	<div class="card-body">
		<p><?=lang('devices_info_panel_accounts_description');?></p>
		<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalAccountsEdit"><i class="fa fa-edit"></i> <?=lang('devices_info_btn_accounts_edit');?></button>
		<table class="table table-hover table-sm mt-2">
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
							<div class="badge badge-success text-wrap" style="width: 2rem;" data-toggle="tooltip" title="<?=lang('devices_info_table_accounts_status_on');?>"><i class="fa fa-phone"></i></div>
						<? else: ?>
							<div class="badge badge-danger text-wrap" style="width: 2rem;" data-toggle="tooltip" title="<?=lang('devices_info_table_accounts_status_off');?>"><i class="fa fa-phone-slash"></i></div>
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
<div class="modal fade" id="ModalAccountsEdit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ModalAccountsEditLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalAccountsEditLabel"><?=lang('devices_info_modal_accounts_title');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
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
							<select class="form-control form-control-sm" name="acc1_active" required>
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
							<select class="form-control form-control-sm" name="acc1_voipsrv1" required>
								<option value="">-- <?=lang('devices_info_modal_accounts_voipsrv1');?> --</option>
								<? if ($servers_list != FALSE): ?>
								<? foreach($servers_list as $server): ?>
								<option value='<?=$server['id'];?>'><?=$server['name'];?></option>
								<? endforeach; ?>
								<? endif; ?>
							</select>
						</div>
						<div class="col">
							<select class="form-control form-control-sm" name="acc1_voipsrv2" required>
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
							<select class="form-control form-control-sm" name="acc2_active">
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
							<select class="form-control form-control-sm" name="acc2_voipsrv1">
								<option value="">-- <?=lang('devices_info_modal_accounts_voipsrv1');?> --</option>
								<? if ($servers_list != FALSE): ?>
								<? foreach($servers_list as $server): ?>
								<option value='<?=$server['id'];?>'><?=$server['name'];?></option>
								<? endforeach; ?>
								<? endif; ?>
							</select>
						</div>
						<div class="col">
							<select class="form-control form-control-sm" name="acc2_voipsrv2">
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
							<select class="form-control form-control-sm" name="acc3_active">
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
							<select class="form-control form-control-sm" name="acc3_voipsrv1">
								<option value="">-- <?=lang('devices_info_modal_accounts_voipsrv1');?> --</option>
								<? if ($servers_list != FALSE): ?>
								<? foreach($servers_list as $server): ?>
								<option value='<?=$server['id'];?>'><?=$server['name'];?></option>
								<? endforeach; ?>
								<? endif; ?>
							</select>
						</div>
						<div class="col">
							<select class="form-control form-control-sm" name="acc3_voipsrv2">
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
							<select class="form-control form-control-sm" name="acc4_active">
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
							<select class="form-control form-control-sm" name="acc4_voipsrv1">
								<option value="">-- <?=lang('devices_info_modal_accounts_voipsrv1');?> --</option>
								<? if ($servers_list != FALSE): ?>
								<? foreach($servers_list as $server): ?>
								<option value='<?=$server['id'];?>'><?=$server['name'];?></option>
								<? endforeach; ?>
								<? endif; ?>
							</select>
						</div>
						<div class="col">
							<select class="form-control form-control-sm" name="acc4_voipsrv2">
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
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><?=lang('main_btn_cancel');?></button>
				<button type="submit" class="btn btn-success btn-sm" form="ModalAccountsEditForm"><?=lang('main_btn_save');?></button>
			</div>
		</div>
	</div>
</div>
<script>
	$('#ModalAccountsEdit').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
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
<div class="modal fade" id="ModalCTIQuery" tabindex="-1" role="dialog" aria-labelledby="ModalCTIQueryLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalDeleteLabel"><?=lang('devices_info_modal_cti_title');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-center">
				<div class="spinner-border text-warning" role="status">
					<span class="sr-only">Loading...</span>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#ModalCTIQuery').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var modal = $(this)
		var action = button.data('action')
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
	
	$('#ModalCTIQuery').on('hidden.bs.modal', function () {
		location.reload();
	})
</script>
<? endif;?>
