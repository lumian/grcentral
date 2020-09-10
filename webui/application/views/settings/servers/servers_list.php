<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="card mt-2">
  <div class="card-body">
    <?=lang('settings_servers_description_text');?>
  </div>
</div>

<div class="btn-group btn-group-sm mt-2" role="group">
	<button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#ModalAddEdit" data-actiontype="new"><i class="fa fa-plus-square"></i> <?=lang('settings_servers_btn_new');?></button>
	<a href="<?=lang('main_helpurl_settings_servers');?>" target="_blank" title="<?=lang('main_helpurl_urltitle');?>" type="button" class="btn btn-outline-info"><i class="fa fa-question-circle"></i></a>
</div>

<? if ($this->session->flashdata('success_result')): ?>
<div class="alert alert-success mt-2" role="alert"><?=$this->session->flashdata('success_result');?></div>
<? endif;?>

<? if ($this->session->flashdata('error_result')): ?>
<div class="alert alert-danger mt-2" role="alert"><?=$this->session->flashdata('error_result');?></div>
<? endif;?>

<table class="table table-hover table-bordered table-sm mt-2">
	<thead>
		<th><?=lang('settings_servers_table_name');?></th>
		<th><?=lang('settings_servers_table_description');?></th>
		<th><?=lang('settings_servers_table_server');?></th>
		<th><?=lang('settings_servers_table_voicemailnumber');?></th>
		<th><?=lang('main_table_actions');?></th>
	</thead>
	
	<tbody>
		<? if ($servers_list != FALSE): ?>
		<? foreach($servers_list as $server): ?>
		<tr>
			<td><?=$server['name'];?></td>
			<td><?=$server['description'];?></td>
			<td><?=$server['server'];?></td>
			<td><?=$server['voicemail_number'];?></td>
			<td>
				<div class="btn-group btn-block" role="group">
					<button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#ModalAddEdit" data-actiontype="edit" data-id="<?=$server['id'];?>">
						<i class="fa fa-edit"></i> <?=lang('main_btn_edit');?>
					</button>
					<button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#ModalDelete" data-id="<?=$server['id'];?>">
						<i class="fa fa-trash-alt"></i> <?=lang('main_btn_del');?>
					</button>
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
						<label for="ModalAddEditForm_Name"><?=lang('settings_servers_modal_addedit_name');?></label>
						<input type="text" name="name" class="form-control" id="ModalAddEditForm_Name" required>
						<small id="ModalAddEditForm_NameHelp" class="form-text text-muted"><?=lang('settings_servers_modal_addedit_name_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalAddEditForm_Description"><?=lang('settings_servers_modal_addedit_description');?></label>
						<input type="text" name="description" class="form-control" id="ModalAddEditForm_Description" required>
						<small id="ModalAddEditForm_DescriptionHelp" class="form-text text-muted"><?=lang('settings_servers_modal_addedit_description_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalAddEditForm_Server"><?=lang('settings_servers_modal_addedit_server');?></label>
						<input type="text" name="server" class="form-control" id="ModalAddEditForm_Server" required>
						<small id="ModalAddEditForm_ServerHelp" class="form-text text-muted"><?=lang('settings_servers_modal_addedit_server_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalAddEditForm_VoicemailNumber"><?=lang('settings_servers_modal_addedit_voicemailnumber');?></label>
						<input type="text" name="voicemail_number" class="form-control" id="ModalAddEditForm_VoicemailNumber">
						<small id="ModalAddEditForm_VoicemailNumberHelp" class="form-text text-muted"><?=lang('settings_servers_modal_addedit_voicemailnumber_help');?></small>
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
		var serverid = button.data('id')
		var modal = $(this)
		if (actiontype == "new") {
			modal.find('.modal-title').text('<?=lang("settings_servers_modal_addedit_title_add");?>')
			modal.find('.modal-body input').val('')
			modal.find('.modal-body form').attr('action', '<?=site_url("settings/servers/add");?>')
		}
		if (actiontype == "edit") {
			modal.find('.modal-title').text('<?=lang("settings_servers_modal_addedit_title_edit");?>')
			$.ajax({
				url: '<?=site_url("settings/ajax/servers/get/");?>' + serverid,
				dataType: 'json',
				success: function(responce) {
					if (responce.result == 'success') {
						modal.find('.modal-body input[name=name]').val(responce.data.name)
						modal.find('.modal-body input[name=description]').val(responce.data.description)
						modal.find('.modal-body input[name=server]').val(responce.data.server)
						modal.find('.modal-body input[name=voicemail_number]').val(responce.data.voicemail_number)
						modal.find('.modal-body form').attr('action', '<?=site_url("settings/servers/edit/");?>' + serverid)
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
				<h5 class="modal-title" id="ModalDeleteLabel"><?=lang('settings_servers_modal_del_title');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?=lang('settings_servers_modal_del_confirm');?>
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
		var serverid = button.data('id')
		var modal = $(this)
		modal.find('.modal-footer a').attr('href', '<?=site_url("settings/servers/del/");?>' + serverid)
	})
</script>