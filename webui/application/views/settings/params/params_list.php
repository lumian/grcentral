<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<? if ($this->settings_model->syssettings_get('hide_help_header_msg') != 'on'): ?>
<div class="card mt-2">
  <div class="card-body">
    <?=lang('settings_params_description_text');?>
  </div>
</div>
<? endif; ?>

<div class="btn-group btn-group-sm mt-2" role="group">
	<button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#ModalAddEdit" data-bs-actiontype="new"><i class="fa fa-plus-square"></i> <?=lang('settings_params_btn_new');?></button>
	<a href="<?=lang('main_helpurl_settings_params');?>" target="_blank" title="<?=lang('main_helpurl_urltitle');?>" type="button" class="btn btn-outline-secondary"><i class="fa fa-question-circle"></i></a>
</div>


<? if ($this->session->flashdata('success_result')): ?>
<div class="alert alert-success mt-2" role="alert"><?=$this->session->flashdata('success_result');?></div>
<? endif;?>

<? if ($this->session->flashdata('error_result')): ?>
<div class="alert alert-danger mt-2" role="alert"><?=$this->session->flashdata('error_result');?></div>
<? endif;?>

<table class="table table-hover table-bordered table-sm mt-2">
	<thead>
		<th><?=lang('settings_params_table_name');?></th>
		<th><?=lang('settings_params_table_description');?></th>
		<th><?=lang('main_table_actions');?></th>
	</thead>
	
	<tbody>
		<? if ($group_list != FALSE): ?>
		<? foreach($group_list as $group): ?>
		<tr>
			<td><?=$group['name'];?></td>
			<td><?=$group['description'];?></td>
			<td>
				<div class="btn-group w-100" role="group">
					<a class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse" href="#TableGroup<?=$group['id'];?>" aria-expanded="false" aria-controls="TableGroup<?=$group['id'];?>" title="<?=lang('settings_params_btn_hideshow');?>">
						<i class="fa fa-compress-alt"></i>
					</a>
					<button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalAddEdit" data-bs-actiontype="edit" data-bs-id="<?=$group['id'];?>">
						<i class="fa fa-edit"></i> <?=lang('main_btn_edit');?>
					</button>
					<button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#ModalDelete" data-bs-id="<?=$group['id'];?>">
						<i class="fa fa-trash-alt"></i> <?=lang('main_btn_del');?>
					</button>
				</div>
			</td>
		</tr>
		
		<tr id="TableGroup<?=$group['id'];?>" class="collapse">
		<td colspan="3">
			<div class="card">
				<div class="card-body">
					<?=nl2br($group['params_source_data']);?>
					<hr class="hr">
					<button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#TableGroup<?=$group['id'];?>" aria-expanded="false" aria-controls="TableGroup<?=$group['id'];?>"><i class="fa fa-chevron-up"></i> <?=lang('settings_params_btn_hide');?></button>
				</div>
			</div>
		</td>
		</tr>
		<? endforeach; ?>
		<? else: ?>
		<tr class="table-primary">
			<td colspan="5"><?=lang('main_message_nodata');?></td>
		</tr>
		<? endif; ?>
	</tbody>
</table>

<!-- ModalAddEdit -->
<div class="modal fade" id="ModalAddEdit" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ModalAddEditLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalAddEditLabel">ModalTitle</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="ModalAddEditForm" method="post" action="">
					<div>
						<label for="ModalAddEditForm_Name"><?=lang('settings_params_modal_eddedit_groupname');?></label>
						<input type="text" name="name" class="form-control" id="ModalAddEditForm_Name" required>
						<small id="ModalAddEditForm_NameHelp" class="form-text text-muted"><?=lang('settings_params_modal_eddedit_groupname_help');?></small>
					</div>
					<div class="mt-2">
						<label for="ModalAddEditForm_Description"><?=lang('settings_params_modal_eddedit_description');?></label>
						<input type="text" name="description" class="form-control" id="ModalAddEditForm_Description" required>
						<small id="ModalAddEditForm_DescriptionHelp" class="form-text text-muted"><?=lang('settings_params_modal_eddedit_description_help');?></small>
					</div>
					<div class="mt-2">	
						<label for="ModalAddEditForm_Params"><?=lang('settings_params_modal_eddedit_params');?></label>
						<textarea name="params_source_data" class="form-control" id="ModalAddEditForm_Name" rows="10" required></textarea>
						<small id="ModalAddEditForm_ParamsHelp" class="form-text text-muted"><?=lang('settings_params_modal_eddedit_params_help');?></small>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"><?=lang('main_btn_cancel');?></button>
				<button type="submit" class="btn btn-outline-success btn-sm" form="ModalAddEditForm"><?=lang('main_btn_save');?></button>
			</div>
		</div>
	</div>
</div>
<script>
	document.getElementById('ModalAddEdit').addEventListener('show.bs.modal', function (event) {
		var button = event.relatedTarget
		var actiontype = button.getAttribute('data-bs-actiontype')
		var paramid = button.getAttribute('data-bs-id')
		var modal = $(this)
		if (actiontype == "new") {
			modal.find('.modal-title').text('<?=lang("settings_params_modal_eddedit_title_add");?>')
			modal.find('.modal-body input').val('')
			modal.find('.modal-body textarea').val('')
			modal.find('.modal-body select').val('')
			modal.find('.modal-body form').attr('action', '<?=site_url("settings/params/add/");?>')
		}
		if (actiontype == "edit") {
			modal.find('.modal-title').text('<?=lang("settings_params_modal_eddedit_title_edit");?>')
			$.ajax({
				url: '<?=site_url("settings/ajax/params/get/");?>' + paramid,
				dataType: 'json',
				success: function(responce) {
					if (responce.result == 'success') {
						modal.find('.modal-body input[name=name]').val(responce.data.name)
						modal.find('.modal-body input[name=description]').val(responce.data.description)
						modal.find('.modal-body textarea[name=params_source_data]').val(responce.data.params_source_data)
						modal.find('.modal-body form').attr('action', '<?=site_url("settings/params/edit/");?>' + paramid)
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
				<h5 class="modal-title" id="ModalDeleteLabel"><?=lang('settings_params_modal_del_title');?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body text-center">
				<?=lang('settings_params_modal_del_confirm');?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"><?=lang('main_btn_cancel');?></button>
				<a type="button" class="btn btn-outline-warning btn-sm" href="#"><?=lang('main_btn_del');?></a>
			</div>
		</div>
	</div>
</div>
<script>
	document.getElementById('ModalDelete').addEventListener('show.bs.modal', function (event) {
		var button = event.relatedTarget
		var paramid = button.getAttribute('data-bs-id')
		var modal = $(this)
		modal.find('.modal-footer a').attr('href', '<?=site_url("settings/params/del/");?>' + paramid)
	})
</script>