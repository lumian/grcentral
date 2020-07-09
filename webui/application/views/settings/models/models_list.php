<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="card mt-2">
  <div class="card-body">
    <?=lang('settings_models_description');?>
  </div>
</div>

<? if ($group_list != FALSE): ?>
<button type="button" class="btn btn-success btn-sm mt-2" data-toggle="modal" data-target="#ModalModelAddEdit" data-actiontype="new"><i class="fa fa-plus-square"></i> <?=lang('settings_models_btn_new');?></button>
<? endif; ?>
<button type="button" class="btn btn-success btn-sm mt-2" data-toggle="modal" data-target="#ModalGroupAddEdit" data-actiontype="new"><i class="fa fa-folder-plus"></i> <?=lang('settings_modelsgroup_btn_new');?></button>

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
		<thead>
		<tr>
			<th colspan="2">
				<i class="fa fa-folder-open"></i> <?=$row['group_info']['name'];?> 
				(<?=lang('settings_models_table_params');?>: <? if ($row['group_info']['params_group_id'] != '0') { echo $params_group[$row['group_info']['params_group_id']]['name']; } else { echo lang('settings_modelsgroup_modal_paramgroup_no'); }?>)
			</th>
			<th>
				<div class="btn-group btn-block" role="group">
					<button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#ModalGroupAddEdit" data-actiontype="edit" data-id="<?=$row['group_info']['id'];?>">
						<i class="fa fa-edit"></i> <?=lang('main_btn_edit');?>
					</button>
					<button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#ModalGroupDelete" data-id="<?=$row['group_info']['id'];?>">
						<i class="fa fa-trash-alt"></i> <?=lang('main_btn_del');?>
					</button>
				</div>
			</th>
		</tr>
		</thead>
		<? if ($row['items'] != FALSE): ?>
			<? foreach($row['items'] as $model): ?>
				<tr>
					<td><?=$model['tech_name'];?></td>
					<td><?=$model['friendly_name'];?></td>
					<td>
						<div class="btn-group btn-block" role="group">
							<button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#ModalModelAddEdit" data-actiontype="edit" data-id="<?=$model['id'];?>">
								<i class="fa fa-edit"></i> <?=lang('main_btn_edit');?>
							</button>
							<button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#ModalModelDelete" data-id="<?=$model['id'];?>">
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
<div class="modal fade" id="ModalGroupAddEdit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ModalGroupAddEditLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalGroupAddEditLabel">ModalTitle</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="ModalGroupAddEditForm" method="post" action="">
					<div class="form-group">
						<label for="ModalGroupAddEditForm_Name"><?=lang('settings_modelsgroup_modal_groupname');?></label>
						<input type="text" name="name" class="form-control" id="ModalGroupAddEditForm_Name" required>
						<small id="ModalGroupAddEditForm_NameHelp" class="form-text text-muted"><?=lang('settings_modelsgroup_modal_groupname_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalGroupAddEditForm_ParamGroup"><?=lang('settings_modelsgroup_modal_paramgroup');?></label>
						<select class="form-control" name="params_group_id" id="ModalGroupAddEditForm_ParamGroup" required>
							<option value='0'>--- <?=lang('settings_modelsgroup_modal_paramgroup_no');?> ---</option>
							<? foreach($params_group as $param_group): ?>
							<option value='<?=$param_group['id'];?>'><?=$param_group['name'];?></option>
							<? endforeach; ?>
						</select>
						<small id="ModalGroupAddEditForm_ParamGroupHelp" class="form-text text-muted"><?=lang('settings_modelsgroup_modal_paramgroup_help');?></small>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><?=lang('main_btn_cancel');?></button>
				<button type="submit" class="btn btn-success btn-sm" form="ModalGroupAddEditForm"><?=lang('main_btn_save');?></button>
			</div>
		</div>
	</div>
</div>
<script>
	$('#ModalGroupAddEdit').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var actiontype = button.data('actiontype')
		var groupid = button.data('id')
		var modal = $(this)
		if (actiontype == "new") {
			modal.find('.modal-title').text('<?=lang("settings_modelsgroup_modal_title_add");?>')
			modal.find('.modal-body input').val('')
			modal.find('.modal-body form').attr('action', '/settings/models/add_group/')
		} 
		if (actiontype == "edit") {
			modal.find('.modal-title').text('<?=lang("settings_modelsgroup_modal_title_edit");?>')
			$.ajax({
				url: '/settings/ajax/models/get_group/' + groupid,
				dataType: 'json',
				success: function(data) {
					if (data.result == 'success') {
						modal.find('.modal-body input[name=name]').val(data.data.name)
						modal.find('.modal-body select[name=params_group_id]').val(data.data.params_group_id)
						modal.find('.modal-body form').attr('action', '/settings/models/edit_group/' + groupid)
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
				<h5 class="modal-title" id="ModalGroupDeleteLabel"><?=lang('settings_modelsgroup_modal_title_del');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?=lang('settings_modelsgroup_modal_confirm_del');?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><?=lang('main_btn_cancel');?></button>
				<a type="button" class="btn btn-warning btn-sm" href="#"><?=lang('main_btn_del');?></a>
			</div>
		</div>
	</div>
</div>
<script>
	$('#ModalGroupDelete').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var groupid = button.data('id')
		var modal = $(this)
		modal.find('.modal-footer a').attr('href', '/settings/models/del_group/' + groupid)
	})
</script>

<? if ($group_list != FALSE): ?>

<!-- ModalModelAddEdit -->
<div class="modal fade" id="ModalModelAddEdit" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ModalModelAddEditLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalModelAddEditLabel">ModalTitle</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="ModalModelAddEditForm" method="post" action="">
					<div class="form-group">
						<label for="ModalModelAddEditForm_TechName"><?=lang('settings_models_modal_techname');?></label>
						<input type="text" name="tech_name" class="form-control" id="ModalModelAddEditForm_TechName" required>
						<small id="ModalModelAddEditForm_TechNameHelp" class="form-text text-muted"><?=lang('settings_models_modal_techname_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalModelAddEditForm_FriendlyName"><?=lang('settings_models_modal_friendlyname');?></label>
						<input type="text" name="friendly_name" class="form-control" id="ModalModelAddEditForm_FriendlyName" required>
						<small id="ModalModelAddEditForm_FriendlyNameHelp" class="form-text text-muted"><?=lang('settings_models_modal_friendlyname_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalModelAddEditForm_Group"><?=lang('settings_models_modal_group');?></label>
						<select class="form-control" name="group_id" id="ModalModelAddEditForm_Group" required>
							<? foreach($group_list as $group): ?>
							<option value='<?=$group['id'];?>'><?=$group['name'];?></option>
							<? endforeach; ?>
						</select>
						<small id="ModalModelAddEditForm_GroupHelp" class="form-text text-muted"><?=lang('settings_models_modal_group_help');?></small>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><?=lang('main_btn_cancel');?></button>
				<button type="submit" class="btn btn-success btn-sm" form="ModalModelAddEditForm"><?=lang('main_btn_save');?></button>
			</div>
		</div>
	</div>
</div>

<script>
	$('#ModalModelAddEdit').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var actiontype = button.data('actiontype')
		var modelid = button.data('id')
		var modal = $(this)
		if (actiontype == "new") {
			modal.find('.modal-title').text('<?=lang("settings_models_modal_title_add");?>')
			modal.find('.modal-body input').val('')
			modal.find('.modal-body form').attr('action', '/settings/models/add/')
		} 
		if (actiontype == "edit") {
			modal.find('.modal-title').text('<?=lang("settings_models_modal_title_edit");?>')
			$.ajax({
				url: '/settings/ajax/models/get/' + modelid,
				dataType: 'json',
				success: function(responce) {
					if (responce.result == 'success') {
						modal.find('.modal-body input[name=tech_name]').val(responce.data.tech_name)
						modal.find('.modal-body input[name=friendly_name]').val(responce.data.friendly_name)
						modal.find('.modal-body select[name=group_id]').val(responce.data.group_id)
						modal.find('.modal-body form').attr('action', '/settings/models/edit/' + modelid)
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
				<h5 class="modal-title" id="ModalModelDeleteLabel"><?=lang('settings_models_modal_title_del');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?=lang('settings_models_modal_confirm_del');?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><?=lang('main_btn_cancel');?></button>
				<a type="button" class="btn btn-warning btn-sm" href="#"><?=lang('main_btn_del');?></a>
			</div>
		</div>
	</div>
</div>
<script>
	$('#ModalModelDelete').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var modelid = button.data('id')
		var modal = $(this)
		modal.find('.modal-footer a').attr('href', '/settings/models/del/' + modelid)
	})
</script>
<? endif;?>