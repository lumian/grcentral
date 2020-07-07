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
	<div class="card-header"><?=lang('phones_info_title')?></div>
	<div class="card-body">
		<img src="/style/img/grandstream_logo.png" width="200px" class="rounded float-left mr-4" alt="Grandstream logo">
		<table>
			<tr>
				<td><strong><?=lang('phones_info_model');?>:</strong></td>
				<td><?=$phone_info['model_info']['friendly_name']; ?></td>
			</tr>
			<tr>
				<td><strong><?=lang('phones_info_ipaddr');?>:</strong></td>
				<td><a href="http://<?=$phone_info['ip_addr']; ?>"  target="_blank" title="<?=lang('phones_table_ip_addr_linktitle');?>"><?=$phone_info['ip_addr']; ?></a></td>
			</tr>
			<tr>
				<td><strong><?=lang('phones_info_macaddr');?>:</strong></td>
				<td><?=$phone_info['mac_addr']; ?></td>
			</tr>
			<tr>
				<td><strong><?=lang('phones_info_statusonline');?>:</strong></td>
				<td>
					<? if ($phone_info['status_online'] == '1'): ?>
						<div class="badge badge-success text-wrap"><?=lang('phones_info_statusonline_on'); ?></div>
					<? else: ?>
						<div class="badge badge-danger text-wrap"><?=lang('phones_info_statusonline_off'); ?></div>
					<? endif;?>
				</td>
			</tr>
			<tr>
				<td><strong><?=lang('phones_info_statusactive');?>:</strong></td>
				<td>
					<? if ($phone_info['status_active'] == '1'): ?>
						<div class="badge badge-success text-wrap"><?=lang('phones_info_statusactive_on'); ?></div>
					<? else: ?>
						<div class="badge badge-danger text-wrap"><?=lang('phones_info_statusactive_off'); ?></div>
					<? endif;?>
				</td>
			</tr>
			<tr>
				<td><strong><?=lang('phones_info_descr');?>:</strong></td>
				<td><?=$phone_info['descr']; ?></td>
			</tr>
		</table>
	</div>
</div>
<div class="card mt-2">
	<div class="card-header"><?=lang('phones_actions_title')?></div>
	<div class="card-body">
		<button type="button" class="btn btn-primary btn-sm" disabled><?=lang('phones_actions_btn_reboot');?></button>
	</div>
</div>

