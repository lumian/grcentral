<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="card mt-2">
  <div class="card-body">
    <img src="/style/img/grandstream_logo.png" width="200px" class="rounded float-left mr-4" alt="Grandstream logo">
	<?=lang('phones_description');?>
  </div>
</div>

<button type="button" class="btn btn-success btn-sm mt-2" data-toggle="modal" data-target="#ModalAddEdit" data-actiontype="new"><?=lang('phones_btn_new');?></button>

<? if ($this->session->flashdata('success_result')): ?>
<div class="alert alert-success mt-2" role="alert"><?=$this->session->flashdata('success_result');?></div>
<? endif;?>

<? if ($this->session->flashdata('error_result')): ?>
<div class="alert alert-danger mt-2" role="alert"><?=$this->session->flashdata('error_result');?></div>
<? endif;?>

<table class="table table-hover table-sm mt-2">
	<thead>
		<th>#</th>
		<th><?=lang('phones_table_descr');?></th>
		<th><?=lang('phones_table_mac_addr');?></th>
		<th><?=lang('phones_table_ip_addr');?></th>
		<th><?=lang('phones_table_model');?></th>
		<th><?=lang('phones_table_accounts');?></th>
		<th><?=lang('phones_table_fwversion');?></th>
		<th><?=lang('main_table_actions');?></th>
	</thead>
	
	<tbody>
		<? if ($phones_list != FALSE): ?>
			<? $device_count = 0; ?>
			<? foreach($phones_list as $phone): ?>
				<? $device_count = $device_count +1; ?>
				<? if ($phone['status_active'] === '0'): ?><tr class="table-active"><? else: ?><tr><? endif;?>
					<td><?=$device_count;?></td>
					<td><?=$phone['descr'];?></td>
					<td><?=$phone['mac_addr'];?></td>
					<? if ($phone['status_online'] === '1'): ?><td><? else: ?><td class="table-warning"><? endif; ?>
						<a href="http://<?=$phone['ip_addr'];?>/" target="_blank" title="<?=lang('phones_table_ip_addr_linktitle');?>"><?=$phone['ip_addr'];?></a>
					</td>
					<td>
						<? if ($phone['model_id'] != '0'): ?>
							<?=$phone['model_friendly_name'];?>
						<? else: ?>
							<?=lang('phones_table_model_na');?>
						<? endif; ?>
					</td>
					<td>
						<? if (isset($phone['accounts_data']) AND json_decode($phone['accounts_data']) != NULL): ?>
							<? foreach(json_decode($phone['accounts_data'], TRUE) as $account): ?>
								<?=$account['userid'];?>&nbsp;
							<? endforeach; ?>
						<? else: ?>
							<?=lang('phones_table_accounts_na');?>
						<? endif;?>
					</td>
					<td>
						<? if (isset($phone['fw_version']) AND $phone['fw_version'] != ''): ?>
							<?=$phone['fw_version'];?>
						<? else: ?>
							<?=lang('phones_table_fwversion_na');?>
						<? endif; ?>
						<? if (isset($phone['fw_version_pinned']) AND $phone['fw_version_pinned'] != '0'): ?>
							<span data-toggle="tooltip" data-html="true" title="<?=lang('phones_table_fwversionpinned_help');?>: <?=$phone['fw_version_pinned'];?>"><i class="fa fa-lock"></i></span>
						<? endif; ?>
					</td>
					<td>
						<div class="btn-group" role="group">
							<a href="/phones/info/<?=$phone['id'];?>" type="button" class="btn btn-outline-info btn-sm">
								<?=lang('phones_btn_info');?>
							</a>
							<button type="button" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#ModalAddEdit" data-actiontype="edit" data-id="<?=$phone['id'];?>">
								<?=lang('main_btn_edit');?>
							</button>
							<button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#ModalDelete" data-id="<?=$phone['id'];?>">
								<?=lang('main_btn_del');?>
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
						<label for="ModalAddEditForm_MacAddr"><?=lang('phones_modal_mac_addr');?></label>
						<input type="text" name="mac_addr" class="form-control" id="ModalAddEditForm_MacAddr" required>
						<small id="ModalAddEditForm_MacAddrHelp" class="form-text text-muted"><?=lang('phones_modal_mac_addr_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalAddEditForm_IPAddr"><?=lang('phones_modal_ip_addr');?></label>
						<input type="text" name="ip_addr" class="form-control" id="ModalAddEditForm_IPAddr" required>
						<small id="ModalAddEditForm_IPAddrHelp" class="form-text text-muted"><?=lang('phones_modal_ip_addr_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalAddEditForm_Model"><?=lang('phones_modal_model');?></label>
						<select class="form-control" name="model_id" id="ModalAddEditForm_Model" required>
							<option value='0'>--- <?=lang('phones_modal_model_na');?> ---</option>
							<? if ($models_list != FALSE): ?>
								<? foreach($models_list as $model): ?>
									<option value='<?=$model['id'];?>'><?=$model['friendly_name'];?></option>
								<? endforeach; ?>
							<? endif; ?>
						</select>
						<small id="ModalAddEditForm_ModelHelp" class="form-text text-muted"><?=lang('phones_modal_model_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalAddEditForm_Descr"><?=lang('phones_modal_descr');?></label>
						<input type="text" name="descr" class="form-control" id="ModalAddEditForm_Descr">
						<small id="ModalAddEditForm_DescrHelp" class="form-text text-muted"><?=lang('phones_modal_descr_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalAddEditForm_StatusActive"><?=lang('phones_modal_status_active');?></label>
						<select class="form-control" name="status_active" id="ModalAddEditForm_StatusActive" required>
							<option value='0'><?=lang('phones_modal_status_active_off');?></option>
							<option value='1'><?=lang('phones_modal_status_active_on');?></option>
						</select>
						<small id="ModalAddEditForm_StatusActiveHelp" class="form-text text-muted"><?=lang('phones_modal_status_active_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalAddEditForm_FWVersionPinned"><?=lang('phones_modal_fwversionpinned');?></label>
						<select class="form-control" name="fw_version_pinned" id="ModalAddEditForm_FWVersionPinned" required>
							<option value='0'>--- <?=lang('phones_modal_fwversionpinned_off');?> ---</option>
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
						<small id="ModalAddEditForm_FWVersionPinnedHelp" class="form-text text-muted"><?=lang('phones_modal_fwversionpinned_help');?></small>
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
			modal.find('.modal-title').text('<?=lang("phones_modal_title_add");?>')
			modal.find('.modal-body input').val('')
			modal.find('.modal-body select').val('')
			modal.find('.modal-body form').attr('action', '/phones/actions/add/')
		} 
		if (actiontype == "edit") {
			modal.find('.modal-title').text('<?=lang("phones_modal_title_edit");?>')
			$.ajax({
				url: '/phones/ajax/get/' + phoneid,
				dataType: 'json',
				success: function(data) {
					if (data.result == 'success') {
						modal.find('.modal-body input[name=mac_addr]').val(data.data.mac_addr)
						modal.find('.modal-body input[name=ip_addr]').val(data.data.ip_addr)
						modal.find('.modal-body input[name=descr]').val(data.data.descr)
						modal.find('.modal-body select[name=model_id]').val(data.data.model_id)
						modal.find('.modal-body select[name=status_active]').val(data.data.status_active)
						modal.find('.modal-body select[name=fw_version_pinned]').val(data.data.fw_version_pinned)
						modal.find('.modal-body form').attr('action', '/phones/actions/edit/' + phoneid)
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
				<h5 class="modal-title" id="ModalDeleteLabel"><?=lang('phones_modal_title_del');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?=lang('phones_modal_confirm_del');?>
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
		modal.find('.modal-footer a').attr('href', '/phones/actions/del/' + phoneid)
	})
</script>

<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>