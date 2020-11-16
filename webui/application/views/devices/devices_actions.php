<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- ModalAddEdit -->
<div class="modal fade" id="ModalAddEdit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ModalAddEditLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalAddEditLabel">ModalTitle</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="ModalAddEditForm" method="post" action="">
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="ModalAddEditForm_MacAddr"><?=lang('devices_index_modaladdedit_mac_addr');?></label>
								<input type="text" name="mac_addr" class="form-control" id="ModalAddEditForm_MacAddr" required>
								<small id="ModalAddEditForm_MacAddrHelp" class="form-text text-muted"><?=lang('devices_index_modaladdedit_mac_addr_help');?></small>
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<label for="ModalAddEditForm_IPAddr"><?=lang('devices_index_modaladdedit_ip_addr');?></label>
								<input type="text" name="ip_addr" class="form-control" id="ModalAddEditForm_IPAddr" required>
								<small id="ModalAddEditForm_IPAddrHelp" class="form-text text-muted"><?=lang('devices_index_modaladdedit_ip_addr_help');?></small>
							</div>
						</div>
						<div class="col">
							<div class="form-group">
								<label for="ModalAddEditForm_Descr"><?=lang('devices_index_modaladdedit_descr');?></label>
								<input type="text" name="descr" class="form-control" id="ModalAddEditForm_Descr">
								<small id="ModalAddEditForm_DescrHelp" class="form-text text-muted"><?=lang('devices_index_modaladdedit_descr_help');?></small>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
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
						</div>
						<div class="col">
							<div class="form-group">
								<label for="ModalAddEditForm_StatusActive"><?=lang('devices_index_modaladdedit_statusactive');?></label>
								<select class="form-control" name="status_active" id="ModalAddEditForm_StatusActive" required>
									<option value='0'><?=lang('devices_index_modaladdedit_statusactive_off');?></option>
									<option value='1'><?=lang('devices_index_modaladdedit_statusactive_on');?></option>
								</select>
								<small id="ModalAddEditForm_StatusActiveHelp" class="form-text text-muted"><?=lang('devices_index_modaladdedit_statusactive_help');?></small>
							</div>
						</div>
						<div class="col">
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
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="form-group">
								<label for="ModalAddEditForm_Params"><?=lang('devices_index_modaladdedit_params');?></label>
								<textarea name="params_source_data" class="form-control" id="ModalAddEditForm_Params" rows="10"></textarea>
								<small id="ModalAddEditForm_ParamsHelp" class="form-text text-muted"><?=lang('devices_index_modaladdedit_params_help');?></small>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal"><?=lang('main_btn_cancel');?></button>
				<button type="submit" class="btn btn-outline-success btn-sm" form="ModalAddEditForm"><?=lang('main_btn_save');?></button>
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
			modal.find('.modal-body textarea').val('')
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
						modal.find('.modal-body textarea[name=params_source_data]').val(data.data.params_source_data)
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