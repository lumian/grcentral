<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<? if ($this->settings_model->syssettings_get('hide_help_header_msg') != 'on'): ?>
<div class="card mt-2">
  <div class="card-body">
    <?=lang('settings_models_description_text');?>
  </div>
</div>
<? endif; ?>

<div class="btn-group btn-group-sm mt-2" role="group">
	<? if ($group_list != FALSE): ?>
	<button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#ModalModelAddEdit" data-bs-actiontype="new"><i class="fa fa-plus-square"></i> <?=lang('settings_models_btn_new');?></button>
	<? endif; ?>
	<button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#ModalGroupAddEdit" data-bs-actiontype="new"><i class="fa fa-folder-plus"></i> <?=lang('settings_models_btn_newgroup');?></button>
	<a href="<?=lang('main_helpurl_settings_models');?>" target="_blank" title="<?=lang('main_helpurl_urltitle');?>" type="button" class="btn btn-outline-info"><i class="fa fa-question-circle"></i></a>
</div>

<? if ($this->session->flashdata('success_result')): ?>
	<div class="alert alert-success mt-2" role="alert"><?=$this->session->flashdata('success_result');?></div>
<? endif;?>

<? if ($this->session->flashdata('error_result')): ?>
	<div class="alert alert-danger mt-2" role="alert"><?=$this->session->flashdata('error_result');?></div>
<? endif;?>

<table class="table table-hover table-bordered table-sm mt-2">
	<thead>
		<th><?=lang('settings_models_table_techname');?></th>
		<th><?=lang('settings_models_table_friendlyname');?></th>
		<th><?=lang('main_table_actions');?></th>
	</thead>
	
	<tbody>
		<? if ($models_list != FALSE): ?>
		<? foreach($models_list as $row): ?>
		<tr>
			<th colspan="2">
				<i class="fa fa-folder-open"></i> <?=$row['group_info']['name'];?> 
				(<?=lang('settings_models_table_params');?>: <? if ($row['group_info']['params_group_id'] != '0') { echo $params_group[$row['group_info']['params_group_id']]['name']; } else { echo lang('settings_modelsgroup_modal_paramgroup_no'); }?>)
			</th>
			<th>
				<div class="btn-group" role="group">
					<button class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#ModalGroupAddEdit" data-bs-actiontype="edit" data-bs-id="<?=$row['group_info']['id'];?>">
						<i class="fa fa-edit"></i> <?=lang('main_btn_edit');?>
					</button>
					<button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#ModalGroupDelete" data-bs-id="<?=$row['group_info']['id'];?>">
						<i class="fa fa-trash-alt"></i> <?=lang('main_btn_del');?>
					</button>
				</div>
			</th>
		</tr>
		<? if ($row['items'] != FALSE): ?>
			<? foreach($row['items'] as $model): ?>
				<tr>
					<td><?=$model['tech_name'];?></td>
					<td><?=$model['friendly_name'];?></td>
					<td>
						<div class="btn-group" role="group">
							<button class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#ModalModelAddEdit" data-bs-actiontype="edit" data-bs-id="<?=$model['id'];?>">
								<i class="fa fa-edit"></i> <?=lang('main_btn_edit');?>
							</button>
							<button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#ModalModelDelete" data-bs-id="<?=$model['id'];?>">
								<i class="fa fa-trash-alt"></i> <?=lang('main_btn_del');?>
							</button>
						</div>
					</td>
				</tr>
			<? endforeach; ?>
		<? else: ?>
		<tr class="table-primary">
			<td colspan="3"><?=lang('settings_models_table_noitemsingroup');?></td>
		</tr>
		<? endif; ?>
		<? endforeach; ?>
		<? else: ?>
		<tr class="table-primary">
			<td colspan="3"><?=lang('main_message_nodata');?></td>
		</tr>
		<? endif; ?>
	</tbody>
</table>

