<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="modal fade" id="ModalAuth" tabindex="-1" data-bs-backdrop="static" role="dialog" aria-labelledby="ModalAuthLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalAuthLabel"><?=lang('main_auth_modal_title');?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="ModalAuthForm" method="post" action="<?=site_url('auth/login');?>">
					<div class="form-floating mb-3">
						<input type="text" name="login" class="form-control" id="ModalAuthForm_Login" placeholder="<?=lang('main_auth_modal_login');?>" required>
						<label for="ModalAuthForm_Login"><?=lang('main_auth_modal_login');?></label>
					</div>
					<div class="form-floating">
						<input type="password" name="password" class="form-control" id="ModalAuthForm_Password" placeholder="<?=lang('main_auth_modal_passwd');?>" required>
						<label for="ModalAuthForm_Password" class="col-sm-3 col-form-label"><?=lang('main_auth_modal_passwd');?></label>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal"><?=lang('main_btn_cancel');?></button>
				<button type="submit" class="btn btn-outline-success btn-sm" form="ModalAuthForm"><?=lang('main_btn_login');?></button>
			</div>
		</div>
	</div>
</div>