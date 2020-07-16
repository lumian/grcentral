<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="modal fade" id="ModalNeedApply" tabindex="-1" role="dialog" aria-labelledby="ModalNeedApplyLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalNeedApplyLabel"><?=lang('main_modal_needapply_title');?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-center">
				<div class="spinner-border text-warning" role="status">
					<span class="sr-only">Loading...</span>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#ModalNeedApply').on('show.bs.modal', function (event) {
		var modal = $(this)
		$.ajax({
			url: '<?=site_url("cron/webcron/gencfg/");?>',
			dataType: 'json',
			success: function(data) {
				if (data.query == 'gencfg' && data.result == 'success') {
					modal.find('.modal-body').html('<div class="alert alert-success" role="alert"><?=lang("main_modal_needapply_success");?></div>')
					setTimeout(function() {
						$('#ModalNeedApply').modal('hide');
					}, 3000);
				} else if (data.query == 'gencfg' && data.result == 'error') {
					modal.find('.modal-body').html('<div class="alert alert-danger" role="alert"><?=lang("main_modal_needapply_error");?></div>')
				} else {
					modal.find('.modal-body').html('<div class="alert alert-danger" role="alert"><?=lang("main_error_ajaxload");?></div>')
				}
			},
		});
	})
	
	$('#ModalNeedApply').on('hidden.bs.modal', function () {
		location.reload();
	})
</script>
