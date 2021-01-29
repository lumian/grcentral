<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<? if ($this->settings_model->syssettings_get('hide_help_header_msg') != 'on'): ?>
<div class="card mt-2">
	<div class="card-body">
		<?=lang('settings_fw_description_text');?>
	</div>
</div>
<? endif; ?>

<div class="btn-group btn-group-sm mt-2" role="group">
	<? if ($group_list != FALSE): ?>
	<button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#ModalAddEdit" data-actiontype="new"><i class="fa fa-plus-square"></i> <?=lang('settings_fw_btn_new');?></button>
	<? endif; ?>
	<a href="<?=lang('main_helpurl_settings_fw');?>" target="_blank" title="<?=lang('main_helpurl_urltitle');?>" type="button" class="btn btn-outline-info"><i class="fa fa-question-circle"></i></a>
</div>


<? if ($this->session->flashdata('success_result')): ?>
<div class="alert alert-success mt-2" role="alert"><?=$this->session->flashdata('success_result');?></div>
<? endif;?>

<? if ($this->session->flashdata('error_result')): ?>
<div class="alert alert-danger mt-2" role="alert"><?=$this->session->flashdata('error_result');?></div>
<? endif;?>

<table class="table table-hover table-bordered table-sm mt-2">
	<thead>
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
			<th colspan="6"><i class="fa fa-folder-open"></i> <?=$row['group_info']['name'];?></th>
		</tr>
		</thead>
		<? if ($row['items'] != FALSE): ?>
			<? foreach($row['items'] as $fw): ?>
				<tr>
					<td><?=$fw['version'];?></td>
					<td><?=$fw['file_name'];?></td>
					<td><?=$fw['file_name_real'];?></td>
					<td>
						<? if ($fw['status'] == '1'): ?>
							<button type="button" class="btn btn-outline-success btn-sm btn-block" data-toggle="modal" data-target="#ModalChangeStatus" data-id="<?=$fw['id'];?>" title="<?=lang('settings_fw_table_status_on');?>. <?=lang('settings_fw_table_status_descr');?>"><i class="fa fa-power-off"></i></button>
						<? else: ?>
							<button type="button" class="btn btn-outline-danger btn-sm btn-block" data-toggle="modal" data-target="#ModalChangeStatus" data-id="<?=$fw['id'];?>" title="<?=lang('settings_fw_table_status_off');?>. <?=lang('settings_fw_table_status_descr');?>"><i class="fa fa-power-off"></i></button>
						<? endif; ?>
					</td>
					<td>
						<div class="btn-group btn-block" role="group">
							<button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#ModalDelete" data-id="<?=$fw['id'];?>">
								<i class="fa fa-trash-alt"></i> <?=lang('main_btn_del');?>
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
						<label for="ModalAddEditForm_Version"><?=lang('settings_fw_modal_addedit_version');?></label>
						<input type="text" name="version" class="form-control" id="ModalAddEditForm_Version" required>
						<small id="ModalAddEditForm_VersionHelp" class="form-text text-muted"><?=lang('settings_fw_modal_addedit_version_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalAddEditForm_Group"><?=lang('settings_fw_modal_addedit_group');?></label>
						<select class="form-control" name="group_id" id="ModalAddEditForm_Group" required>
							<? foreach($group_list as $group): ?>
							<option value='<?=$group['id'];?>'><?=$group['name'];?></option>
							<? endforeach; ?>
						</select>
						<small id="ModalAddEditForm_GroupHelp" class="form-text text-muted"><?=lang('settings_fw_modal_addedit_group_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalAddEditForm_File"><?=lang('settings_fw_modal_addedit_file');?></label>
						<input type="file" class="form-control-file" id="ModalAddEditForm_File" name="userfile" required>
						<small id="ModalAddEditForm_FileHelp" class="form-text text-muted"><?=lang('settings_fw_modal_addedit_file_help');?></small>
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
		var fwid = button.data('id')
		var modal = $(this)
		if (actiontype == "new") {
			modal.find('.modal-title').text('<?=lang("settings_fw_modal_addedit_title_add");?>')
			modal.find('.modal-body input').val('')
			modal.find('.modal-body form').attr('action', '<?=site_url("settings/fw/add/");?>')
		}
	})
</script>

<!-- ModalDelete -->
<div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="ModalDeleteLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalDeleteLabel"><?=lang('settings_fw_modal_del_title');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?=lang('settings_fw_modal_del_confirm');?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal"><?=lang('main_btn_cancel');?></button>
				<a type="button" class="btn btn-outline-warning btn-sm" href="#"><?=lang('main_btn_del');?></a>
			</div>
		</div>
	</div>
</div>
<script>
	$('#ModalDelete').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var fwid = button.data('id')
		var modal = $(this)
		modal.find('.modal-footer a').attr('href', '<?=site_url("settings/fw/del/");?>' + fwid)
	})
</script>

<!-- ModalChangeStatus -->
<div class="modal fade" id="ModalChangeStatus" tabindex="-1" role="dialog" aria-labelledby="ModalChangeStatusLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalChangeStatusLabel"><?=lang('settings_fw_modal_changestatus_title');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?=lang('settings_fw_modal_changestatus_confirm');?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal"><?=lang('main_btn_cancel');?></button>
				<a type="button" class="btn btn-outline-success btn-sm" href="#"><?=lang('main_btn_save');?></a>
			</div>
		</div>
	</div>
</div>
<script>
	$('#ModalChangeStatus').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var fwid = button.data('id')
		var modal = $(this)
		modal.find('.modal-footer a').attr('href', '<?=site_url("settings/fw/change_status/");?>' + fwid)
	})
</script>
<? endif;?>