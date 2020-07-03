<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="card mt-2">
  <div class="card-body">
    <?=lang('settings_params_description');?>
  </div>
</div>

<button type="button" class="btn btn-success btn-sm mt-2" data-toggle="modal" data-target="#ModalAddEdit" data-actiontype="new"><?=lang('settings_params_btn_new');?></button>
<? if ($need_apply == '1'):?>
<a href="/cron/webcron/gencfg" target="_blank" type="button" class="btn btn-danger btn-sm mt-2">Apply settings (FIXME!!!)</a>
<? endif; ?>

<? if ($this->session->flashdata('success_result')): ?>
<div class="alert alert-success mt-2" role="alert"><?=$this->session->flashdata('success_result');?></div>
<? endif;?>

<? if ($this->session->flashdata('error_result')): ?>
<div class="alert alert-danger mt-2" role="alert"><?=$this->session->flashdata('error_result');?></div>
<? endif;?>

<table class="table table-sm mt-2">
	<thead>
		<th><?=lang('settings_params_table_group');?></th>
		<th><?=lang('settings_params_table_description');?></th>
		<th><?=lang('main_table_actions');?></th>
	</thead>
	
	<tbody>
		<? if ($group_list != FALSE): ?>
		<? foreach($group_list as $group): ?>
		<tr>
			<td><?=$group['name'];?> (<a data-toggle="collapse" href="#TableGroup<?=$group['id'];?>" aria-expanded="false" aria-controls="TableGroup<?=$group['id'];?>"><?=lang('settings_params_btn_hideshow');?></a>)</td>
			<td><?=$group['description'];?></td>
			<td>
				<div class="btn-group" role="group">
					<button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#ModalAddEdit" data-actiontype="edit" data-id="<?=$group['id'];?>">
						<?=lang('main_btn_edit');?>
					</button>
					<button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#ModalDelete" data-id="<?=$group['id'];?>">
						<?=lang('main_btn_del');?>
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
					<button class="btn btn-outline-primary btn-sm" type="button" data-toggle="collapse" data-target="#TableGroup<?=$group['id'];?>" aria-expanded="false" aria-controls="TableGroup<?=$group['id'];?>"><?=lang('settings_params_btn_hide');?></button>
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
					<div class="form-group">
						<label for="ModalAddEditForm_Name"><?=lang('settings_params_modal_groupname');?></label>
						<input type="text" name="name" class="form-control" id="ModalAddEditForm_Name" required>
						<small id="ModalAddEditForm_NameHelp" class="form-text text-muted"><?=lang('settings_params_modal_groupname_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalAddEditForm_Description"><?=lang('settings_params_modal_description');?></label>
						<input type="text" name="description" class="form-control" id="ModalAddEditForm_Description" required>
						<small id="ModalAddEditForm_DescriptionHelp" class="form-text text-muted"><?=lang('settings_params_modal_description_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalAddEditForm_Params"><?=lang('settings_params_modal_params');?></label>
						<textarea name="params_source_data" class="form-control" id="ModalAddEditForm_Name" rows="10" required></textarea>
						<small id="ModalAddEditForm_ParamsHelp" class="form-text text-muted"><?=lang('settings_params_modal_params_help');?></small>
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
		var paramid = button.data('id')
		var modal = $(this)
		if (actiontype == "new") {
			modal.find('.modal-title').text('<?=lang("settings_params_modal_title_add");?>')
			modal.find('.modal-body input').val('')
			modal.find('.modal-body textarea').val('')
			modal.find('.modal-body select').val('')
			modal.find('.modal-body form').attr('action', '/settings/params/add/')
		}
		if (actiontype == "edit") {
			modal.find('.modal-title').text('<?=lang("settings_params_modal_title_edit");?>')
			$.ajax({
				url: '/settings/ajax/params/get/' + paramid,
				dataType: 'json',
				success: function(responce) {
					if (responce.result == 'success') {
						modal.find('.modal-body input[name=name]').val(responce.data.name)
						modal.find('.modal-body input[name=description]').val(responce.data.description)
						modal.find('.modal-body textarea[name=params_source_data]').val(responce.data.params_source_data)
						modal.find('.modal-body form').attr('action', '/settings/params/edit/' + paramid)
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
				<h5 class="modal-title" id="ModalDeleteLabel"><?=lang('settings_params_modal_title_del');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?=lang('settings_params_modal_confirm_del');?>
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
		var paramid = button.data('id')
		var modal = $(this)
		modal.find('.modal-footer a').attr('href', '/settings/params/del/' + paramid)
	})
</script>