<!-- ModalGroupAddEdit -->
<div class="modal fade" id="ModalGroupAddEdit" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ModalGroupAddEditLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalGroupAddEditLabel">ModalTitle</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="ModalGroupAddEditForm" method="post" action="">
					<div class="row">
						<div class="col-md-12">
							<p class="h5"><?=lang('settings_models_modal_addeditgroup_titlebase');?></p>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-md-6">
							<label for="ModalGroupAddEditForm_Name"><?=lang('settings_models_modal_addeditgroup_groupname');?></label>
							<input type="text" name="name" class="form-control" id="ModalGroupAddEditForm_Name" required>
							<small id="ModalGroupAddEditForm_NameHelp" class="form-text text-muted"><?=lang('settings_models_modal_addeditgroup_groupname_help');?></small>
						</div>
						<div class="col-md-6">
							<label for="ModalGroupAddEditForm_ParamGroup"><?=lang('settings_models_modal_addeditgroup_paramgroup');?></label>
							<select class="form-select" name="params_group_id" id="ModalGroupAddEditForm_ParamGroup" required>
								<option value='0'>--- <?=lang('settings_models_modal_addeditgroup_paramgroup_no');?> ---</option>
								<? foreach($params_group as $param_group): ?>
								<option value='<?=$param_group['id'];?>'><?=$param_group['name'];?></option>
								<? endforeach; ?>
							</select>
							<small id="ModalGroupAddEditForm_ParamGroupHelp" class="form-text text-muted"><?=lang('settings_models_modal_addeditgroup_paramgroup_help');?></small>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-md-12">
							<p class="h5"><?=lang('settings_models_modal_addeditgroup_titlesettings');?></p>
							<small class="form-text text-muted"><?=lang('settings_models_modal_addeditgroup_titlesettings_help');?></small>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-md-6">
							<label for="ModalGroupAddEditForm_params_conf_acc_atatus"><?=lang('settings_models_modal_addeditgroup_params_conf_acc_atatus');?></label>
							<input type="text" name="params_conf_acc_atatus" class="form-control" id="ModalGroupAddEditForm_params_conf_acc_atatus" placeholder="PXXXX" required>
						</div>
						<div class="col-md-6">
							<label for="ModalGroupAddEditForm_params_conf_acc_name"><?=lang('settings_models_modal_addeditgroup_params_conf_acc_name');?></label>
							<input type="text" name="params_conf_acc_name" class="form-control" id="ModalGroupAddEditForm_params_conf_acc_name" placeholder="PXXXX" required>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-md-6">
							<label for="ModalGroupAddEditForm_params_conf_srv_main"><?=lang('settings_models_modal_addeditgroup_params_conf_srv_main');?></label>
							<input type="text" name="params_conf_srv_main" class="form-control" id="ModalGroupAddEditForm_params_conf_srv_main" placeholder="PXXXX" required>
						</div>
						<div class="col-md-6">
							<label for="ModalGroupAddEditForm_params_conf_srv_reserve"><?=lang('settings_models_modal_addeditgroup_params_conf_srv_reserve');?></label>
							<input type="text" name="params_conf_srv_reserve" class="form-control" id="ModalGroupAddEditForm_params_conf_srv_reserve" placeholder="PXXXX" required>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-md-6">
							<label for="ModalGroupAddEditForm_params_conf_sip_userid"><?=lang('settings_models_modal_addeditgroup_params_conf_sip_userid');?></label>
							<input type="text" name="params_conf_sip_userid" class="form-control" id="ModalGroupAddEditForm_params_conf_sip_userid" placeholder="PXXXX" required>
						</div>
						<div class="col-md-6">
							<label for="ModalGroupAddEditForm_params_conf_sip_authid"><?=lang('settings_models_modal_addeditgroup_params_conf_sip_authid');?></label>
							<input type="text" name="params_conf_sip_authid" class="form-control" id="ModalGroupAddEditForm_params_conf_sip_authid" placeholder="PXXXX" required>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-md-6">
							<label for="ModalGroupAddEditForm_params_conf_sip_passwd"><?=lang('settings_models_modal_addeditgroup_params_conf_sip_passwd');?></label>
							<input type="text" name="params_conf_sip_passwd" class="form-control" id="ModalGroupAddEditForm_params_conf_sip_passwd" placeholder="PXXXX" required>
						</div>
						<div class="col-md-6">
							<label for="ModalGroupAddEditForm_params_conf_show_name"><?=lang('settings_models_modal_addeditgroup_params_conf_show_name');?></label>
							<input type="text" name="params_conf_show_name" class="form-control" id="ModalGroupAddEditForm_params_conf_show_name" placeholder="PXXXX" required>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-md-6">
							<label for="ModalGroupAddEditForm_params_conf_acc_display"><?=lang('settings_models_modal_addeditgroup_params_conf_acc_display');?></label>
							<input type="text" name="params_conf_acc_display" class="form-control" id="ModalGroupAddEditForm_params_conf_acc_display" placeholder="PXXXX" required>
						</div>
						<div class="col-md-6">
							<label for="ModalGroupAddEditForm_params_conf_voicemail"><?=lang('settings_models_modal_addeditgroup_params_conf_voicemail');?></label>
							<input type="text" name="params_conf_voicemail" class="form-control" id="ModalGroupAddEditForm_params_conf_voicemail" placeholder="PXXXX" required>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"><?=lang('main_btn_cancel');?></button>
				<button type="submit" class="btn btn-outline-success btn-sm" form="ModalGroupAddEditForm"><?=lang('main_btn_save');?></button>
			</div>
		</div>
	</div>
