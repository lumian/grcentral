<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="card mt-2">
	<div class="card-body">
		<img src="<?=base_url('style/img/grandstream_logo.png');?>" width="200px" class="rounded float-left mr-4" alt="Grandstream logo">
		<?=lang('devices_index_description_text');?>
	</div>
</div>

<button type="button" class="btn btn-success btn-sm mt-2" data-toggle="modal" data-target="#ModalAddEdit" data-actiontype="new"><i class="fa fa-plus-square"></i> <?=lang('devices_index_btn_new');?></button>

<? if ($this->session->flashdata('success_result')): ?>
	<div class="alert alert-success mt-2" role="alert"><?=$this->session->flashdata('success_result');?></div>
<? endif;?>

<? if ($this->session->flashdata('error_result')): ?>
	<div class="alert alert-danger mt-2" role="alert"><?=$this->session->flashdata('error_result');?></div>
<? endif;?>

<table class="table table-hover table-bordered table-sm mt-2">
	<thead>
		<th>#</th>
		<th><?=lang('devices_index_table_descr');?></th>
		<th><?=lang('devices_index_table_macaddr');?></th>
		<th><?=lang('devices_index_table_ipaddr');?></th>
		<th><?=lang('devices_index_table_model');?></th>
		<th><?=lang('devices_index_table_accounts');?></th>
		<th><?=lang('devices_index_table_fwversion');?></th>
		<th><?=lang('main_table_actions');?></th>
	</thead>
	
	<tbody>
		<? if ($devices_list != FALSE): ?>
			<? $device_count = 0; ?>
			<? foreach($devices_list as $device): ?>
				<? $device_count = $device_count +1; ?>
				<? if ($device['status_active'] === '0'): ?><tr class="table-active"><? else: ?><tr><? endif;?>
					<td><?=$device_count;?></td>
					<td><?=$device['descr'];?></td>
					<td><?=$device['mac_addr'];?></td>
					<? if ($device['status_online'] === '1'): ?><td><? else: ?><td class="table-warning"><? endif; ?>
						<a href="<?=prep_url($device['ip_addr']);?>" target="_blank" title="<?=lang('devices_index_table_ipaddr_linktitle');?>"><?=$device['ip_addr'];?></a>
					</td>
					<td>
						<? if ($device['model_id'] != '0' AND isset($models_list[$device['model_id']])): ?>
							<?=$models_list[$device['model_id']]['friendly_name'];?>
						<? else: ?>
							<?=lang('devices_index_table_model_na');?>
						<? endif; ?>
					</td>
					<td>
						<? if (isset($device['accounts_data']) AND json_decode($device['accounts_data']) != NULL): ?>
							<? foreach(json_decode($device['accounts_data'], TRUE) as $account): ?>
								<?=$account['userid'];?>&nbsp;
							<? endforeach; ?>
						<? else: ?>
							<?=lang('devices_index_table_accounts_na');?>
						<? endif;?>
					</td>
					<td>
						<? if (isset($device['fw_version']) AND $device['fw_version'] != ''): ?>
							<?=$device['fw_version'];?>
						<? else: ?>
							<?=lang('devices_index_table_fwversion_na');?>
						<? endif; ?>
						<? if (isset($device['fw_version_pinned']) AND $device['fw_version_pinned'] != '0'): ?>
							<span data-toggle="tooltip" title="<?=lang('devices_index_table_fwversionpinned_help');?>: <?=$device['fw_version_pinned'];?>"><i class="fa fa-lock"></i></span>
						<? endif; ?>
					</td>
					<td>
						<div class="btn-group btn-block" role="group">
							<a href="<?=site_url('devices/info/'.$device['id']);?>" type="button" class="btn btn-outline-info btn-xs" title="<?=lang('devices_index_btn_infotitle');?>">
								<i class="fa fa-info"></i>
							</a>
							<button type="button" class="btn btn-outline-info btn-xs" data-toggle="modal" data-target="#ModalAddEdit" data-actiontype="edit" data-id="<?=$device['id'];?>" title="<?=lang('main_btn_edit');?>">
								<i class="fa fa-edit"></i>
							</button>
							<button type="button" class="btn btn-outline-danger btn-xs" data-toggle="modal" data-target="#ModalDelete" data-id="<?=$device['id'];?>" title="<?=lang('main_btn_del');?>">
								<i class="fa fa-trash-alt"></i>
							</button>
						</div>
					</td>
				</tr>
			<? endforeach; ?>
		<? else: ?>
			<tr class="table-primary">
				<td colspan="6"><?=lang('main_message_nodata');?></td>
			</tr>
		<? endif; ?>
	</tbody>
</table>

