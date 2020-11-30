<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="card mt-2">
	<div class="card-body">
		<?=lang('phonebook_abonents_description_text');?>
	</div>
</div>

<div class="btn-group btn-group-sm mt-2" role="group">
	<button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#ModalAddEdit" data-actiontype="new"><i class="fa fa-plus-square"></i> <?=lang('phonebook_abonents_btn_new');?></button>
	<a href="<?=lang('main_helpurl_phonebook_abonents');?>" target="_blank" title="<?=lang('main_helpurl_urltitle');?>" type="button" class="btn btn-outline-info"><i class="fa fa-question-circle"></i></a>
</div>

<? if ($this->session->flashdata('success_result')): ?>
	<div class="alert alert-success mt-2" role="alert"><?=$this->session->flashdata('success_result');?></div>
<? endif;?>

<? if ($this->session->flashdata('error_result')): ?>
	<div class="alert alert-danger mt-2" role="alert"><?=$this->session->flashdata('error_result');?></div>
<? endif;?>

<table class="table table-hover table-bordered table-sm mt-2">
	<thead>
		<th><?=lang('phonebook_abonents_table_firstname');?></th>
		<th><?=lang('phonebook_abonents_table_lastname');?></th>
		<th><?=lang('phonebook_abonents_table_phonework');?></th>
		<th><?=lang('phonebook_abonents_table_datasource');?></th>
		<th><?=lang('phonebook_abonents_table_status');?></th>
		<th><?=lang('main_table_actions');?></th>
	</thead>
	
	<tbody>
		<? if ($abonents_list != FALSE): ?>
			<? foreach($abonents_list as $abonent): ?>
				<tr>
					<td><?=$abonent['first_name'];?></td>
					<td><?=$abonent['last_name'];?></td>
					<td><?=$abonent['phone_work'];?></td>
					<td><?=lang('phonebook_abonents_table_datasource_'.$abonent['data_source']);?>
					<? if ($abonent['data_source'] != 'manual'): ?>
						&nbsp;
						<span data-toggle="tooltip" title="<?=lang('phonebook_abonents_table_datasource_transform');?> <?=lang('phonebook_abonents_table_datasource_manual');?>">
							<a href="#" data-toggle="modal" data-target="#ModalTransformSource" data-id="<?=$abonent['id'];?>">
								<i class="fa fa-random"></i>
							</a>
						</span>
					<? endif; ?>
					</td>
					<td>
						<!-- Status button -->
						<div class="btn-group btn-block" role="group">
							<? if ($abonent['data_source'] == 'manual'): ?>
								<? if ($abonent['status'] == '1'): ?>
									<button type="button" class="btn btn-outline-success btn-xs btn-block" data-toggle="modal" data-target="#ModalChangeStatus" data-id="<?=$abonent['id'];?>" title="<?=lang('phonebook_abonents_table_status_on');?>. <?=lang('phonebook_abonents_table_status_descr_manual');?>"><i class="fa fa-power-off"></i></button>
								<? else: ?>
									<button type="button" class="btn btn-outline-danger btn-xs btn-block" data-toggle="modal" data-target="#ModalChangeStatus" data-id="<?=$abonent['id'];?>" title="<?=lang('phonebook_abonents_table_status_off');?>. <?=lang('phonebook_abonents_table_status_descr_manual');?>"><i class="fa fa-power-off"></i></button>
								<? endif; ?>
							<? else: ?>
								<? if ($abonent['status'] == '1'): ?>
									<button type="button" class="btn btn-outline-success btn-xs btn-block" title="<?=lang('phonebook_abonents_table_status_on');?>. <?=lang('phonebook_abonents_table_status_descr_external');?>" disabled><i class="fa fa-power-off"></i></button>
								<? else: ?>
									<button type="button" class="btn btn-outline-danger btn-xs btn-block" title="<?=lang('phonebook_abonents_table_status_off');?>. <?=lang('phonebook_abonents_table_status_descr_external');?>" disabled><i class="fa fa-power-off"></i></button>
								<? endif; ?>								
							<? endif; ?>
						</div>
					</td>
					<td>
						<!-- Action buttons -->
						<div class="btn-group btn-block" role="group">
							<? if ($abonent['data_source'] == 'manual'): ?>
								<button type="button" class="btn btn-outline-info btn-xs" data-toggle="modal" data-target="#ModalAddEdit" data-actiontype="edit" data-id="<?=$abonent['id'];?>" title="<?=lang('main_btn_edit');?>">
									<i class="fa fa-edit"></i>
								</button>
								<button type="button" class="btn btn-outline-danger btn-xs" data-toggle="modal" data-target="#ModalDelete" data-id="<?=$abonent['id'];?>" title="<?=lang('main_btn_del');?>">
									<i class="fa fa-trash-alt"></i>
								</button>
							<? elseif ($abonent['data_source'] == 'accounts' AND isset($abonent['external_id']) AND is_numeric($abonent['external_id'])):?>
								<a type="button" class="btn btn-outline-info btn-xs" title="<?=lang('phonebook_abonents_btn_gotodevice');?>" href="<?=site_url('devices/info/'.$abonent['external_id']);?>" target="_blank">
									<i class="fa fa-external-link-alt"></i>
								</a>
							<? else: ?>
								<button type="button" class="btn btn-outline-info btn-xs disabled" title="<?=lang('phonebook_abonents_btn_action_na');?>">
									<i class="fa fa-times"></i>
								</button>
							<? endif; ?>
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
				<form id="ModalAddEditForm" method="post" action="" enctype="multipart/form-data">
					<div class="form-group">
						<label for="ModalAddEditForm_FirstName"><?=lang('phonebook_abonents_modal_addeditabonent_firstname');?></label>
						<input type="text" name="first_name" class="form-control" id="ModalAddEditForm_FirstName" required>
						<small id="ModalAddEditForm_FirstNameHelp" class="form-text text-muted"><?=lang('phonebook_abonents_modal_addeditabonent_firstname_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalAddEditForm_LastName"><?=lang('phonebook_abonents_modal_addeditabonent_lastname');?></label>
						<input type="text" name="last_name" class="form-control" id="ModalAddEditForm_LastName" required>
						<small id="ModalAddEditForm_LastNameHelp" class="form-text text-muted"><?=lang('phonebook_abonents_modal_addeditabonent_lastname_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalAddEditForm_PhoneWork"><?=lang('phonebook_abonents_modal_addeditabonent_phonework');?></label>
						<input type="text" name="phone_work" class="form-control" id="ModalAddEditForm_PhoneWork" required>
						<small id="ModalAddEditForm_PhoneWorkNameHelp" class="form-text text-muted"><?=lang('phonebook_abonents_modal_addeditabonent_phonework_help');?></small>
					</div>
					<div class="form-group">
						<label for="ModalAddEditForm_Status"><?=lang('phonebook_abonents_modal_addeditabonent_status');?></label>
						<select class="form-control" name="status" id="ModalAddEditForm_Status" required>
							<option value='0'><?=lang('phonebook_abonents_modal_addeditabonent_status_off');?></option>
							<option value='1' selected="selected"><?=lang('phonebook_abonents_modal_addeditabonent_status_on');?></option>
						</select>
						<small id="ModalAddEditForm_StatusHelp" class="form-text text-muted"><?=lang('phonebook_abonents_modal_addeditabonent_status_help');?></small>
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
		var abonentid = button.data('id')
		var modal = $(this)
		if (actiontype == "new") {
			modal.find('.modal-title').text('<?=lang("phonebook_abonents_modal_addeditabonent_title_add");?>')
			modal.find('.modal-body input').val('')
			modal.find('.modal-body form').attr('action', '<?=site_url("phonebook/actions/add_abonent/");?>')
		}
		if (actiontype == "edit") {
			
			modal.find('.modal-title').text('<?=lang("phonebook_abonents_modal_addeditabonent_title_edit");?>')
			$.ajax({
				url: '<?=site_url("phonebook/ajax/abonent_get/");?>' + abonentid,
				dataType: 'json',
				success: function(data) {
					if (data.result == 'success') {
						modal.find('.modal-body input[name=first_name]').val(data.data.first_name)
						modal.find('.modal-body input[name=last_name]').val(data.data.last_name)
						modal.find('.modal-body input[name=phone_work]').val(data.data.phone_work)
						modal.find('.modal-body select[name=status]').val(data.data.status)
						modal.find('.modal-body form').attr('action', '<?=site_url("phonebook/actions/edit_abonent/");?>' + abonentid)
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
				<h5 class="modal-title" id="ModalDeleteLabel"><?=lang('phonebook_abonents_modal_delabonent_title');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?=lang('phonebook_abonents_modal_delabonent_confirm');?>
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
		var abonentid = button.data('id')
		var modal = $(this)
		modal.find('.modal-footer a').attr('href', '<?=site_url("phonebook/actions/del_abonent/");?>' + abonentid)
	})
</script>

<!-- ModalChangeStatus -->
<div class="modal fade" id="ModalChangeStatus" tabindex="-1" role="dialog" aria-labelledby="ModalChangeStatusLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalChangeStatusLabel"><?=lang('phonebook_abonents_modal_changestatus_title');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?=lang('phonebook_abonents_modal_changestatus_confirm');?>
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
		var abonentid = button.data('id')
		var modal = $(this)
		modal.find('.modal-footer a').attr('href', '<?=site_url("phonebook/actions/abonent_changestatus/");?>' + abonentid)
	})
</script>

<!-- ModalTransformSource -->
<div class="modal fade" id="ModalTransformSource" tabindex="-1" role="dialog" aria-labelledby="ModalTransformSourceLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalTransformSourceLabel"><?=lang('phonebook_abonents_modal_transformsource_title');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?=lang('phonebook_abonents_modal_transformsource_confirm');?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal"><?=lang('main_btn_cancel');?></button>
				<a type="button" class="btn btn-outline-success btn-sm" href="#"><?=lang('main_btn_save');?></a>
			</div>
		</div>
	</div>
</div>
<script>
	$('#ModalTransformSource').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget)
		var abonentid = button.data('id')
		var modal = $(this)
		modal.find('.modal-footer a').attr('href', '<?=site_url("phonebook/actions/abonent_transformsource/");?>' + abonentid + '/manual')
	})
</script>