</div>
<script>
	document.getElementById('ModalGroupAddEdit').addEventListener('show.bs.modal', function (event) {
		var button = event.relatedTarget
		var actiontype = button.getAttribute('data-bs-actiontype')
		var groupid = button.getAttribute('data-bs-id')
		var modal = $(this)
		if (actiontype == "new") {
			modal.find('.modal-title').text('<?=lang("settings_models_modal_addeditgroup_titleadd");?>')
			modal.find('.modal-body input').val('')
			modal.find('.modal-body select').val('0')
			modal.find('.modal-body form').attr('action', '<?=site_url("settings/models/add_group/");?>')
		} 
		if (actiontype == "edit") {
			modal.find('.modal-title').text('<?=lang("settings_models_modal_addeditgroup_titleedit");?>')
			$.ajax({
				url: '<?=site_url("settings/ajax/models/get_group/");?>' + groupid,
				dataType: 'json',
				success: function(data) {
					if (data.result == 'success') {
						modal.find('.modal-body input[name=name]').val(data.data.name)
						modal.find('.modal-body select[name=params_group_id]').val(data.data.params_group_id)
						modal.find('.modal-body input[name=params_conf_acc_atatus]').val(data.data.params_conf_acc_atatus)
						modal.find('.modal-body input[name=params_conf_acc_name]').val(data.data.params_conf_acc_name)
						modal.find('.modal-body input[name=params_conf_srv_main]').val(data.data.params_conf_srv_main)
						modal.find('.modal-body input[name=params_conf_srv_reserve]').val(data.data.params_conf_srv_reserve)
						modal.find('.modal-body input[name=params_conf_sip_userid]').val(data.data.params_conf_sip_userid)
						modal.find('.modal-body input[name=params_conf_sip_authid]').val(data.data.params_conf_sip_authid)
						modal.find('.modal-body input[name=params_conf_sip_passwd]').val(data.data.params_conf_sip_passwd)
						modal.find('.modal-body input[name=params_conf_show_name]').val(data.data.params_conf_show_name)
						modal.find('.modal-body input[name=params_conf_acc_display]').val(data.data.params_conf_acc_display)
						modal.find('.modal-body input[name=params_conf_voicemail]').val(data.data.params_conf_voicemail)
						modal.find('.modal-body form').attr('action', '<?=site_url("settings/models/edit_group/");?>' + groupid)
					} else {
						alert('<?=lang("main_error_ajaxload");?>')
					}
				},
			});
		}
	})
</script>

<!-- ModalGroupDelete -->
<div class="modal fade" id="ModalGroupDelete" tabindex="-1" role="dialog" aria-labelledby="ModalGroupDeleteLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalGroupDeleteLabel"><?=lang('settings_models_modal_delgroup_title');?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<?=lang('settings_models_modal_delgroup_confirm');?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"><?=lang('main_btn_cancel');?></button>
				<a type="button" class="btn btn-outline-warning btn-sm" href="#"><?=lang('main_btn_del');?></a>
			</div>
		</div>
	</div>
</div>
<script>
	document.getElementById('ModalGroupDelete').addEventListener('show.bs.modal', function (event) {
		var button = event.relatedTarget
		var groupid = button.getAttribute('data-bs-id')
		var modal = $(this)
		modal.find('.modal-footer a').attr('href', '<?=site_url("settings/models/del_group/");?>' + groupid)
	})
