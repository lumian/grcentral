<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="card mt-2">
  <div class="card-body">
    <?=lang('settings_fw_description');?>
  </div>
</div>
<? if ($group_list != FALSE): ?>
<button type="button" class="btn btn-success btn-sm mt-2" data-toggle="modal" data-target="#ModalAddEdit" data-actiontype="new"><?=lang('settings_fw_btn_new');?></button>
<? endif; ?>

<? if ($this->session->flashdata('success_result')): ?>
<div class="alert alert-success mt-2" role="alert"><?=$this->session->flashdata('success_result');?></div>
<? endif;?>

<? if ($this->session->flashdata('error_result')): ?>
<div class="alert alert-danger mt-2" role="alert"><?=$this->session->flashdata('error_result');?></div>
<? endif;?>

<table class="table table-hover table-sm mt-2">
	<thead>
		<th><?=lang('settings_fw_table_previousversion');?></th>
		<th><?=lang('settings_fw_table_version');?></th>
		<th><?=lang('settings_fw_table_filename');?></th>
		<th><?=lang('settings_fw_table_filename_real');?></th>
		<th><?=lang('settings_fw_table_status');?></th>
		<th><?=lang('main_table_actions');?></th>
	</thead>
	
	<tbody>
		<? if ($fw_list != FALSE): ?>
		<? foreach($fw_list as $row): ?>
		<thead>
		<tr>
			<th colspan="5"><?=lang('settings_models_table_group');?>: <?=$row['group_info']['name'];?></th>
		</tr>
		</thead>
		<? if ($row['items'] != FALSE): ?>
			<? foreach($row['items'] as $fw): ?>
				<tr>
					<td><?=$fw['previous_version'];?></td>
					<td><?=$fw['version'];?></td>
					<td><?=$fw['file_name'];?></td>
					<td><?=$fw['file_name_real'];?></td>
					<td>
						<? if ($fw['status'] == '1'): ?>
							<a href="#" data-toggle="modal" data-target="#ModalChangeStatus" data-id="<?=$fw['id'];?>" title="<?=lang('settings_fw_table_status_descr');?>"><?=lang('settings_fw_table_status_on');?></a>
						<? else: ?>
							<a href="#" data-toggle="modal" data-target="#ModalChangeStatus" data-id="<?=$fw['id'];?>" title="<?=lang('settings_fw_table_status_descr');?>"><?=lang('settings_fw_table_status_off');?></a>
						<? endif; ?>
					</td>
					<td>
						<div class="btn-group" role="group">
							<button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#ModalDelete" data-id="<?=$fw['id'];?>">
								<?=lang('main_btn_del');?>
							</button>
						</div>
					</td>
				</tr>
			<? endforeach; ?>
		<? else: ?>
		<tr class="table-primary">
			<td colspan="4"><?=lang('settings_fw_table_noitemsingroup');?></td>
		</tr>
		<? endif; ?>
		<? endforeach; ?>
		<? else: ?>
		<tr class="table-primary">
			<td colspan="4"><?=lang('main_message_nodata');?></td>
		</tr>
		<? endif; ?>
	</tbody>
</table>

<? if ($group_list != FALSE): ?>

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
				<form id="ModalAddEditForm" method="post" action="" enctype="multipart/form-data">
					<div class="form-group">
						<label for="ModalAddEditForm_Version"><?=lang('settings_fw_modal_version');?></label>
						<input type="text" name="version" class="form-control" id="ModalAddEditForm_Version" required>
						<small id="ModalAddEditForm_VersionHelp" class="form-text text-muted"><?=lang('settings_fw_modal_version_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalAddEditForm_PreviousVersion"><?=lang('settings_fw_modal_previous_version');?></label>
						<input type="text" name="previous_version" class="form-control" id="ModalAddEditForm_PreviousVersion" required>
						<small id="ModalAddEditForm_PreviousVersionHelp" class="form-text text-muted"><?=lang('settings_fw_modal_previous_version_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalAddEditForm_Group"><?=lang('settings_fw_modal_group');?></label>
						<select class="form-control" name="group_id" id="ModalAddEditForm_Group" required>
							<? foreach($group_list as $group): ?>
							<option value='<?=$group['id'];?>'><?=$group['name'];?></option>
							<? endforeach; ?>
						</select>
						<small id="ModalAddEditForm_GroupHelp" class="form-text text-muted"><?=lang('settings_fw_modal_group_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalAddEditForm_Status"><?=lang('settings_fw_modal_status');?></label>
						<select class="form-control" name="status" id="ModalAddEditForm_Status" required>
							<option value='0'><?=lang('settings_fw_modal_status_off');?></option>
							<option value='1'><?=lang('settings_fw_modal_status_on');?></option>
						</select>
						<small id="ModalAddEditForm_GroupHelp" class="form-text text-muted"><?=lang('settings_fw_modal_status_descr');?></small>
					</div>
					<div class="form-group">
						<label for="ModalAddEditForm_File"><?=lang('settings_fw_modal_file');?></label>
						<input type="file" class="form-control-file" id="ModalAddEditForm_File" name="userfile" required>
						<small id="ModalAddEditForm_GroupHelp" class="form-text text-muted"><?=lang('settings_fw_modal_file_help');?></small>
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
		var fwid = button.data('id')
		var modal = $(this)
		if (actiontype == "new") {
			modal.find('.modal-title').text('<?=lang("settings_fw_modal_title_add");?>')
			modal.find('.modal-body input').val('')
			modal.find('.modal-body form').attr('action', '/settings/fw/add/')
		}
	})
</script>

<!-- ModalDelete -->
<div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="ModalDeleteLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalDeleteLabel"><?=lang('settings_fw_modal_title_del');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?=lang('settings_fw_modal_confirm_del');?>
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
		var fwid = button.data('id')
		var modal = $(this)
		modal.find('.modal-footer a').attr('href', '/settings/fw/del/' + fwid)
	})
</script>

<!-- ModalChangeStatus -->
<div class="modal fade" id="ModalChangeStatus" tabindex="-1" role="dialog" aria-labelledby="ModalChangeStatusLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalChangeStatusLabel"><?=lang('settings_fw_modal_title_changestatus');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?=lang('settings_fw_modal_confirm_changestatus');?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><?=lang('main_btn_cancel');?></button>
				<a type="button" class="btn btn-success btn-sm" href="#"><?=lang('main_btn_save');?></a>
			</div>
		</div>
	</div>
</div>
<script>
	$('#ModalChangeStatus').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var fwid = button.data('id')
		var modal = $(this)
		modal.find('.modal-footer a').attr('href', '/settings/fw/change_status/' + fwid)
	})
</script>
<? endif;?>