<div class="card mt-2">
	<div class="card-header"><?=lang('phones_accounts_title')?></div>
	<div class="card-body">
		<p><?=lang('phones_accounts_description');?></p>
		<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#ModalAccountsEdit"><?=lang('phones_accounts_btn_edit');?></button>
		<table class="table table-hover table-sm mt-2">
			<thead>
				<th><?=lang('phones_accounts_table_position');?></th>
				<th><?=lang('phones_accounts_table_name');?></th>
				<th><?=lang('phones_accounts_table_userid');?></th>
				<th><?=lang('phones_accounts_table_authid');?></th>
				<th><?=lang('phones_accounts_table_password');?></th>
				<th><?=lang('phones_accounts_table_voipsrv1');?></th>
				<th><?=lang('phones_accounts_table_voipsrv2');?></th>
			</thead>
			<tbody>
				<? if ($accounts_list != FALSE): ?>
				<? foreach($accounts_list as $pos => $account): ?>
				<? if ($account['active'] === "1"):?>
				<tr class="table-success">
				<? else: ?>
				<tr class="table-secondary">
				<? endif; ?>
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
						<?=lang('phones_accounts_table_voipsrv_na');?>
						<? endif; ?>
					</td>
					<td>
						<!-- VoIP Server #2 -->
						<? if (isset($servers_list[$account['voipsrv2']])): ?>
							<?=$servers_list[$account['voipsrv2']]['name'];?>
						<? else: ?>
						<?=lang('phones_accounts_table_voipsrv_na');?>
						<? endif; ?>
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
				<h5 class="modal-title" id="ModalAccountsEditLabel">ModalTitle</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="ModalAccountsEditForm" method="post" action="/phones/actions/edit_accounts/<?=$phone_info['id'];?>">
					<!-- Account #1 -->
					<div class="row">
						<div class="col">
							<strong><?=lang('phones_accounts_modal_account');?> #1 (<?=lang('phones_accounts_modal_mustbefilled')?>)</strong>
						</div>
						<div class="col">
							&nbsp;
						</div>
						<div class="col">
							<select class="form-control form-control-sm" name="acc1_active" required>
								<option value="">-- <?=lang('phones_accounts_modal_active');?> --</option>
								<option value='0'><?=lang('phones_accounts_modal_active_off');?></option>
								<option value='1'><?=lang('phones_accounts_modal_active_on');?></option>
							</select>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('phones_accounts_modal_name');?>" name="acc1_name" required>
						</div>
						<div class="col">
							<select class="form-control form-control-sm" name="acc1_voipsrv1" required>
								<option value="">-- <?=lang('phones_accounts_modal_voipsrv1');?> --</option>
								<? if ($servers_list != FALSE): ?>
								<? foreach($servers_list as $server): ?>
								<option value='<?=$server['id'];?>'><?=$server['name'];?></option>
								<? endforeach; ?>
								<? endif; ?>
							</select>
						</div>
						<div class="col">
							<select class="form-control form-control-sm" name="acc1_voipsrv2" required>
								<option value="">-- <?=lang('phones_accounts_modal_voipsrv2');?> --</option>
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
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('phones_accounts_modal_userid');?>" name="acc1_userid" required>
						</div>
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('phones_accounts_modal_authid');?>" name="acc1_authid" required>
						</div>
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('phones_accounts_modal_password');?>" name="acc1_password" required>
						</div>
					</div>
					<hr class="hr">
					<!-- Account #2 -->
					<div class="row">
						<div class="col">
							<strong><?=lang('phones_accounts_modal_account');?> #2</strong>
						</div>
						<div class="col">
							&nbsp;
						</div>
						<div class="col">
							<select class="form-control form-control-sm" name="acc2_active">
								<option value="">-- <?=lang('phones_accounts_modal_active');?> --</option>
								<option value='0'><?=lang('phones_accounts_modal_active_off');?></option>
								<option value='1'><?=lang('phones_accounts_modal_active_on');?></option>
							</select>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('phones_accounts_modal_name');?>" name="acc2_name">
						</div>
						<div class="col">
							<select class="form-control form-control-sm" name="acc2_voipsrv1">
								<option value="">-- <?=lang('phones_accounts_modal_voipsrv1');?> --</option>
								<? if ($servers_list != FALSE): ?>
								<? foreach($servers_list as $server): ?>
								<option value='<?=$server['id'];?>'><?=$server['name'];?></option>
								<? endforeach; ?>
								<? endif; ?>
							</select>
						</div>
						<div class="col">
							<select class="form-control form-control-sm" name="acc2_voipsrv2">
								<option value="">-- <?=lang('phones_accounts_modal_voipsrv2');?> --</option>
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
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('phones_accounts_modal_userid');?>" name="acc2_userid">
						</div>
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('phones_accounts_modal_authid');?>" name="acc2_authid">
						</div>
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('phones_accounts_modal_password');?>" name="acc2_password">
						</div>
					</div>
					<hr class="hr">
					<!-- Account #3 -->
					<div class="row">
						<div class="col">
							<strong><?=lang('phones_accounts_modal_account');?> #3</strong>
						</div>
						<div class="col">
							&nbsp;
						</div>
						<div class="col">
							<select class="form-control form-control-sm" name="acc3_active">
								<option value="">-- <?=lang('phones_accounts_modal_active');?> --</option>
								<option value='0'><?=lang('phones_accounts_modal_active_off');?></option>
								<option value='1'><?=lang('phones_accounts_modal_active_on');?></option>
							</select>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('phones_accounts_modal_name');?>" name="acc3_name">
						</div>
						<div class="col">
							<select class="form-control form-control-sm" name="acc3_voipsrv1">
								<option value="">-- <?=lang('phones_accounts_modal_voipsrv1');?> --</option>
								<? if ($servers_list != FALSE): ?>
								<? foreach($servers_list as $server): ?>
								<option value='<?=$server['id'];?>'><?=$server['name'];?></option>
								<? endforeach; ?>
								<? endif; ?>
							</select>
						</div>
						<div class="col">
							<select class="form-control form-control-sm" name="acc3_voipsrv2">
								<option value="">-- <?=lang('phones_accounts_modal_voipsrv2');?> --</option>
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
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('phones_accounts_modal_userid');?>" name="acc3_userid">
						</div>
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('phones_accounts_modal_authid');?>" name="acc3_authid">
						</div>
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('phones_accounts_modal_password');?>" name="acc3_password">
						</div>
					</div>
					<hr class="hr">
					<!-- Account #4 -->
					<div class="row">
						<div class="col">
							<strong><?=lang('phones_accounts_modal_account');?> #4</strong>
						</div>
						<div class="col">
							&nbsp;
						</div>
						<div class="col">
							<select class="form-control form-control-sm" name="acc4_active">
								<option value="">-- <?=lang('phones_accounts_modal_active');?> --</option>
								<option value='0'><?=lang('phones_accounts_modal_active_off');?></option>
								<option value='1'><?=lang('phones_accounts_modal_active_on');?></option>
							</select>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('phones_accounts_modal_name');?>" name="acc4_name">
						</div>
						<div class="col">
							<select class="form-control form-control-sm" name="acc4_voipsrv1">
								<option value="">-- <?=lang('phones_accounts_modal_voipsrv1');?> --</option>
								<? if ($servers_list != FALSE): ?>
								<? foreach($servers_list as $server): ?>
								<option value='<?=$server['id'];?>'><?=$server['name'];?></option>
								<? endforeach; ?>
								<? endif; ?>
							</select>
						</div>
						<div class="col">
							<select class="form-control form-control-sm" name="acc4_voipsrv2">
								<option value="">-- <?=lang('phones_accounts_modal_voipsrv2');?> --</option>
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
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('phones_accounts_modal_userid');?>" name="acc4_userid">
						</div>
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('phones_accounts_modal_authid');?>" name="acc4_authid">
						</div>
						<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="<?=lang('phones_accounts_modal_password');?>" name="acc4_password">
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
		modal.find('.modal-title').text('<?=lang("phones_accounts_modal_title_edit");?>')
		$.ajax({
			url: '/phones/ajax/get_accounts/<?=$phone_info["id"];?>',
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