</script>

<? if ($group_list != FALSE): ?>

<!-- ModalModelAddEdit -->
<div class="modal fade" id="ModalModelAddEdit" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ModalModelAddEditLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalModelAddEditLabel">ModalTitle</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="ModalModelAddEditForm" method="post" action="">
					<div>
						<label for="ModalModelAddEditForm_TechName"><?=lang('settings_models_modal_addedit_techname');?></label>
						<input type="text" name="tech_name" class="form-control" id="ModalModelAddEditForm_TechName" required>
						<small id="ModalModelAddEditForm_TechNameHelp" class="form-text text-muted"><?=lang('settings_models_modal_addedit_techname_help');?></small>
					</div>
					<div class="mt-2">
						<label for="ModalModelAddEditForm_FriendlyName"><?=lang('settings_models_modal_addedit_friendlyname');?></label>
						<input type="text" name="friendly_name" class="form-control" id="ModalModelAddEditForm_FriendlyName" required>
						<small id="ModalModelAddEditForm_FriendlyNameHelp" class="form-text text-muted"><?=lang('settings_models_modal_addedit_friendlyname_help');?></small>
					</div>
					<div class="mt-2">
						<label for="ModalModelAddEditForm_Group"><?=lang('settings_models_modal_addedit_group');?></label>
						<select class="form-select" name="group_id" id="ModalModelAddEditForm_Group" required>
							<? foreach($group_list as $group): ?>
							<option value='<?=$group['id'];?>'><?=$group['name'];?></option>
							<? endforeach; ?>
						</select>
						<small id="ModalModelAddEditForm_GroupHelp" class="form-text text-muted"><?=lang('settings_models_modal_addedit_group_help');?></small>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"><?=lang('main_btn_cancel');?></button>
				<button type="submit" class="btn btn-outline-success btn-sm" form="ModalModelAddEditForm"><?=lang('main_btn_save');?></button>
			</div>
		</div>
	</div>
</div>

<script>
	document.getElementById('ModalModelAddEdit').addEventListener('show.bs.modal', function (event) {
		var button = event.relatedTarget
		var actiontype = button.getAttribute('data-bs-actiontype')
		var modelid = button.getAttribute('data-bs-id')
		var modal = $(this)
		if (actiontype == "new") {
			modal.find('.modal-title').text('<?=lang("settings_models_modal_addedit_titleadd");?>')
			modal.find('.modal-body input').val('')
			modal.find('.modal-body form').attr('action', '<?=site_url("settings/models/add/");?>')
		} 
		if (actiontype == "edit") {
			modal.find('.modal-title').text('<?=lang("settings_models_modal_addedit_titleedit");?>')
			$.ajax({
				url: '<?=site_url("settings/ajax/models/get/");?>' + modelid,
				dataType: 'json',
				success: function(responce) {
					if (responce.result == 'success') {
						modal.find('.modal-body input[name=tech_name]').val(responce.data.tech_name)
						modal.find('.modal-body input[name=friendly_name]').val(responce.data.friendly_name)
						modal.find('.modal-body select[name=group_id]').val(responce.data.group_id)
						modal.find('.modal-body form').attr('action', '<?=site_url("settings/models/edit/");?>' + modelid)
					} else {
						alert('<?=lang("main_error_ajaxload");?>')
					}
				},
			});
		}
	})
</script>

<!-- ModalModelDelete -->
<div class="modal fade" id="ModalModelDelete" tabindex="-1" role="dialog" aria-labelledby="ModalModelDeleteLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalModelDeleteLabel"><?=lang('settings_models_modal_del_title');?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<?=lang('settings_models_modal_del_confirm');?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"><?=lang('main_btn_cancel');?></button>
				<a type="button" class="btn btn-outline-warning btn-sm" href="#"><?=lang('main_btn_del');?></a>
			</div>
		</div>
	</div>
</div>
<script>
	document.getElementById('ModalModelDelete').addEventListener('show.bs.modal', function (event) {
		var button = event.relatedTarget
		var modelid = button.getAttribute('data-bs-id')
		var modal = $(this)
		modal.find('.modal-footer a').attr('href', '<?=site_url("settings/models/del/");?>' + modelid)
	})
</script>

<? endif;?>