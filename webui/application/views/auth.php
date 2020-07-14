<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="modal fade" id="ModalAuth" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ModalAuthLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalAuthLabel"><?=lang('main_auth_modal_title');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="ModalAuthForm" method="post" action="/auth/login">
					<div class="form-group row">
						<label for="ModalAuthForm_Login" class="col-sm-3 col-form-label"><?=lang('main_auth_modal_login');?></label>
						<div class="col-sm-9">
							<input type="text" name="login" class="form-control" id="ModalAuthForm_Login" required>
						</div>
					</div>
					<div class="form-group row">
						<label for="ModalAuthForm_Password" class="col-sm-3 col-form-label"><?=lang('main_auth_modal_passwd');?></label>
						<div class="col-sm-9">
							<input type="password" name="password" class="form-control" id="ModalAuthForm_Password" required>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><?=lang('main_btn_cancel');?></button>
				<button type="submit" class="btn btn-success btn-sm" form="ModalAuthForm"><?=lang('main_btn_login');?></button>
			</div>
		</div>
	</div>
</div>
