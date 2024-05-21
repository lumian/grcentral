<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<? if ($this->settings_model->syssettings_get('hide_help_header_msg') != 'on'): ?>
<div class="card mt-2 shadow-sm">
	<div class="card-body">
		<?=lang('settings_importexport_description_text');?>
	</div>
</div>
<? endif; ?>

<? if ($this->session->flashdata('success_result')): ?>
<div class="alert alert-success mt-2 shadow-sm" role="alert"><?=$this->session->flashdata('success_result');?></div>
<? endif;?>

<? if ($this->session->flashdata('error_result')): ?>
<div class="alert alert-danger mt-2 shadow-sm" role="alert"><?=$this->session->flashdata('error_result');?></div>
<? endif;?>

<div class="card mt-2">
	<div class="card-body">
		<strong><?=lang("settings_importexport_models_title");?></strong><br />
		<small class="text-muted"><?=lang("settings_importexport_models_descr");?></small>
		<hr class="hr">
		<div class="row">
			<div class="col-6">
				<strong><?=lang("settings_importexport_models_export_title");?></strong><br />
				<?=lang("settings_importexport_models_export_descr");?>
				<br />
				<hr class="hr">
				<a href="<?=site_url('settings/importexport/export_models');?>" target="_blank" class="btn btn-outline-success w-100"><i class="fa fa-file-export"></i> <?=lang('main_btn_export');?></a>
			</div>
			<div class="col-6">
				<strong><?=lang("settings_importexport_models_import_title");?></strong><br />
				<?=lang("settings_importexport_models_import_descr");?>
				<br />
				<hr class="hr">
				<button type="button" class="btn btn-outline-success w-100" data-bs-toggle="modal" data-bs-target="#ModalImportModels"><i class="fa fa-file-import"></i> <?=lang('main_btn_import');?></button>
			</div>
		</div>
	</div>
</div>

<!-- ModalImportModels -->
<div class="modal fade" id="ModalImportModels" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ModalImportModelsLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalImportModelsLabel"><?=lang("settings_importexport_modal_importmodel_title");?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="ModalImportModelsForm" method="post" action="<?=site_url('settings/importexport/import_models');?>">
					<div class="row">
						<div class="col">
							<label for="ModalImportModelsForm_Json"><?=lang("settings_importexport_modal_importmodel_json");?></label>
							<textarea name="json_data" class="form-control" id="ModalImportModelsForm_Json" rows="10"></textarea>
							<small id="ModalImportModelsForm_JsonHelp" class="form-text text-muted"><?=lang("settings_importexport_modal_importmodel_json_descr");?></small>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"><?=lang('main_btn_cancel');?></button>
				<button type="submit" class="btn btn-outline-success btn-sm" form="ModalImportModelsForm"><?=lang('main_btn_import');?></button>
			</div>
		</div>
	</div>
</div>