<!-- ModalAddEdit -->
<div class="modal fade" id="ModalAddEdit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ModalAddEditLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalAddEditLabel">ModalTitle</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="ModalAddEditForm" method="post" action="">
					<div class="form-group">
						<label for="ModalAddEditForm_MacAddr"><?=lang('devices_index_modaladdedit_mac_addr');?></label>
						<input type="text" name="mac_addr" class="form-control" id="ModalAddEditForm_MacAddr" required>
						<small id="ModalAddEditForm_MacAddrHelp" class="form-text text-muted"><?=lang('devices_index_modaladdedit_mac_addr_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalAddEditForm_IPAddr"><?=lang('devices_index_modaladdedit_ip_addr');?></label>
						<input type="text" name="ip_addr" class="form-control" id="ModalAddEditForm_IPAddr" required>
						<small id="ModalAddEditForm_IPAddrHelp" class="form-text text-muted"><?=lang('devices_index_modaladdedit_ip_addr_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalAddEditForm_Model"><?=lang('devices_index_modaladdedit_model');?></label>
						<select class="form-control" name="model_id" id="ModalAddEditForm_Model" required>
							<option value='0'>--- <?=lang('devices_index_modaladdedit_model_na');?> ---</option>
							<? if ($models_list != FALSE): ?>
								<? foreach($models_list as $model): ?>
									<option value='<?=$model['id'];?>'><?=$model['friendly_name'];?></option>
								<? endforeach; ?>
							<? endif; ?>
						</select>
						<small id="ModalAddEditForm_ModelHelp" class="form-text text-muted"><?=lang('devices_index_modaladdedit_model_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalAddEditForm_Descr"><?=lang('devices_index_modaladdedit_descr');?></label>
						<input type="text" name="descr" class="form-control" id="ModalAddEditForm_Descr">
						<small id="ModalAddEditForm_DescrHelp" class="form-text text-muted"><?=lang('devices_index_modaladdedit_descr_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalAddEditForm_StatusActive"><?=lang('devices_index_modaladdedit_statusactive');?></label>
						<select class="form-control" name="status_active" id="ModalAddEditForm_StatusActive" required>
							<option value='0'><?=lang('devices_index_modaladdedit_statusactive_off');?></option>
							<option value='1'><?=lang('devices_index_modaladdedit_statusactive_on');?></option>
						</select>
						<small id="ModalAddEditForm_StatusActiveHelp" class="form-text text-muted"><?=lang('devices_index_modaladdedit_statusactive_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalAddEditForm_FWVersionPinned"><?=lang('devices_index_modaladdedit_fwversionpinned');?></label>
						<select class="form-control" name="fw_version_pinned" id="ModalAddEditForm_FWVersionPinned" required>
							<option value='0'>--- <?=lang('devices_index_modaladdedit_fwversionpinned_off');?> ---</option>
							<? if ($fw_list != FALSE): ?>
								<? foreach($fw_list as $row): ?>
									<? if ($row['items'] != FALSE): ?>
										<? foreach ($row['items'] as $fw): ?>
											<option value='<?=$fw['version'];?>'><?=$row['group_info']['name'];?>: <?=$fw['version'];?></option>
										<? endforeach;?>
									<? endif; ?>
								<? endforeach; ?>
							<? endif; ?>
						</select>
						<small id="ModalAddEditForm_FWVersionPinnedHelp" class="form-text text-muted"><?=lang('devices_index_modaladdedit_fwversionpinned_help');?></small>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><?=lang('main_btn_cancel');?></button>
				<button type="submit" class="btn btn-success btn-sm" form="ModalAddEditForm"><?=lang('main_btn_save');?></button>
			</div>
		</div>
	</div>
</div>
<script>
	$('#ModalAddEdit').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var actiontype = button.data('actiontype')
		var phoneid = button.data('id')
		var modal = $(this)
		if (actiontype == "new") {
			modal.find('.modal-title').text('<?=lang("devices_index_modaladdedit_titleadd");?>')
			modal.find('.modal-body input').val('')
			modal.find('.modal-body select').val('')
			modal.find('.modal-body form').attr('action', '<?=site_url("devices/actions/add/")?>')
		} 
		if (actiontype == "edit") {
			modal.find('.modal-title').text('<?=lang("devices_index_modaladdedit_titleedit");?>')
			$.ajax({
				url: '<?=site_url("devices/ajax/get/")?>' + phoneid,
				dataType: 'json',
				success: function(data) {
					if (data.result == 'success') {
						modal.find('.modal-body input[name=mac_addr]').val(data.data.mac_addr)
						modal.find('.modal-body input[name=ip_addr]').val(data.data.ip_addr)
						modal.find('.modal-body input[name=descr]').val(data.data.descr)
						modal.find('.modal-body select[name=model_id]').val(data.data.model_id)
						modal.find('.modal-body select[name=status_active]').val(data.data.status_active)
						modal.find('.modal-body select[name=fw_version_pinned]').val(data.data.fw_version_pinned)
						modal.find('.modal-body form').attr('action', '<?=site_url("devices/actions/edit/")?>' + phoneid)
					} else {
						alert('<?=lang("main_error_ajaxload");?>')
					}
				},
			});
		}
	})
</script>

<!-- ModalDelete -->
<div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="ModalDeleteLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalDeleteLabel"><?=lang('devices_index_modaldel_title');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?=lang('devices_index_modaldel_confirm');?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><?=lang('main_btn_cancel');?></button>
				<a type="button" class="btn btn-warning btn-sm" href="#"><?=lang('main_btn_del');?></a>
			</div>
		</div>
	</div>
</div>
<script>
	$('#ModalDelete').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var phoneid = button.data('id')
		var modal = $(this)
		modal.find('.modal-footer a').attr('href', '<?=site_url("devices/actions/del/")?>' + phoneid)
	})
</script>